<?php

namespace ScayTrase\Api\Rest\Exception;

use ScayTrase\Api\Rpc\Exception\RpcExceptionInterface;

class ProtocolException extends \RuntimeException implements RpcExceptionInterface
{
    public static function encodeFailed($message)
    {
        return new static(sprintf('Message encoding failed: %s', $message));
    }

    public static function decodeFailed($message)
    {
        return new static(sprintf('Message decoding failed: %s', $message));
    }
}
