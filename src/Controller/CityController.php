<?php

namespace App\Controller;

use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/city", name: 'city_')]
class CityController extends AbstractController
{
    public function __construct(private CityRepository $cityRepository)
    {
    }

    #[Route("/", name: 'city', methods: 'GET')]
    public function home(): JsonResponse
    {
        return $this->json('hey');
    }
}
