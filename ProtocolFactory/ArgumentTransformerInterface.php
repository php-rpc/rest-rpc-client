<?php

namespace ScayTrase\Api\Rest\ProtocolFactory;

interface ArgumentTransformerInterface
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function transform($data);
}
