<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Event\Message;

use iDimensionz\AppServer\Event\AbstractServerEvent;
use iDimensionz\AppServer\Message\MessageInterface;
use iDimensionz\AppServer\Server\AppServerInterface;
use Ratchet\ConnectionInterface;
use React\Socket\ServerInterface;

class AbstractMessageEvent extends AbstractServerEvent
{
    protected MessageInterface $message;

    public function __construct(AppServerInterface $server, ConnectionInterface $connection, MessageInterface $message)
    {
        parent::__construct($server, $connection);
        $this->message = $message;
    }

    public function getMessage(): MessageInterface
    {
        return $this->message;
    }
}
