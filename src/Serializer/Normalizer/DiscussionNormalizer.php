<?php

namespace App\Serializer\Normalizer;

use App\Entity\Message;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Discussion;

class DiscussionNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * @param Discussion $object
     * @param string|null $format
     * @param array $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $data =  [
            'id' => $object->getId(),
            'createdAt' => $object->getCreatedAt()->format('c'),
            'messages' => $this->normalizeRelatedObjects($object->getMessages()),
        ];

        if(isset($context["myDiscussion"])) {
            $data['ad'] = [
                'id' => $object->getAd()->getId(),
                'name' => $object->getAd()->getName(),
                'description' => $object->getAd()->getDescription(),
                'image' => $object->getAd()->getImages()->first()
            ];
        }

        return $data;
    }

    /**
     * @param Collection<Message> $messages
     * @return array
     */
    private function normalizeRelatedObjects(Collection $messages): array
    {
        $normalizedRelatedObjects = [];
        foreach ($messages as $message) {
            $normalizedRelatedObjects[] = [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'createdAt' => $message->getCreatedAt()->format('c'),
                'readAt' => $message->getReadAt() ? $message->getReadAt()->format('c') : null,
                'senderId' => $message->getSenderId()
            ];
        }
        return $normalizedRelatedObjects;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Discussion;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
