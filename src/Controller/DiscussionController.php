<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Entity\Message;
use App\Repository\AdRepository;
use App\Repository\DiscussionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/discussion", name: 'discussion_')]
class DiscussionController extends AbstractController
{
    public function __construct(private DiscussionRepository $discussionRepository, private AdRepository $adRepository)
    {
    }

    #[Route("/", name: 'home', methods: 'GET')]
    public function home(): JsonResponse
    {
        return $this->json($this->discussionRepository->findDiscussionByUser($this->getUser()), 200, [],
            ["myDiscussion" => true]);
    }

    #[Route("/create", name: 'create', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $currentUser = $this->getUser();
        $ad = $this->adRepository->findOneBy(['id' => $data["adId"]]);

        $message = new Message();
        $message->setContent($data["message"]);
        $message->setSenderId($currentUser->getId());

        $discussion = new Discussion();
        $discussion->setAd($ad);
        $discussion->addUser($currentUser);
        $discussion->addUser($ad->getUser());
        $discussion->addMessage($message);

        $this->discussionRepository->save($discussion, true);

        return $this->json($discussion->getCreatedAt(), 201);
    }

    #[Route("/delete/{id}", name: 'delete', methods: 'DELETE')]
    public function delete(Discussion $discussion): JsonResponse
    {
        $this->discussionRepository->remove($discussion, true);
        return $this->json($this->discussionRepository->findDiscussionByUser($this->getUser()), 200, [],
            ["myDiscussion" => true]);
    }
}
