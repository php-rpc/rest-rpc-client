<?php
namespace ScayTrase\Api\Rest\ProtocolFactory;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use ScayTrase\Api\Rest\DecoderInterface;
use ScayTrase\Api\Rest\EncoderInterface;
use ScayTrase\Api\Rest\ProtocolFactoryInterface;
use ScayTrase\Api\Rpc\RpcRequestInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class RoutedFactory implements ProtocolFactoryInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;
    /** @var EncoderInterface */
    private $encoder;
    /** @var DecoderInterface */
    private $decoder;

    /**
     * RoutedFactory constructor.
     *
     * @param UrlGeneratorInterface $generator
     * @param EncoderInterface      $encoder
     * @param DecoderInterface      $decoder
     */
    public function __construct(UrlGeneratorInterface $generator, EncoderInterface $encoder, DecoderInterface $decoder)
    {
        $this->generator = $generator;
        $this->encoder   = $encoder;
        $this->decoder   = $decoder;
    }


    /** {@inheritdoc} */
    public function encode(RpcRequestInterface $request)
    {
        $path = $this->generator->generate($request->getMethod(), $request->getParameters());

        return $this->encoder->encode(new Request('POST', $path), $request->getParameters());
    }

    /** {@inheritdoc} */
    public function decode(ResponseInterface $response)
    {
        return $this->decoder->decode($response);
    }
}
