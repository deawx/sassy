<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Subscriber;

use iDimensionz\AppServer\Event\Server\ConnectionPostOpenEvent;
use iDimensionz\AppServer\Event\Server\ConnectionPreOpenEvent;
use iDimensionz\AppServer\Message\Base\TextMessage;
use iDimensionz\AppServer\Topic\TopicManager;
use iDimensionz\AppServer\Traits\DebugTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ServerConnectOnOpenSubscriber implements EventSubscriberInterface
{
    use DebugTrait;

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConnectionPreOpenEvent::NAME => 'preOpen',
            ConnectionPostOpenEvent::NAME => 'postOpen'
        ];
    }

    public function preOpen(ConnectionPreOpenEvent $event)
    {
        self::debug(__METHOD__ . '/BEGIN');
        $connection = $event->getConnection();
        $connection->username = "id {$connection->resourceId}";

        $content = "New connection! ($connection->resourceId)";
        self::debug($content);
        TopicManager::subscribe($connection, TopicManager::TOPIC_GENERAL);
        self::debug("Connection subscribed to '{$connection->currentTopic}'");
        self::debug(__METHOD__ . '/END');
// @todo Move this to chat server listener
        TopicManager::getTopic(TopicManager::TOPIC_GENERAL)->publish((new TextMessage($connection, $content)));
    }

    public function postOpen(ConnectionPostOpenEvent $event)
    {
// @todo Move this to chat server listener
//        // Send all the existing messages to the new user.
//        $connection = $event->getConnection();
//        /**
//         * @var MessageInterface $message
//         */
//        foreach (TopicManager::getTopic(AbstractAppServer::TOPIC_GENERAL)->getMessages() as $message) {
//            $connection->send($message->getEncodedMessage());
//        }
    }
}
