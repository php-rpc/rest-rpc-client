<?php

namespace ScayTrase\Api\Rest\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

abstract class GuzzleAwareTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  ClientInterface */
    private $client;
    /** @var  MockHandler */
    private $mock;

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return MockHandler
     */
    public function getMockQueue()
    {
        return $this->mock;
    }

    protected function setUp()
    {
        $this->mock = new MockHandler();
        $stack      = new HandlerStack($this->mock);

        $this->client = new Client(['handler' => $stack]);
    }
}
