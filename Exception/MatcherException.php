<?php
namespace ScayTrase\Api\Rest\Exception;

use ScayTrase\Api\Rpc\Exception\RpcExceptionInterface;

class MatcherException extends \RuntimeException implements RpcExceptionInterface
{
    public static function encoderFailed($message)
    {
        return new static(sprintf('Cannot create request - encoder failed: %s', $message));
    }
}
