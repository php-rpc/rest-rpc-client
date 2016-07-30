<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

use ScayTrase\Api\Rest\ProtocolFactory\Transformer\NoopTransformer;
use Symfony\Component\Routing\Generator\UrlGenerator as SymfonyUrlGenerator;

class UrlGenerator extends SymfonyUrlGenerator
{
    protected $transformers;

    /** {@inheritdoc} */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $transformer = array_key_exists($name, $this->transformers) ?
            $this->transformers[$name] :
            new NoopTransformer();

        $routeParameters = $transformer->transform($parameters);

        return parent::generate($name, $routeParameters, $referenceType);
    }

    public function registerTransformer($name, ArgumentTransformerInterface $transformer)
    {
        $this->transformers[$name] = $transformer;
    }
}
