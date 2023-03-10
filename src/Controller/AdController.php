<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\SearchAdsType;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/ad", name: 'ad_')]
class AdController extends AbstractController
{
    public function __construct(private AdRepository $adRepository)
    {
    }

    #[Route("/search/count", name: 'ads_count', methods: 'POST')]
    public function searchCount(Request $request): JsonResponse
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

    #[Route("/search", name: 'ads', methods: 'GET')]
    public function searchAds(Request $request): JsonResponse
    {
        if($request->query->get('range')) {
            $range = $request->query->get('range');
            $ranges = explode("-", $range);
            return $this->json($this->adRepository->findAdsCountBySearch($request->query->all(), $ranges[0], $ranges[1]), 200);
        } else {
            return $this->json($this->adRepository->findAdsCountBySearch($request->query->all()), 200, [], ['searchAds' => true]);
        }

    }

    #[Route("/{id}", name: 'ad_show', methods: 'GET')]
    public function show(Ad $ad): JsonResponse|NotFoundHttpException
    {
        if(!$ad) {
            return $this->createNotFoundException('Erreur not found ad');
        }
        return $this->json($ad, 200, [], ["showAd" => true]);
    }

    #[Route("/{id}/user", name: 'user_last_ad', methods: 'GET')]
    public function adByUserLastForAds(User $user): JsonResponse|NotFoundHttpException
    {
        if(!$user) {
            return $this->createNotFoundException('Erreur not found ad user');
        }

        return $this->json($this->adRepository->findByUserAdsLastResult($user), 200, [], ["userAdsShow" => true]);
    }
}
