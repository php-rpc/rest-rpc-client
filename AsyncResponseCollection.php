<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rpc\ResponseCollectionInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;

class AsyncResponseCollection implements \IteratorAggregate, ResponseCollectionInterface
{
    /** @var AsyncContainer[] */
    private $containers;
    /** @var ProtocolFactoryInterface */
    private $factory;

    /**
     * AsyncResponseCollection constructor.
     *
     * @param AsyncContainer[]         $containers
     * @param ProtocolFactoryInterface $factory
     */
    public function __construct(array $containers, ProtocolFactoryInterface $factory)
    {
        $this->containers = $this->reindex($containers);
        $this->factory    = $factory;
    }

    private function reindex(array $containers)
    {
        $indexed = [];
        foreach ($containers as $container) {
            $indexed[spl_object_hash($container->getRpcRequest())] = $container;
        }

        return $indexed;
    }

    /** {@inheritdoc} */
    public function getIterator()
    {
        foreach ($this->containers as $container) {
            yield $this->getResponse($this->$container->getRpcRequest());
        }
    }

    /** {@inheritdoc} */
    public function getResponse(RpcRequestInterface $request)
    {
        $hash = spl_object_hash($request);
        if (!array_key_exists($hash, $this->containers)) {
            throw new \OutOfBoundsException('Response collection does not contain this request');
        }

        /** @var ResponseInterface $response */
        $response = $this->containers[$hash]->getPromise()->wait();

        return new SyncResponse($response, $this->factory);
    }
}
