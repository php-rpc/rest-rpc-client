<?php

namespace ScayTrase\Api\Rest;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\StreamDecoratorTrait;
use Psr\Http\Message\StreamInterface;

class StringStream implements StreamInterface
{
    use StreamDecoratorTrait;

    /**
     * @param string $string
     */
    /** @noinspection MagicMethodsValidityInspection */
    public function __construct($string)
    {
        $this->stream = new Stream($this->createStreamForString($string));
    }

    private function createStreamForString($string)
    {
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        rewind($stream);

        return $stream;
    }
}
