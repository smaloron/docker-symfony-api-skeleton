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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/article', name: 'article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: '_insert', methods: ['POST'])]
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

}
