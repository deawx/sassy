<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use iDimensionz\AppServer\WebSocketAppServer;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketAppServer()
        )
    ),
    8080
);

$server->run();
