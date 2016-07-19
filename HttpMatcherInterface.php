<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\RequestInterface;
use ScayTrase\Api\Rest\Exception\MatcherException;
use ScayTrase\Api\Rpc\RpcRequestInterface;

interface HttpMatcherInterface
{
    /**
     * @param RpcRequestInterface $request initial request data
     * @param EncoderInterface    $encoder protocol to convert the http request body
     *
     * @return RequestInterface
     * @throws MatcherException
     */
    public function match(RpcRequestInterface $request, EncoderInterface $encoder);
}
