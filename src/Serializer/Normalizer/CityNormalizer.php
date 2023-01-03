<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\City;

class CityNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @param City $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'codePostale' => $object->getCodePostal(),
            'long' => $object->getLon(),
            'lat' => $object->getLat(),
        ];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof City;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
