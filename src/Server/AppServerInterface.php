<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Server;

use Ratchet\MessageComponentInterface;
use iDimensionz\AppServer\Message\MessageInterface;

interface AppServerInterface extends MessageComponentInterface
{
    /**
     * Add message classes that this server can process.
     * @todo Refactor to register all the classes in specified message directories or namespaces.
     */
    public function registerMessages();

    /**
     * Add a single message class to the list of classes that this server can process.
     */
    public function registerMessage(string $className);

    /**
     * @return MessageInterface[]|array
     */
    public function getValidMessages(): array;
}