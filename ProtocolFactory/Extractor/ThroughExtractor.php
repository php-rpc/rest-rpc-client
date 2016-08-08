<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;

class ThroughExtractor implements ArgumentExtractorInterface
{
    /** {@inheritdoc} */
    public function extractUriArgs($data, CompiledRoute $compiledRoute, Route $route)
    {
        return $data;
    }
}
