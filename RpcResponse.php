<?php
namespace ScayTrase\Api\Rest;

use ScayTrase\Api\Rpc\RpcErrorInterface;
use ScayTrase\Api\Rpc\RpcResponseInterface;

/** @internal */
final class RpcResponse implements RpcResponseInterface
{
    /** @var  \stdClass|array|mixed|null */
    private $body;
    /** @var  RpcErrorInterface */
    private $error;

    /**
     * ResponseImpl constructor.
     *
     * @param array|mixed|null|\stdClass $body
     * @param RpcErrorInterface          $error
     */
    public function __construct($body, RpcErrorInterface $error = null)
    {
        $this->body  = $body;
        $this->error = $error;
    }

    /** {@inheritdoc} */
    public function getError()
    {
        return $this->error;
    }

    /** {@inheritdoc} */
    public function getBody()
    {
        if ($this->isSuccessful()) {
            return $this->body;
        }

        return null;
    }

    /** {@inheritdoc} */
    public function isSuccessful()
    {
        return null === $this->error;
    }
}
