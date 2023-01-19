<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/message", name: 'message_')]
class MessageController extends AbstractController
{
    public function __construct(private MessageRepository $messageRepository)
    {
    }

    #[Route("/create", name: 'create', methods: 'POST')]
    public function createMessage(Request $request): JsonResponse
    {
        return $this->json('hey');
    }

    #[Route("/read", name: 'read_message', methods: 'POST')]
    public function readMessage(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $message = $this->messageRepository->findOneBy(["id" => $data["id"]]);
        if(!$message->getReadAt()) {
            $message->setReadAt(new \DateTimeImmutable());
            $this->messageRepository->save($message);
            return $this->json($message->getContent(), 201);
        } else {
            return $this->json('message non lu', 201);
        }

    }
}
