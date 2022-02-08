<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Event\Message;

use iDimensionz\AppServer\Message\MessageInterface;
use iDimensionz\AppServer\Message\Service\AbstractServiceMessage;
use iDimensionz\AppServer\Server\AppServerInterface;
use iDimensionz\AppServer\Service\ServiceFactory;
use iDimensionz\AppServer\Service\ServiceInterface;
use Ratchet\ConnectionInterface;

class PreProcessMessageEvent extends AbstractMessageEvent
{
    public const NAME = 'message.process.pre';

    protected ServiceInterface $service;

    public function __construct(
        AppServerInterface $server,
        ConnectionInterface $connection,
        MessageInterface $message
    ) {
        parent::__construct($server, $connection, $message);
        if ($message instanceof AbstractServiceMessage) {
            /**
             * @var ServiceInterface $service
             */
            $service = ServiceFactory::getInstance($message->serviceName);
            $message->setService($service);
        }
    }
}
