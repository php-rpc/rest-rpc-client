<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Decorator;

use ScayTrase\Api\Rest\ProtocolFactoryInterface;

class LoggingFactory
{
    /** @var  ProtocolFactoryInterface */
    private $factory;
    /** @var  LogIn */
    private $logger;
}
