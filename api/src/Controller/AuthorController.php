<?php

namespace App\Controller;


use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/author', name: 'author')]
final class AuthorController extends AbstractController
{

    #[Route('/', name: '_create', methods: ['POST'])]
    public function insert(
        Request $request,
        EntityManagerInterface $entityManager,
    )
    {
        // Récupére le corps de la requête
        $requestBody = $request->getContent();

        // Sérialise les données
        $data = json_decode($requestBody, true);

        // hydrate une entité avec les données
        $author = new Author;
        $author ->setName($data['name'])
                ->setFirstName($data['firstName'])
                ->setLogin($data['login'])
                ->setPassword($data['password'])
        ;

        // Gère la persistance
        $entityManager->persist($author);
        $entityManager->flush();

        return $this->json($author, Response::HTTP_CREATED);

    }

}
