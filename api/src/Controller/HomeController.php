<?php

namespace App\Controller;

use App\service\GreetingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    private GreetingService $greetingService;

    public function __construct(GreetingService $greetingService){}

    #[Route('/hello', name: 'home', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => $this->greetingService->hello(),
        ]);
    }

}
