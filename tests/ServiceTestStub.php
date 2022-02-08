<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace Tests;

use iDimensionz\AppServer\Message\Service\AbstractServiceMessage;
use iDimensionz\AppServer\Server\AbstractAppServer;
use iDimensionz\AppServer\Service\AbstractService;

class ServiceTestStub extends AbstractService
{
    public static string $serviceName = 'test';
    public const TEST_DESCRIPTION = 'Description of command test stub';
    public const TEST_HELP = 'Help message for command test stub';
    public const TEST_OUTPUT = 'Congratulations!';

    /**
     * ServiceTestStub constructor.
     * @param AbstractAppServer $chatServer
     */
    public function __construct(AbstractAppServer $chatServer)
    {
        parent::__construct($chatServer);
        $this->setDescription(self::TEST_DESCRIPTION);
        $this->setHelp(self::TEST_HELP);
    }

    /**
     * @inheritDoc
     */
    public function execute(AbstractServiceMessage $message, array $parameters = [])
    {
        $message->getFrom()->send(self::TEST_OUTPUT);
    }

    public function getChatServer(): AbstractAppServer
    {
        return parent::getAppServer();
    }
}
