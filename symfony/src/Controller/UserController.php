<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'allUsers', methods: ['get'])]
    public function index(): Response
    {
        return $this->json(['users' => $this->getDoctrine()->getRepository(User::class)->findAll()]);
    }

    #[Route('/users', name: 'storeUser', methods: ['post'])]
    public function store(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName("John Doe");
        $user->setEmail("john@example.com");
        $user->setPassword("password");
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->json(['user' => $user], 201);
    }

    // Helper Route. Doesn't affect the benchmarkable routes.
    #[Route('/truncate', name: 'truncateUsers', methods: ['get'])]
    public function truncate(): Response
    {
        $connection = $this->getDoctrine()->getManager()->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('user'));
        return $this->json(['message' => 'Table deleted']);
    }

    // Helper Route. Doesn't affect the benchmarkable routes.
    #[Route('/generate', name: 'generateUsers', methods: ['get'])]
    public function generate(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        foreach (range(1, 50) as $i) {
            $user = new User();
            $user->setName("John Doe");
            $user->setEmail("john@example.com");
            $user->setPassword("password");
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($user);
        }
        $entityManager->flush();

        return $this->json(['users' => $this->getDoctrine()->getRepository(User::class)->findAll()]);
    }
}
