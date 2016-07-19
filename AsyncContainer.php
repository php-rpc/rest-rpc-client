<?php
namespace ScayTrase\Api\Rest;

use GuzzleHttp\Promise\PromiseInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;

final class AsyncContainer
{
    /** @var  RpcRequestInterface */
    private $call;
    /** @var PromiseInterface */
    private $promise;

    /**
     * ProcessedPackage constructor.
     *
     * @param RpcRequestInterface $call
     * @param PromiseInterface    $promise
     */
    public function __construct(RpcRequestInterface $call, PromiseInterface $promise)
    {
        $this->call    = $call;
        $this->promise = $promise;
    }

    /**
     * @return PromiseInterface
     */
    public function getPromise()
    {
        return $this->promise;
    }

    /**
     * @return RpcRequestInterface
     */
    public function getRpcRequest()
    {
        return $this->call;
    }
}
