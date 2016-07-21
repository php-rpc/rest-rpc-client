<?php

namespace ScayTrase\Api\Rest\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use ScayTrase\Api\Rest\Decoder\JsonDecoder;
use ScayTrase\Api\Rest\Encoder\JsonEncoder;
use ScayTrase\Api\Rest\ProtocolFactory\NaiveFactory;
use ScayTrase\Api\Rpc\RpcResponseInterface;

class BasicJsonApiTest extends RestRpcClientTest
{
    use RpcRequestMockTrait;

    public function getCases()
    {
        $baseUrl = '/';
        $method  = 'namespace/test-method';
        $data    = ['a' => 2, 'b' => 'yes', 'c' => true, 'd' => null];

        return [
            'Naive JSON API' => [
                'request'          => $this->createRequestMock(
                    $method,
                    $data
                ),
                'factory'          => new NaiveFactory(new JsonEncoder(), new JsonDecoder(), $baseUrl),
                'requestVerifier'  => function (RequestInterface $request) use ($method, $data, $baseUrl) {
                    self::assertEquals($data, json_decode($request->getBody(), true));
                    self::assertEquals($baseUrl.$method, $request->getUri()->getPath());

                    return $request;
                },
                'queueUpdater'     => function (MockHandler $mock) {
                    $mock->append(new Response(200, [], json_encode(['success' => true])));
                },
                'responseVerifier' => function (RpcResponseInterface $response) {
                    self::assertTrue($response->isSuccessful());
                    $body = $response->getBody();
                    self::assertNotNull($body);
                    self::assertInstanceOf(\stdClass::class, $body);
                    self::assertObjectHasAttribute('success', $body);
                },
            ],
        ];
    }
}
