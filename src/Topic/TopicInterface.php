<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Topic;

use iDimensionz\AppServer\Message\MessageInterface;
use Ratchet\ConnectionInterface;

interface TopicInterface
{
    public function publish(MessageInterface $message);

    public function subscribe(ConnectionInterface $subscriber);

    public function getSubscribers();

    public function getSubscriberCount();

    public function isSubscribed(ConnectionInterface $subscriber): bool;
}
