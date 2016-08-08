<?php
namespace ScayTrase\Api\Rest;

use ScayTrase\Api\Rpc\RpcErrorInterface;

/** @internal */
final class RpcError implements RpcErrorInterface
{
    /** @var  int */
    private $code;
    /** @var  string */
    private $message;

    /**
     * HttpError constructor.
     *
     * @param int    $code
     * @param string $message
     */
    public function __construct($code, $message)
    {
        $this->code    = (int)$code;
        $this->message = (string)$message;
    }


    /** {@inheritdoc} */
    public function getCode()
    {
        return $this->code;
    }

    /** {@inheritdoc} */
    public function getMessage()
    {
        return $this->message;
    }

    public function __toString()
    {
        return sprintf('%d %s', $this->code, $this->message);
    }
}
