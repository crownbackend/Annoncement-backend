<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/discussion", name: 'discussion_')]
class DiscussionController extends AbstractController
{
    #[Route("/", name: 'home', methods: 'GET')]
    public function home(): JsonResponse
    {
        return $this->json('hey');
    }

    #[Route("/create", name: 'create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        dump($request->request);
        return $this->json('create');
    }
}
