<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Topic;

use iDimensionz\AppServer\Message\MessageInterface;
use iDimensionz\AppServer\Traits\DebugTrait;
use Ratchet\ConnectionInterface;
use SplObjectStorage;
use Stringable;

abstract class AbstractTopic implements TopicInterface, Stringable
{
    use DebugTrait;

    private string $name;
    // Indicates if the topic can be seen and accessed "freely" (i.e. without authentication)
    private bool $isPublic;
    private SplObjectStorage $subscribers;
    private ?Topic $parent = null;
    private array $messages = [];

    public function __construct(string $name, ?Topic $parent = null, bool $isPublic = true)
    {
        $this->name = $name;
        $this->parent = $this->parent ?? $parent;
        $this->isPublic = $isPublic;
        $this->subscribers = new SplObjectStorage();
    }

    public function publish(MessageInterface $message)
    {
        $this->messages[] = $message;
        $encodedMessage = $message->getEncodedMessage();
        $subscriberCount = count($this->subscribers);
        self::debug(__METHOD__ . "/{$subscriberCount} subscribers receiving message '$encodedMessage'");
        /**
         * @var ConnectionInterface $subscriber
         */
        foreach ($this->subscribers as $subscriber) {
            $subscriber->send($encodedMessage);
        }
    }

    public function subscribe(ConnectionInterface $subscriber)
    {
        $this->subscribers->attach($subscriber);
    }

    public function getSubscribers(): SplObjectStorage
    {
        return $this->subscribers;
    }

    public function getSubscriberCount(): int
    {
        return $this->subscribers->count();
    }

    public function isSubscribed(ConnectionInterface $subscriber): bool
    {
        return $this->subscribers->contains($subscriber);
    }

    public function getParent(): ?Topic
    {
        return $this->parent;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function __toString()
    {
        return $this->name;
    }
}
