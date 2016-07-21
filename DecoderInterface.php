<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rpc\RpcResponseInterface;

interface DecoderInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return RpcResponseInterface
     * @throws ProtocolException
     */
    public function decode(ResponseInterface $response);
}
