<?php

namespace ScayTrase\Api\Rest;

use GuzzleHttp\ClientInterface;
use ScayTrase\Api\Rpc\RpcClientInterface;

class RestRpcClient implements RpcClientInterface
{
    /** @var  ClientInterface */
    private $client;
    /** @var  ProtocolFactoryInterface */
    private $matcher;

    /**
     * RestRpcClient constructor.
     *
     * @param ClientInterface          $client
     * @param ProtocolFactoryInterface $factory
     */
    public function __construct(
        ClientInterface $client,
        ProtocolFactoryInterface $factory
    ) {
        $this->client  = $client;
        $this->matcher = $factory;
    }

    /** {@inheritdoc} */
    public function invoke($calls)
    {
        if (!is_array($calls)) {
            $calls = [$calls];
        }

        $containers = [];
        foreach ($calls as $call) {
            $promise      = $this->client->sendAsync($this->matcher->encode($call));
            $containers[] = new AsyncContainer($call, $promise);
        }

        return new AsyncResponseCollection($containers, $this->matcher);
    }
}
