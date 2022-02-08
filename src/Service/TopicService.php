<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Service;

use iDimensionz\AppServer\Message\Base\TextMessage;
use iDimensionz\AppServer\Message\Service\AbstractServiceMessage;
use iDimensionz\AppServer\Topic\TopicManager;

class TopicService extends AbstractService
{
    public static string $serviceName = 'topic';

    /**
     * @inheritDoc
     */
    public function execute(AbstractServiceMessage $message, array $parameters = [])
    {
        $from = $message->getFrom();
        switch ($message->action) {
            case 'create':
                $topicName = trim($parameters[1]);
                if (!empty($topicName)) {
                    $topic = TopicManager::createTopic($topicName);
                    $topic->subscribe($from);
                    $content = "New topic '$topic' was created";
                } else {
                    $content = "Topic '$topicName' is not a valid topic name";
                }
                break;
            case 'list':
                $topicList = TopicManager::list();
                $content = !empty($topicList) ? implode('<br>', $topicList) : 'No topics created yet.';
                break;
            default:
                $content = sprintf("Topic action '%s' is not valid.", $message->action);
                break;
        }
        $responseMessage = new TextMessage($content);
        $this->getAppServer()->debug($content);
        $from->send($responseMessage->getEncodedMessage());
//        $encodedChatMessage = $this->getAppServer()->createEncodedSystemChatMessage($message);
//        $this->getAppServer()->distributeEncodedChatMessage($from, $encodedChatMessage, false);
//        $this->getAppServer()->getClients()->offsetSet($from);
    }
}
