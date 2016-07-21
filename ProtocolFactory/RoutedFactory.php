<?php
namespace ScayTrase\Api\Rest\ProtocolFactory;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;

final class RoutedFactory implements ProtocolFactoryInterface
{
    /** {@inheritdoc} */
    public function encode(RpcRequestInterface $request)
    {
        // TODO: Implement encode() method.
    }

    /** {@inheritdoc} */
    public function decode(ResponseInterface $response)
    {
        // TODO: Implement decode() method.
    }
}
