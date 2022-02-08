<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Event;

use iDimensionz\AppServer\Server\AppServerInterface;
use Ratchet\ConnectionInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AbstractServerEvent extends Event
{
    protected ConnectionInterface $connection;
    protected AppServerInterface $server;

    public function __construct(AppServerInterface $server, ConnectionInterface $connection)
    {
        $this->server = $server;
        $this->connection = $connection;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function getServer(): AppServerInterface
    {
        return $this->server;
    }
}
