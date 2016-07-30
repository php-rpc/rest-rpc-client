<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Decorator;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rest\RpcRequest;
use ScayTrase\Api\Rpc\RpcRequestInterface;
use ScayTrase\Api\Rpc\RpcResponseInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class NormalizingFactory implements ProtocolFactoryInterface
{
    /** @var  ProtocolFactoryInterface */
    private $factory;
    /** @var  NormalizerInterface */
    private $serializer;

    /**
     * NormalizingFactoryDecorator constructor.
     *
     * @param ProtocolFactoryInterface $factory
     * @param NormalizerInterface      $serializer
     */
    public function __construct(ProtocolFactoryInterface $factory, NormalizerInterface $serializer)
    {
        $this->factory    = $factory;
        $this->serializer = $serializer;
    }

    /** {@inheritdoc} */
    public function encode(RpcRequestInterface $request)
    {
        $request = new RpcRequest(
            $request->getMethod(),
            $this->serializer->normalize($request->getParameters())
        );

        return $this->factory->encode($request);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return RpcResponseInterface
     * @throws ProtocolException
     */
    public function decode(ResponseInterface $response)
    {
        return $this->factory->decode($response);
    }
}
