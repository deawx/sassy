<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Subscriber;

use iDimensionz\AppServer\Event\Message\PostProcessMessageEvent;
use iDimensionz\AppServer\Event\Message\PreProcessMessageEvent;
use iDimensionz\AppServer\Message\Service\TopicMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageProcessSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            PreProcessMessageEvent::NAME => 'preProcess',
            PostProcessMessageEvent::NAME => 'postProcess'
        ];
    }

    public function postProcess()
    {
    }

    public function preProcess(PreProcessMessageEvent $event)
    {
        $message = $event->getMessage();
        if ($message instanceof TopicMessage) {

        }
    }
}
