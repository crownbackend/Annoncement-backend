<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/message", name: 'message_')]
class MessageController extends AbstractController
{
    #[Route("/create", name: 'create', methods: 'POST')]
    public function createMessage(Request $request): JsonResponse
    {
        return $this->json('hey');
    }
}
