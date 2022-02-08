<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Service;

use iDimensionz\AppServer\Server\AbstractAppServer;

abstract class AbstractService implements ServiceInterface
{
    public static string $serviceName = 'abstract';

    private AbstractAppServer $appServer;
    private string $description;
    private string $help;

    public function __construct(AbstractAppServer $appServer)
    {
        $this->setAppServer($appServer);
    }

    /**
     * @inheritDoc
     */
    public static function getServiceName(): string
    {
        return static::$serviceName;
    }

    protected function getAppServer(): AbstractAppServer
    {
        return $this->appServer;
    }

    /**
     * @param AbstractAppServer $appServer
     */
    public function setAppServer(AbstractAppServer $appServer): void
    {
        $this->appServer = $appServer;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getHelp(): string
    {
        return $this->help;
    }

    /**
     * @param string $help
     */
    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return static::$serviceName;
    }
}
