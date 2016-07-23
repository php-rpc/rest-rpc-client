<?php
namespace ScayTrase\Api\Rest\Tests;

use ScayTrase\Api\Rest\Decoder\JsonDecoder;
use ScayTrase\Api\Rest\Encoder\JsonEncoder;
use ScayTrase\Api\Rest\ProtocolFactory\RoutedFactory;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RoutedFactoryTest extends \PHPUnit_Framework_TestCase
{
    const PLAIN_METHOD = 'namespace/plain-method-with-argument';

    use RpcRequestMockTrait;

    public function testRequestGeneration()
    {
        $collection = new RouteCollection();
        $collection->add(
            self::PLAIN_METHOD,
            new Route(
                'namespace/{argument}/method',
                [],
                [
                    'argument' => '.+',
                ]
            )
        );

        $generator = new UrlGenerator($collection, new RequestContext());
        $factory   = new RoutedFactory($generator, new JsonEncoder(), new JsonDecoder());

        $data    = ['argument' => 'value'];
        $request = $factory->encode($this->createRequestMock(self::PLAIN_METHOD, $data));
        self::assertSame('/namespace/value/method', $request->getUri()->getPath());
        self::assertSame(json_encode($data), (string)$request->getBody());
    }
}
