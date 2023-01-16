<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/profile", name: 'profile_')]

class UserController extends AbstractController
{
    #[Route("/", name: 'home', methods: 'GET')]
    public function home(): JsonResponse
    {
        return $this->json($this->getUser(), 200);
    }
    #[Route("/is/connected", name: 'is_connected', methods: 'GET')]
    public function isConnected(): JsonResponse
    {
        return $this->json($this->getUser()->getUserIdentifier(), 200);
    }
}
