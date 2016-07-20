<?php
namespace ScayTrase\Api\Rest\ProtocolFactory;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\DecoderInterface;
use ScayTrase\Api\Rest\EncoderInterface;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;

final class NaiveFactory implements ProtocolFactoryInterface
{
    const ROOT_URI = '/';

    /** @var  string */
    private $baseUrl;
    /** @var  EncoderInterface */
    private $encoder;
    /** @var DecoderInterface */
    private $decoder;

    /**
     * NaiveRequestFactory constructor.
     *
     * @param EncoderInterface $encoder
     * @param DecoderInterface $decoder
     * @param string           $baseUrl
     */
    public function __construct(EncoderInterface $encoder, DecoderInterface $decoder, $baseUrl = self::ROOT_URI)
    {
        $this->encoder = $encoder;
        $this->decoder = $decoder;
        $this->baseUrl = $baseUrl;
    }

    /** {@inheritdoc} */
    public function encode(RpcRequestInterface $request)
    {
        return $this->encoder->encode(
            new Request('POST', $this->baseUrl.$request->getMethod()),
            $request->getParameters()
        );
    }

    /** {@inheritdoc} */
    public function decode(ResponseInterface $response)
    {
        return $this->decoder->decode($response);
    }
}
