<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message\Base;

use iDimensionz\AppServer\Message\AbstractBaseMessage;
use iDimensionz\AppServer\Topic\TopicManager;
use iDimensionz\AppServer\Traits\DebugTrait;
use Ratchet\ConnectionInterface;

/**
 * A basic message containing textual (string) content.
 */
class TextMessage extends AbstractBaseMessage
{
    use DebugTrait;

    public const MESSAGE_TYPE = self::class;

    public function __construct(?ConnectionInterface $from = null, ?string $message = null)
    {
        parent::__construct($from);
        $this->message = $message;
    }

    public function process(): void
    {
        parent::process();
        // Publish the message on the user's current topic.
        $topic = TopicManager::getTopic($this->getFrom()->currentTopic ?? TopicManager::TOPIC_GENERAL);
        self::debug(__METHOD__ . "/Topic '$topic': '$this->message'");
        $topic->publish($this);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        $messageValues = parent::jsonSerialize();
        return array_merge(
            $messageValues,
            [
                'message' => (string) $this->message,
            ]
        );
    }
}
