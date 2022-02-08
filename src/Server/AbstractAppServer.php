<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Server;

use Exception;
use iDimensionz\AppServer\Event\Message\PostProcessMessageEvent;
use iDimensionz\AppServer\Event\Message\PreProcessMessageEvent;
use iDimensionz\AppServer\Event\Server\ConnectionPostOpenEvent;
use iDimensionz\AppServer\Event\Server\ConnectionPreOpenEvent;
use iDimensionz\AppServer\Message\Base\SystemMessage;
use iDimensionz\AppServer\Message\Base\TextMessage;
use iDimensionz\AppServer\Message\Exception\MessageNotFoundException;
use iDimensionz\AppServer\Message\MessageFactory;
use iDimensionz\AppServer\Message\MessageInterface;
use iDimensionz\AppServer\Subscriber\MessageProcessSubscriber;
use iDimensionz\AppServer\Subscriber\ServerConnectOnOpenSubscriber;
use iDimensionz\AppServer\Topic\TopicManager;
use iDimensionz\AppServer\Traits\DebugTrait;
use Ratchet\ConnectionInterface;
use SplObjectStorage;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class AbstractAppServer implements AppServerInterface
{
    use DebugTrait;

    public const USER_NAME_SYSTEM = 'Sassy App Server';

    protected EventDispatcher $dispatcher;
    protected SplObjectStorage $clients;

    public function __construct()
    {
        self::debug('Starting server...');
        $this->dispatcher = new EventDispatcher();
        $this->registerSubscribers();
        $this->clients = new SplObjectStorage();
        $this->registerMessages();
        TopicManager::createTopic(TopicManager::TOPIC_GENERAL);
        self::debug('Topics: ' . implode(', ', TopicManager::list()));
        // @todo Add server.started event.
        self::debug('Server started');
    }

    public function onOpen(ConnectionInterface $conn)
    {
        self::debug(__METHOD__ . '/Dispatching PreOpen event');
        $this->dispatcher->dispatch(new ConnectionPreOpenEvent($this, $conn), ConnectionPreOpenEvent::NAME);
        self::debug(__METHOD__ . "/Attaching connection {$conn->resourceId}");
        $this->clients->attach($conn);
        self::debug(__METHOD__ . '/Dispatching PostOpen event');
        $this->dispatcher->dispatch(new ConnectionPostOpenEvent($this, $conn), ConnectionPostOpenEvent::NAME);
        self::debug('New connection');
    }

    public function onClose(ConnectionInterface $conn)
    {
        // @todo Add server.connection.closed event
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $this->debug(sprintf("An error has occurred on connection %d: %s", $conn->resourceId, $e->getMessage()));
        // @todo Add server.connection.error event
        $conn->close();
    }

    /**
     * @param string $msg
     * @throws MessageNotFoundException
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        self::debug(__METHOD__ . "/Processing message: '$msg'");
        // @todo Add message.received event.
        try {
            $message = MessageFactory::getInstance($msg, $from);
            if (!is_null($message)) {
                $this->processMessage($from, $message);
            }
        } catch (MessageNotFoundException $mnf) {
            $this->debug($mnf->getMessage());
            throw $mnf;
        }
    }

    protected function processMessage(ConnectionInterface $from, MessageInterface $message)
    {
        $this->dispatcher->dispatch(new PreProcessMessageEvent($this, $from, $message), PreProcessMessageEvent::NAME);
        $message->process();
        $this->dispatcher->dispatch(new PostProcessMessageEvent($this, $from, $message), PostProcessMessageEvent::NAME);
    }

    /**
     * @inheritDoc
     */
    public function registerMessages()
    {
        MessageFactory::registerClass(SystemMessage::class);
        MessageFactory::registerClass(TextMessage::class);
        // @todo Add a server.messages.register event.
    }

    public function registerMessage(string $className)
    {
        MessageFactory::registerClass($className);
    }

    public function getValidMessages(): array
    {
        return MessageFactory::getValidClasses();
    }

    /**
     * @return SplObjectStorage
     */
    public function getClients(): SplObjectStorage
    {
        return $this->clients;
    }

    public function registerSubscribers()
    {
        $this->dispatcher->addSubscriber(new ServerConnectOnOpenSubscriber());
        $this->dispatcher->addSubscriber(new MessageProcessSubscriber());
        $eventListeners = $this->dispatcher->getListeners();
        foreach ($eventListeners as $eventName => $subscribers) {
            $subscriberCount = count($subscribers);
            self::debug("$eventName has {$subscriberCount} subscribers registered");
        };
    }
}
