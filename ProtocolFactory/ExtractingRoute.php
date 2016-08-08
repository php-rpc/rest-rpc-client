<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use ScayTrase\Api\Rest\ProtocolFactory\Extractor\CallableExtractor;
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
     * @param Route                               $route
     * @param callable|ArgumentExtractorInterface $extractor
     *
     * @return static
     */
    public static function decorate(Route $route, $extractor = null)
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

        if (is_callable($extractor)) {
            $extractor = new CallableExtractor($extractor);
        }

        $decorator->route     = $route;
        $decorator->extractor = $extractor ?:
            new CallableExtractor(
                function ($data) {
                    return $data;
                }
            );

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
