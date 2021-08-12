<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{
    public function index()
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Hello World'
        ]);
    }

    public function users()
    {
        $results = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $users = [];
        foreach ($results as $user) {
            $users[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }

        return new JsonResponse($users);
    }

    public function compute()
    {
        $x = 0;
        $y = 1;
        $max = 10000;

        for ($i = 0; $i <= $max; $i++) {
            $z = $x + $y;
            $x = $y;
            $y = $z;
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Done'
        ]);
    }
}
