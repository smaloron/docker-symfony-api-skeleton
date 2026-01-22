<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\service\AuthorResolver;
use App\service\FromJsonArticleCreator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/article', name: 'article')]
class ArticleController extends AbstractController
{
    #[Route('', name: '_insert', methods: ['POST'])]
    public function insert(
        Request $request,
        FromJsonArticleCreator $creator

    ): Response
    {
        // Récupére le corps de la requête
        $requestBody = $request->getContent();

        // Sérialise les données
        // Et capture l'exception en cas d'erreur de sérialisation
        try {
            $result = $creator->create($requestBody);
        } catch (\Throwable){
            return $this->json(
                ["errors" => "JSON Invalide"],
                Response::HTTP_BAD_REQUEST
            );
        }

        if(! $result->isValid()){
            return $this->json(
                $result->errors,
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            $result->data,
            Response::HTTP_CREATED,
            [],
            ['groups' => ['article:read', 'author:read']]
        );

    }


    #[Route('', name: '_list', methods: ['GET'])]
    public function list(ArticleRepository $articleRepository): Response{
        $articles = $articleRepository->findAll();
        return $this->json($articles, Response::HTTP_OK, [], ['groups' => ['article:read', 'author:read']]);
    }

    #[Route('/{id}', name: '_update', methods: ['PUT', 'PATCH'])]
    public function edit(Article $article): Response{
        $this->denyAccessUnlessGranted('POST_EDIT', $article);

        return $this->json(['message' => 'Autorisé'], Response::HTTP_OK);
    }

}
