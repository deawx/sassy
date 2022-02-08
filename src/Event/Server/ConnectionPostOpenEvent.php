<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Event\Server;

use iDimensionz\AppServer\Event\AbstractServerEvent;

class ConnectionPostOpenEvent extends AbstractServerEvent
{
    public const NAME = 'server.connection.open.post';
}
