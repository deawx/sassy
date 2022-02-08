<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message;

use iDimensionz\AppServer\Message\Exception\InvalidMessageTypeException;
use Ratchet\ConnectionInterface;
use Symfony\Component\Uid\Ulid;

abstract class AbstractBaseMessage implements MessageInterface
{
    // This is the unique name that is used to identify a message. Suggest using the fully qualified class name.
    public const MESSAGE_TYPE = '';

    /**
     * @see https://symfony.com/doc/current/components/uid.html#ulids for more info about ULIDs.
     * ULIDs are 128-bit numbers usually represented as a 26-character string: TTTTTTTTTTRRRRRRRRRRRRRRRR
     * (where T represents a timestamp and R represents the random bits).
     * The date the message was created can be obtained from the ULID.
     */
    protected Ulid $uniqueId;
    /**
     * @var mixed For now, leaving type as mixed but may define it as a string so that it will always be a JSON object
     */
    public $message;
    protected ?ConnectionInterface $from = null;
// @todo Move userName to chat server
//    public ?string $userName;

    public function __construct(?ConnectionInterface $from = null)
    {
        $this->from = $from;
        $this->uniqueId = new Ulid();
        if (empty(static::MESSAGE_TYPE)) {
            throw new InvalidMessageTypeException(static::class);
        }
    }

    public function process(): void
    {
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    public function getFrom(): ConnectionInterface
    {
        return $this->from;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array|object data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'uniqueId' => $this->uniqueId,
            'created' => $this->uniqueId->getDateTime()->format('Y-m-d H:i:s'),
            'messageType' => static::MESSAGE_TYPE,
            'sentDate' => $this->uniqueId->getDateTime()->format('Y-m-d H:i:s'), // for chat server
            'userName' => $this->from->resourceId // for chat server
        ];
    }

    public function getEncodedMessage(): string
    {
        return json_encode($this);
    }

    public function __toString()
    {
        return json_encode($this->message);
    }
}
