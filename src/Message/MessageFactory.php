<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message;

use iDimensionz\AppServer\AbstractFactory;
use iDimensionz\AppServer\Message\Exception\InvalidMessageTypeException;
use InvalidArgumentException;
use Ratchet\ConnectionInterface;

class MessageFactory extends AbstractFactory
{
    protected static string $interfaceClassName = MessageInterface::class;

    public static function getInstance(string $jsonMessage, ?ConnectionInterface $from = null): ?MessageInterface
    {
        $instance = null;
        $decodedMessage = json_decode($jsonMessage, true);
        $messageType = '';
        if (!is_array($decodedMessage)) {
            self::debug('Message could not be decoded');
            self::debug(json_last_error_msg());
        } else {
            if ($decodedMessage['messageType']) {
                $messageType = $decodedMessage['messageType'];
            } else {
                self::debug('Message type not specified');
            }
        }
        if (self::isValidClass($messageType)) {
            try {
                $instance = static::createInstance($messageType, $from);
                static::hydrateInstanceProperties($decodedMessage, $instance);
            } catch (InvalidMessageTypeException | InvalidArgumentException $e) {
                static::debug($e->getMessage());
            }
        } else {
            self::debug("Invalid message type: '$messageType'");
        }
        return $instance;
    }

    protected static function addValidInstance(string $className): void
    {
        static::$validInstances[$className::MESSAGE_TYPE] = $className;
    }

    /**
     * Called by getInstance() to set the properties of the instance from the message.
     */
    protected static function hydrateInstanceProperties(array $decodedMessage, $instance): void
    {
        if (!is_null($instance)) {
            // Hydrate the instance properties.
            foreach ($decodedMessage as $propertyName => $propertyValue) {
                if (property_exists($instance, $propertyName)) {
                    $instance->$propertyName = $propertyValue;
                }
            }
        }
    }

    protected static function createInstance(string $messageType, ?ConnectionInterface $from = null)
    {
        if (!$from instanceof ConnectionInterface) {
            throw new InvalidArgumentException(__METHOD__ . "/'From' must be an instance of ConnectionInterface");
        }
        // Create an instance of the class
        return self::isValidInstance($messageType) ?: new self::$validClasses[$messageType]($from);
    }
}
