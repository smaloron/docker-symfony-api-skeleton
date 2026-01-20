<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api')]
final class PingController extends AbstractController
{
    #[Route('/ping', name: '_ping')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Symfony c\'est cool',
            'timestamp' => time(),
        ]);
    }
}
