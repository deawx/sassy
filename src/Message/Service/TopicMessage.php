<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message\Service;

class TopicMessage extends AbstractServiceMessage
{
    public const MESSAGE_TYPE = __CLASS__;
    public const TOPIC_SEPARATOR = '.';

    // Base topic can be used to build a topic hierarchy in child classes.
    // (i.e. 'server.some-game') and then topic can be a specific "channel" in that particular game on that particular
    // server
    public string $baseTopic = '';
    public string $topic;

    public function process(): void
    {
        parent::process();
        /**
         * @var AbstractServiceMessage $message
         */
        $message = $this->message;
        $message->service->execute($message, $message->parameters);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $commandData = parent::jsonSerialize();
        $fullyQualifiedTopic = sprintf('%s' . self::TOPIC_SEPARATOR . '%s', $this->baseTopic, $this->topic);
        $topicData = [
            'topic' => $fullyQualifiedTopic,
        ];
        return array_merge($commandData, $topicData);
    }
}
