<?php

namespace App\Serializer\Normalizer;

use App\Entity\Ad;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AdNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{

    /**
     * @param Ad $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'price' => $object->getPrice(),
            'category' => [
                'id' => $object->getCategory()->getId(),
                'name' => $object->getCategory()->getName(),
            ],
            'city' => [
                'id' => $object->getCity()->getId(),
                'name' => $object->getCity()->getName(),
                'codePostale' => $object->getCity()->getCodePostal()
            ],
            'createdAt' => $object->getCreatedAt()->format('c'),
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Ad;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
