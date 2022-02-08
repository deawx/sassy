<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer\Message\Service;

use iDimensionz\AppServer\Message\AbstractBaseMessage;
use iDimensionz\AppServer\Service\ServiceInterface;

class AbstractServiceMessage extends AbstractBaseMessage
{
    public ?string $serviceName = null;
    public ?string $action = null;
    public array $parameters = [];
    protected ?ServiceInterface $service;

    public function __construct(?ServiceInterface $topicService = null)
    {
        parent::__construct();
        $this->service = $topicService;
    }

    public function setService(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'serviceName' => $this->serviceName,
            'action' => $this->action,
            'parameters' => $this->parameters,
        ];
    }
}
