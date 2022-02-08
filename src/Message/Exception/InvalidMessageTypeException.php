<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message\Exception;

use Exception;

class InvalidMessageTypeException extends Exception
{
    public function __construct(string $messageType)
    {
        parent::__construct(
            "Message Type ('$messageType') was empty or invalid." . PHP_EOL .
            'This usually means the public constant MESSAGE_TYPE was not defined in the MesssageClass.',
        );
    }
}
