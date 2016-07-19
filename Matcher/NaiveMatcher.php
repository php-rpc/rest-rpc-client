<?php
namespace ScayTrase\Api\Rest\Matcher;

use GuzzleHttp\Psr7\Request;
use ScayTrase\Api\Rest\EncoderInterface;
use ScayTrase\Api\Rest\Exception\MatcherException;
use ScayTrase\Api\Rest\Exception\ProtocolException;
use ScayTrase\Api\Rest\HttpMatcherInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;

final class NaiveMatcher implements HttpMatcherInterface
{
    /** {@inheritdoc} */
    public function match(RpcRequestInterface $request, EncoderInterface $encoder)
    {
        try {
            return $encoder->encode(new Request('POST', $request->getMethod()), $request->getParameters());
        } catch (ProtocolException $e) {
            throw MatcherException::encoderFailed($e->getMessage());
        }
    }
}
