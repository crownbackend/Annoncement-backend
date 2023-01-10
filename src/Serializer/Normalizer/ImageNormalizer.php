<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Image;

class ImageNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @param Image $object
     * @param string|null $format
     * @param array $context
     * @return string[]
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName()
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Image;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
