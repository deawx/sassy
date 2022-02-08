<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message\Exception;

use Exception;

class MessageNotFoundException extends Exception
{
    public function __construct($serverMessage)
    {
        $message = 'The following message did not have a class to process it: ' . $serverMessage;
        parent::__construct($message);
    }
}
