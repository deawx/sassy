<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer;

use iDimensionz\AppServer\Traits\DebugTrait;

abstract class AbstractFactory
{
    use DebugTrait;

    // List if classes that this factory can create.
    protected static array $validClasses = [];
    // Cached list of instances that this factory has already created. (i.e. Singletons)
    protected static array $validInstances = [];
    protected static string $interfaceClassName;

    public static function isValidClass(string $className): bool
    {
        return in_array($className, static::$validClasses);
    }

    public static function isValidInstance(string $instanceName): bool
    {
        return isset(static::$validInstances[$instanceName]);
    }

    public static function registerClass(string $className)
    {
        if (class_exists($className) && in_array(static::$interfaceClassName, class_implements($className))) {
            static::$validClasses[$className] = $className;
        }
    }

    public static function getValidClasses(): array
    {
        return static::$validClasses;
    }

    public static function getValidInstances(): array
    {
        return static::$validInstances;
    }

    /**
     * @param string $instanceInfo Whatever data the factory needs to create the instance.
     * @return mixed
     */
    abstract public static function getInstance(string $instanceInfo);

    abstract protected static function addValidInstance(string $className);

    /**
     * @param string $instanceName
     * @return mixed|null
     */
    protected static function createInstance(string $instanceName)
    {
        // Create an instance of the class
        return self::isValidInstance($instanceName) ?: new self::$validClasses[$instanceName]();
    }
}
