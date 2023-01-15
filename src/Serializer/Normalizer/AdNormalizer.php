<?php

namespace App\Serializer\Normalizer;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

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
        $data = [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'price' => $object->getPrice(),
            'createdAt' => $object->getCreatedAt()->format('c'),
            'images' => $this->normalizeRelatedObjects($object->getImages()),
        ];
        if(isset($context["searchAds"])) {
            $data["category"] = [
                'id' => $object->getCategory()->getId(),
                'name' => $object->getCategory()->getName(),
            ];
            $data["city"] = [
                'id' => $object->getCity()->getId(),
                'name' => $object->getCity()->getName(),
                'codePostale' => $object->getCity()->getCodePostal()
            ];
        }
        if(isset($context["showAd"])) {
            $data['description'] = $object->getDescription();
            $data['telephone'] = $object->getTelephone();
            $data["user"] = [
                'id' => $object->getUser()->getId(),
                'email' => $object->getUser()->getEmail(),
                'firstName' => $object->getUser()->getFirstName(),
                'lastName' => $object->getUser()->getLastName(),
                'ads' => $object->getUser()->getAds()->count()
            ];
            $data["category"] = [
                'id' => $object->getCategory()->getId(),
                'name' => $object->getCategory()->getName(),
            ];
            $data["city"] = [
                'id' => $object->getCity()->getId(),
                'name' => $object->getCity()->getName(),
                'codePostale' => $object->getCity()->getCodePostal(),
                'lon' => $object->getCity()->getLon(),
                'lat' => $object->getCity()->getLat(),
            ];
        }
        if(isset($context["userAdsShow"])) {
            $data["city"] = [
                'id' => $object->getCity()->getId(),
                'name' => $object->getCity()->getName(),
                'codePostale' => $object->getCity()->getCodePostal()
            ];
        }
        return $data;
    }

    /**
     * @param Image[] $images
     * @return array
     */
    private function normalizeRelatedObjects(Collection $images): array
    {
        $normalizedRelatedObjects = [];
        foreach ($images as $image) {
            $normalizedRelatedObjects[] = [
                'id' => $image->getId(),
                'name' => $image->getName(),
            ];
        }
        return $normalizedRelatedObjects;
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
