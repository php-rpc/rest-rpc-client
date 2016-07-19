<?php

namespace ScayTrase\Api\Rest;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rpc\RpcErrorInterface;
use ScayTrase\Api\Rpc\RpcResponseInterface;

class SyncResponse implements RpcResponseInterface
{
    /** @var  ResponseInterface */
    private $response;
    /** @var DecoderInterface */
    private $decoder;

    /**
     * SyncResponse constructor.
     *
     * @param ResponseInterface $response
     * @param DecoderInterface  $decoder
     */
    public function __construct(ResponseInterface $response, DecoderInterface $decoder)
    {
        $this->response = $response;
        $this->decoder  = $decoder;
    }

    /** @return RpcErrorInterface|null */
    public function getError()
    {
        if ($this->isSuccessful()) {
            return null;
        }

        return new HttpError($this->response->getStatusCode(), $this->response->getReasonPhrase());
    }

    /** @return bool */
    public function isSuccessful()
    {
        $code = $this->response->getStatusCode();

        // https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
        // states successful codes as 2xx
        return $code >= 200 && $code < 300;
    }

    /** @return \stdClass|array|mixed|null */
    public function getBody()
    {
        return $this->decoder->decode($this->response);
    }
}
