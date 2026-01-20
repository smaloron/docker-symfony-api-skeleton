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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/article', name: 'article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: '_insert', methods: ['POST'])]
    public function insert(
        Request $request,
        EntityManagerInterface $entityManager,
        AuthorRepository $authorRepository,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
    )
    {
        // Récupére le corps de la requête
        $requestBody = $request->getContent();

        // Sérialise les données

        $article = $serializer->deserialize($requestBody, Article::class, 'json');



        if($article->getAuthor() !== null){

            // recherche un auteur existant
            // avec les données transmises
            $author = $authorRepository->findOneBy(
                [
                    'name' => $article->getAuthor()->getName(),
                    'firstName' => $article->getAuthor()->getFirstName(),
                ]
            );
            /*
            if(!$author){
                $author = new Author();
                $author->setName($data['author']['name']);
                $author->setFirstName($data['author']['firstName']);
                $author->setLogin($data['author']['login']);
                $author->setPassword($data['author']['password']);
                //$entityManager->persist($author);
            }*/


            $article->setAuthor($author);
        }

        // Validation de l'entité
        $errors = $validator->validate($article);

        if(count($errors) > 0){
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
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
