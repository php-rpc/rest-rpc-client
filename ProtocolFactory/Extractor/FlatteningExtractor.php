<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Routing\CompiledRoute;
use Symfony\Component\Routing\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class FlatteningExtractor implements ArgumentExtractorInterface
{
    const KEY_SEPARATOR = '_';

    /** @var  NormalizerInterface */
    private $normalizer;

    /**
     * FlatteningTransformer constructor.
     *
     * @param NormalizerInterface $normalizer
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /** {@inheritdoc} */
    public function extract($data, CompiledRoute $compiledRoute, Route $route)
    {
        if (is_scalar($data)) {
            return $data;
        }

        $result = [];

        $this->flatten($data, $result);

        return $result;
    }

    /**
     * @param mixed       $data
     * @param array       $result
     * @param string|null $key
     */
    private function flatten($data, &$result, $key = null)
    {
        if (is_scalar($data) || null === $data) {
            $result[$key] = $data;

            return;
        }

        if (null !== $key) {
            $key .= self::KEY_SEPARATOR;
        }

        foreach ((array)$data as $dataKey => $value) {
            if (is_object($value)) {
                $value = $this->normalizer->normalize($value);
            }

            $innerKey = $key.$dataKey;
            if (is_array($value) && array_keys($value) === range(0, count($value) - 1)) {
                if (count($value) === count(array_filter($value, 'is_scalar'))) {
                    $result[$innerKey] = $value;

                    continue;
                }
            }

            if (is_scalar($value) || null === $data) {
                $result[$innerKey] = $value;
                continue;
            }

            $this->flatten($value, $result, $innerKey);
        }
    }
}
