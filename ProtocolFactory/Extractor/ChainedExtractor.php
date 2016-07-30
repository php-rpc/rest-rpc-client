<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;

final class ChainedExtractor implements ArgumentExtractorInterface
{
    /**
     * @var ArgumentExtractorInterface[]
     */
    private $extractors = [];

    /**
     * ChainedExtractor constructor.
     *
     * @param array $extractors
     */
    public function __construct(array $extractors)
    {
        $this->extractors = $extractors;
    }

    /**
     * @param mixed         $data
     * @param CompiledRoute $compiledRoute
     * @param Route         $route
     *
     * @return mixed
     */
    public function extract($data, CompiledRoute $compiledRoute, Route $route)
    {
        foreach ($this->extractors as $extractor) {
            $data = $extractor->extract($data, $compiledRoute, $route);
        }

        return $data;
    }
}
