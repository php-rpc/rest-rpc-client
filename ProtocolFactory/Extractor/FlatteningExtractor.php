<?php

namespace ScayTrase\Api\Rest\ProtocolFactory\Extractor;

use ScayTrase\Api\Rest\ProtocolFactory\ArgumentExtractorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FlatteningExtractor implements ArgumentExtractorInterface
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
    public function extract($data)
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
        if (null !== $key) {
            $key .= self::KEY_SEPARATOR;
        }

        foreach ($data as $data_key => $value) {
            if (is_object($value)) {
                $value = $this->normalizer->normalize($value);
            }

            if (is_scalar($value)) {
                $result[$key.$data_key] = $value;
                continue;
            }

            $this->flatten($value, $result, $key.$data_key);
        }
    }
}
