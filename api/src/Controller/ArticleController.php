<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article', name: 'article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: '_insert', methods: ['POST'])]
    public function insert(
        Request $request,
        EntityManagerInterface $entityManager,
        AuthorRepository $authorRepository,
    )
    {
        // Récupére le corps de la requête
        $requestBody = $request->getContent();

        // Sérialise les données
        $data = json_decode($requestBody, true);

        $article = new Article;
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        $article->setCreatedAt(new \DateTime('now'));

        if(array_key_exists('author', $data)){

            // recherche un auteur existant
            // avec les données transmises
            $author = $authorRepository->findOneBy(
                [
                    'name' => $data['author']['name'],
                    'firstName' => $data['author']['firstName'],
                ]
            );
            if(!$author){
                $author = new Author();
                $author->setName($data['author']['name']);
                $author->setFirstName($data['author']['firstName']);
                $author->setLogin($data['author']['login']);
                $author->setPassword($data['author']['password']);
                $entityManager->persist($author);
            }


            $article->setAuthor($author);
        }



        $entityManager->persist($article);
        $entityManager->flush();

        return $this->json(
            $article,
            Response::HTTP_CREATED,
            [],
            [
                'groups' => ['article:read', 'author:read'],
            ]
        );

    }

}
