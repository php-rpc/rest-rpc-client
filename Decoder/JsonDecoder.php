<?php

namespace ScayTrase\Api\Rest\Decoder;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\DecoderInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\RpcError;
use ScayTrase\Api\Rest\RpcResponse;
use ScayTrase\Api\Rpc\RpcErrorInterface;

final class JsonDecoder implements DecoderInterface
{
    private $assoc = false;

    /**
     * JsonDecoder constructor.
     *
     * @param bool $assoc
     */
    public function __construct($assoc = false)
    {
        $this->assoc = (bool)$assoc;
    }

    /** {@inheritdoc} */
    public function decode(ResponseInterface $response)
    {
        $result = json_decode($response->getBody(), $this->assoc);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw ProtocolException::decodeFailed(json_last_error_msg());
        }

        return new RpcResponse($result, $this->getError($response));
    }

    /**
     * @param ResponseInterface $response
     *
     * @return RpcErrorInterface|null
     */
    private function getError(ResponseInterface $response)
    {
        $code = $response->getStatusCode();

        // https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
        // states successful codes as 2xx
        if ($code >= 200 && $code < 300) {
            return null;
        }

        return new RpcError($code, $response->getReasonPhrase());
    }
}
