<?php

namespace App\Controller;

use App\service\GreetingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{

    private GreetingService $greetingService;

    public function __construct(GreetingService $greetingService, private TranslatorInterface $translator){
        $this->greetingService = $greetingService;
    }

    #[Route('/hello', name: 'home', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {

        return $this->json([
            'message' => $this->greetingService->hello(),
            'locale' => $request->getLocale(),
            'testFR' => $this->translator->trans("welcome", [], 'messages'),
        ]);
    }

}
