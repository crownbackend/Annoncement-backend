<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/category", name: 'category')]
class CategoryController extends AbstractController
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route("/categories", name: 'home', methods: 'GET')]
    public function home(): JsonResponse
    {
        return $this->json($this->categoryRepository->findAll(), 200, [], ["categorySearch" => true]);
    }
}
