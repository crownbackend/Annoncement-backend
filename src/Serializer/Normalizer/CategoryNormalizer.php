<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Category;

class CategoryNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @param Category $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = [
            'id' => $object->getId(),
            'name' => $object->getName(),
        ];

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Category;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
