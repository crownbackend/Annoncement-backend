<?php

namespace App\Controller;

use App\Form\SearchAdsType;
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

    #[Route("/search/count", name: 'ad', methods: 'POST')]
    public function home(Request $request): JsonResponse
    {
        $form = $this->createForm(SearchAdsType::class);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            return $this->json($this->adRepository->findAdsCountBySearch($filters)[0][1], 200);
        }
        return $this->json($form->getErrors(), 400);
    }
}
