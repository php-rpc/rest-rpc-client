<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator as SymfonyUrlGenerator;

class UrlGenerator extends SymfonyUrlGenerator
{
    /**
     * {@inheritdoc}
     * @throws \LogicException
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (null === $route = $this->routes->get($name)) {
            throw new RouteNotFoundException(
                sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name)
            );
        }

        // the Route has a cache of its own and is not recompiled as long as it does not get modified
        $compiledRoute = $route->compile();

        if ($route instanceof ExtractingRoute) {
            $extractor  = $route->getExtractor();
            $parameters = $extractor->extract($parameters, $compiledRoute, $route);
        }

        return $this->doGenerate(
            $compiledRoute->getVariables(),
            $route->getDefaults(),
            $route->getRequirements(),
            $compiledRoute->getTokens(),
            $parameters,
            $name,
            $referenceType,
            $compiledRoute->getHostTokens(),
            $route->getSchemes()
        );
    }
}
