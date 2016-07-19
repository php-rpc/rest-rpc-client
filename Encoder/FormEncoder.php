<?php
namespace ScayTrase\Api\Rest\Encoder;

use Psr\Http\Message\RequestInterface;
use ScayTrase\Api\Rest\EncoderInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\StringStream;

final class FormEncoder implements EncoderInterface
{
    /** {@inheritdoc} */
    public function encode(RequestInterface $request, $payload)
    {
        try {
            return $request->withBody(new StringStream(http_build_query($payload)));
        } catch (\InvalidArgumentException $e) {
            throw ProtocolException::encodeFailed($e->getMessage());
        }
    }
}
