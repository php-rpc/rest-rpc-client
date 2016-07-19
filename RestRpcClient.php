<?php

namespace ScayTrase\Api\Rest;

use GuzzleHttp\ClientInterface;
use ScayTrase\Api\Rpc\RpcClientInterface;

class RestRpcClient implements RpcClientInterface
{
    /** @var  ClientInterface */
    private $client;
    /** @var  HttpMatcherInterface */
    private $matcher;
    /** @var  EncoderInterface */
    private $encoder;
    /** @var  DecoderInterface */
    private $decoder;

    /**
     * RestRpcClient constructor.
     *
     * @param ClientInterface      $client
     * @param HttpMatcherInterface $matcher
     * @param EncoderInterface     $encoder
     * @param DecoderInterface     $decoder
     */
    public function __construct(
        ClientInterface $client,
        HttpMatcherInterface $matcher,
        EncoderInterface $encoder,
        DecoderInterface $decoder
    ) {
        $this->client  = $client;
        $this->matcher = $matcher;
        $this->encoder = $encoder;
        $this->decoder = $decoder;
    }

    /** {@inheritdoc} */
    public function invoke($calls)
    {
        if (!is_array($calls)) {
            $calls = [$calls];
        }

        $containers = [];
        foreach ($calls as $call) {
            $promise      = $this->client->sendAsync($this->matcher->match($call, $this->encoder));
            $containers[] = new AsyncContainer($call, $promise);
        }

        return new AsyncResponseCollection($containers, $this->decoder);
    }
}
