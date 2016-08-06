<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;

final class CallableExtractor implements ArgumentExtractorInterface
{
    /** @var  callable */
    private $callable;

    /**
     * CallableExtractor constructor.
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param mixed         $data
     * @param CompiledRoute $compiledRoute
     * @param Route         $route
     *
     * @return mixed
     */
    public function extractUriArgs($data, CompiledRoute $compiledRoute, Route $route)
    {
        $callable = $this->callable;

        return $callable($data, $compiledRoute, $route);
    }
}
