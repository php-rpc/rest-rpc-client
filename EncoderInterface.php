<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\RequestInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;

interface EncoderInterface
{
    /**
     * @param RequestInterface $request The request to modify
     * @param mixed            $payload Payload to convert to the request body
     *
     * @return RequestInterface
     * @throws ProtocolException
     */
    public function encode(RequestInterface $request, $payload);
}
