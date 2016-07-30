<?php
namespace ScayTrase\Api\Rest;

use ScayTrase\Api\Rpc\RpcRequestInterface;

/** @internal */
final class RpcRequest implements RpcRequestInterface
{
    /** @var  string */
    private $method;
    /** @var  \stdClass|array|null */
    private $parameters;

    /**
     * RpcRequest constructor.
     *
     * @param string               $method
     * @param \stdClass|array|null $parameters
     */
    public function __construct($method, $parameters)
    {
        $this->method     = $method;
        $this->parameters = $parameters;
    }

    /** {@inheritdoc} */
    public function getMethod()
    {
        return $this->method;
    }

    /** {@inheritdoc} */
    public function getParameters()
    {
        return $this->parameters;
    }
}
