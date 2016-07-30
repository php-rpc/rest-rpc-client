<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Transformer;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentTransformerInterface;

final class NoopTransformer implements ArgumentTransformerInterface
{
    /** {@inheritdoc} */
    public function transform($data)
    {
        return $data;
    }
}
