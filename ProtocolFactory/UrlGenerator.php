<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use ScayTrase\Api\Rest\ProtocolFactory\Extractor\NoOpExtractor;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator as SymfonyUrlGenerator;

class UrlGenerator extends SymfonyUrlGenerator
{
    /** {@inheritdoc} */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if (null === $route = $this->routes->get($name)) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        if ($route instanceof ExtractingRoute) {
            $parameters = $route->getExtractor()->extract($parameters);
        }

        return parent::generate($name, $parameters, $referenceType);
    }
}
