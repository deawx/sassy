<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace Tests;

use Phake;
use Ratchet\ConnectionInterface;

class ConnectionTestStub implements ConnectionInterface
{
    /**
     * @var int
     */
    public $resourceId = 123;
    /**
     * @var string
     */
    public $username = '';

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @inheritDoc
     */
    function send($data)
    {
        // TODO: Implement send() method.
        return Phake::mock(ConnectionInterface::class);
    }

    /**
     * @inheritDoc
     */
    function close()
    {
        // TODO: Implement close() method.
    }
}
