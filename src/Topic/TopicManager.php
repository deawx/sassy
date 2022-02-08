<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Topic;

use iDimensionz\AppServer\Service\TopicService;
use iDimensionz\AppServer\Traits\DebugTrait;
use Ratchet\ConnectionInterface;

class TopicManager
{
    use DebugTrait;

    public const TOPIC_GENERAL = 'General';

    // @todo Change this to a Collection
    private static array $topics = [];

    public static function createTopic(string $name, ?Topic $parent = null, bool $isPublic = true): Topic
    {
        // @todo Implement "parent" topics.
        if (!self::topicExists($name)) {
            self::$topics[$name] = new Topic($name, $parent, $isPublic);
        }

        return self::$topics[$name];
    }

    public static function topicExists(string $name): bool
    {
        return isset(self::$topics[$name]);
    }

    public static function getTopic(string $name): ?Topic
    {
        return self::topicExists($name) ? self::$topics[$name] : null;
    }

    public static function list(): array
    {
        return array_keys(self::$topics);
    }

    public static function subscribe(ConnectionInterface $from, string $topicName)
    {
        if (static::topicExists($topicName)) {
            $topic = self::getTopic($topicName);
            $topic->subscribe($from);
            // Set the connection's current topic to the topic they just subscribed to.
            $from->currentTopic = $topic;
        } else {
            $message = "Topic '$topicName' does not exist.";
            self::debug($message);
            $from->send($message);
        }
    }
}
