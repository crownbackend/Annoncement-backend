<?php

namespace App\Controller;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/city", name: 'city_')]
class CityController extends AbstractController
{
    public function __construct(private CityRepository $cityRepository)
    {
    }

    #[Route("/search", name: 'search', methods: 'GET')]
    public function search(Request $request): JsonResponse
    {
        return $this->json($this->cityRepository->findSearchByCity($request), 200);
    }
}
