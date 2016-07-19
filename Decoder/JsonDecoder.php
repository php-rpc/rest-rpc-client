<?php

namespace ScayTrase\Api\Rest\Decoder;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\DecoderInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;

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


    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    public function decode(ResponseInterface $response)
    {
        $result = json_decode($response->getBody(), $this->assoc);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw ProtocolException::decodeFailed(json_last_error_msg());
        }

        return $result;
    }
}
