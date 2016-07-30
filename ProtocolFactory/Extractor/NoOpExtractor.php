<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;

final class NoOpExtractor implements ArgumentExtractorInterface
{
    /** {@inheritdoc} */
    public function extract($data)
    {
        return $data;
    }
}
