<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rpc\RpcRequestInterface;

interface ProtocolFactoryInterface
{
    /**
     * @param RpcRequestInterface $request initial request data
     *
     * @return RequestInterface
     * @throws ProtocolException
     */
    public function encode(RpcRequestInterface $request);

    /**
     * @param ResponseInterface $response
     *
     * @return mixed|array|\stdClass|null
     * @throws ProtocolException
     */
    public function decode(ResponseInterface $response);
}
