<?php

namespace ScayTrase\Api\Rest\Tests;

use GuzzleHttp\Psr7\Response;
use ScayTrase\Api\Rest\Decoder\JsonDecoder;
use ScayTrase\Api\Rest\Encoder\JsonEncoder;
use ScayTrase\Api\Rest\Matcher\NaiveMatcher;
use ScayTrase\Api\Rest\RestRpcClient;
use ScayTrase\Api\Rpc\RpcRequestInterface;

class BasicJsonApiTest extends GuzzleAwareTestCase
{
    public function testRpcClient()
    {
        $client = new RestRpcClient($this->getClient(), new NaiveMatcher(), new JsonEncoder(), new JsonDecoder());

        $request = $this->prophesize(RpcRequestInterface::class);
        $request->getMethod()->willReturn('my-test-method');
        $request->getParameters()->willReturn(['a' => 5, 'b' => null, 'c' => false]);
        $rpcRequest = $request->reveal();

        $this->getMockQueue()->append(
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['success' => true]))
        );

        $collection = $client->invoke($rpcRequest);
        $response = $collection->getResponse($rpcRequest);

        self::assertTrue($response->isSuccessful());
        $body = $response->getBody();
        self::assertInstanceOf(\stdClass::class, $body);
        self::assertObjectHasAttribute('success', $body);
        self::assertTrue($body->success);
    }
}
