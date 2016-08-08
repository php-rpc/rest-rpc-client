<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Decorator;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;
use ScayTrase\Api\Rpc\RpcResponseInterface;

class LoggingFactory implements ProtocolFactoryInterface
{
    /** @var  ProtocolFactoryInterface */
    private $factory;
    /** @var  LoggerInterface */
    private $logger;

    /**
     * LoggingFactory constructor.
     *
     * @param ProtocolFactoryInterface $factory
     * @param LoggerInterface|null     $logger
     */
    public function __construct(ProtocolFactoryInterface $factory, LoggerInterface $logger = null)
    {
        $this->factory = $factory;
        $this->logger  = $logger ?: new NullLogger();
    }


    /**
     * @param RpcRequestInterface $request initial request data
     *
     * @return RequestInterface
     * @throws ProtocolException
     */
    public function encode(RpcRequestInterface $request)
    {
        $this->logger->info('PHP-RPC: encoding request');
        $this->logger->debug($request->getMethod(), json_decode(json_encode($request->getParameters()), true));

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
        $this->logger->info('PHP-RPC: decoding response');
        $this->logger->debug($response->getStatusCode());
        $this->logger->debug($response->getBody(), $response->getHeaders());

        return $this->factory->decode($response);
    }
}
