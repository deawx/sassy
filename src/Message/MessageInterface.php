<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message;

use JsonSerializable;
use Ratchet\ConnectionInterface;
use Stringable;

interface MessageInterface extends JsonSerializable, Stringable
{
    public function getUniqueId(): string;

    public function getFrom(): ConnectionInterface;

    /**
     * @return string The JSON encoded message
     */
    public function getEncodedMessage(): string;

    public function process();
}
