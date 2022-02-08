<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Traits;

trait DebugTrait
{
    /**
     * When debug mode is enabled (i.e. environment variable is set to 1), then echo out message to console.
     * When debug mode is disabled (environment variable not available or not set to 1), don't echo message.
     * @param mixed $message
     */
    public static function debug($message)
    {
        if (1 == getenv('SASSY_SERVER_DEBUG')) {
            echo $message . PHP_EOL;
        }
    }
}