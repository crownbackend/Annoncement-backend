<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/ad", name: 'ad_')]
class AdController extends AbstractController
{
    public function __construct(private AdRepository $adRepository)
    {
    }

    #[Route("/search/count", name: 'ad', methods: 'GET')]
    public function home(Request $request): JsonResponse
    {
        return $this->json('hey');
    }
}
