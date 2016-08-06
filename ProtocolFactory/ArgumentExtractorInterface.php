<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;

interface ArgumentExtractorInterface
{
    /**
     * @param mixed         $data
     * @param CompiledRoute $compiledRoute
     * @param Route         $route
     *
     * @return mixed
     */
    public function extractUriArgs($data, CompiledRoute $compiledRoute, Route $route);
}
