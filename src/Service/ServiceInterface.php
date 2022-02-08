<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Service;

use iDimensionz\AppServer\Message\Service\AbstractServiceMessage;
use iDimensionz\AppServer\Server\AbstractAppServer;

interface ServiceInterface
{
    public function __construct(AbstractAppServer $appServer);

    /**
     * Returns the service string that this class responds to.
     */
    public static function getServiceName(): string;

    /**
     * Returns a brief description of what this command does.
     */
    public function getDescription(): string;

    /**
     * Returns help on how to use the command including an example.
     */
    public function getHelp(): string;

    /**
     * Executes the action in the command with the supplied parameters.
     * @return mixed
     */
    public function execute(AbstractServiceMessage $message, array $parameters = []);
}
