<?php
namespace ScayTrase\Api\Rest;

use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\Exception\ProtocolException;

interface DecoderInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return mixed|array|\stdClass|null
     * @throws ProtocolException
     */
    public function decode(ResponseInterface $response);
}
