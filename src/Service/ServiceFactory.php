<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Service;

use iDimensionz\AppServer\AbstractFactory;
use iDimensionz\AppServer\Server\AppServerInterface;

class ServiceFactory extends AbstractFactory
{
    protected static string $interfaceClassName = ServiceInterface::class;
    protected static ?AppServerInterface $server = null;

    public static function getInstance(string $serviceName)
    {
        // @todo Cache service instances and return a cached instance if available.
        return static::createInstance($serviceName);
    }

    public function setServer(AppServerInterface $server)
    {
        static::$server = $server;
    }

    protected static function addValidInstance(string $className)
    {
        static::$validInstances[$className] = $className;
    }

    protected static function createInstance(string $instanceName)
    {
        return self::isValidInstance($instanceName) ? new self::$validInstances[$instanceName](static::$server) : null;
    }
}
