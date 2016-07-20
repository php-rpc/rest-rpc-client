<?php
namespace ScayTrase\Api\Rest\Tests;

use GuzzleHttp\Middleware;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rest\RestRpcClient;
use ScayTrase\Api\Rpc\RpcRequestInterface;

abstract class RestRpcClientTest extends GuzzleAwareTestCase
{
    /**
     * @dataProvider getCases
     *
     * @param RpcRequestInterface      $request          Initial RPC request
     * @param callable                 $requestVerifier  Verifier of Http Request representation
     * @param callable                 $queueUpdater     Callable to update the queue with necessary HTTP responses
     * @param callable                 $responseVerifier RpcResponse verifier
     * @param ProtocolFactoryInterface $factory          HttpProtocolFactory
     */
    public function testRpcClient(
        RpcRequestInterface $request,
        ProtocolFactoryInterface $factory,
        $requestVerifier,
        $queueUpdater,
        $responseVerifier
    ) {
        $client = new RestRpcClient($this->getClient(), $factory);
        $this->getStack()->push(Middleware::mapRequest($requestVerifier));
        $queueUpdater($this->getMockQueue());
        $collection = $client->invoke($request);
        $response   = $collection->getResponse($request);
        $responseVerifier($response);
    }

    abstract protected function getCases();

    protected function createRequestMock($method, $parameters)
    {
        $request = $this->prophesize(RpcRequestInterface::class);
        $request->getMethod()->willReturn($method);
        $request->getParameters()->willReturn($parameters);

        return $request->reveal();
    }
}
