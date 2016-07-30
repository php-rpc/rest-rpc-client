<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

interface ArgumentExtractorInterface
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function extract($data);
}
