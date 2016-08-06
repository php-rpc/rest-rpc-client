<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class NormalizingExtractor implements ArgumentExtractorInterface
{
    /** @var  NormalizerInterface */
    private $normalizer;
    /** @var  ArgumentExtractorInterface */
    private $extractor;

    /**
     * NormalizingExtractor constructor.
     *
     * @param NormalizerInterface        $normalizer
     * @param ArgumentExtractorInterface $extractor
     */
    public function __construct(NormalizerInterface $normalizer, ArgumentExtractorInterface $extractor)
    {
        $this->normalizer = $normalizer;
        $this->extractor  = $extractor;
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
        return $this->extractor->extractUriArgs(
            $this->normalizer->normalize($data),
            $compiledRoute,
            $route
        );
    }
}
