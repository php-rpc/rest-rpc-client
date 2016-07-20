<?php

namespace ScayTrase\Api\Rest;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rpc\RpcErrorInterface;
use ScayTrase\Api\Rpc\RpcResponseInterface;

class SyncResponse implements RpcResponseInterface
{
    /** @var  ResponseInterface */
    private $response;
    /** @var ProtocolFactoryInterface */
    private $factory;

    /**
     * SyncResponse constructor.
     *
     * @param ResponseInterface        $response
     * @param ProtocolFactoryInterface $factory
     */
    public function __construct(ResponseInterface $response, ProtocolFactoryInterface $factory)
    {
        $this->response = $response;
        $this->factory  = $factory;
    }

    /** @return RpcErrorInterface|null */
    public function getError()
    {
        if ($this->isSuccessful()) {
            return null;
        }

        return new HttpError($this->response->getStatusCode(), $this->response->getReasonPhrase());
    }

    /** {@inheritdoc} */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();

        // https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
        // states successful codes as 2xx
        return $code >= 200 && $code < 300;
    }

    /** {@inheritdoc} */
    public function getBody()
    {
        if (!$this->isSuccessful()) {
            return null;
        }

        return $this->factory->decode($this->response);
    }
}
