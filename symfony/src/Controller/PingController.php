<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    #[Route('/ping', name: 'ping')]
    public function index(): Response
    {
        return $this->json(['message' => 'pong']);
    }

    #[Route('/compute', name: 'compute')]
    public function compute(): JsonResponse
    {
        $x = 0;
        $y = 1;
        $max = 10000;

        for ($i = 0; $i <= $max; $i++) {
            $z = $x + $y;
            $x = $y;
            $y = $z;
        }
        return $this->json(['message' => 'Done']);
    }
}
