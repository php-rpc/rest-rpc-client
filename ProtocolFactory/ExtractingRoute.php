<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use ScayTrase\Api\Rest\ProtocolFactory\Extractor\NoOpExtractor;
use Symfony\Component\Routing\Route;

final class ExtractingRoute extends Route
{
    /** @var  Route */
    private $route;
    /** @var  ArgumentExtractorInterface */
    private $extractor;

    /**
     * TransformedRoute constructor.
     *
     * @param Route                      $route
     * @param ArgumentExtractorInterface $extractor
     *
     * @return static
     */
    public static function decorate(Route $route, ArgumentExtractorInterface $extractor = null)
    {
        $decorator = new static(
            $route->getPath(),
            $route->getDefaults(),
            $route->getRequirements(),
            $route->getOptions(),
            $route->getHost(),
            $route->getSchemes(),
            $route->getMethods(),
            $route->getCondition()
        );

        $decorator->route     = $route;
        $decorator->extractor = $extractor ?: new NoOpExtractor();

        return $decorator;
    }

    /**
     * @return ArgumentExtractorInterface
     */
    public function getExtractor()
    {
        return $this->extractor;
    }
}
