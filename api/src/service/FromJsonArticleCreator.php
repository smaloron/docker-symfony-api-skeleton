<?php

namespace App\service;

use App\Dto\ApiResponseDto;
use App\Entity\Article;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FromJsonArticleCreator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private AuthorResolver $authorResolver
    )
    {}

    public function create(string $json){

        // Désérialisation dans un Article
        $article = $this->serializer->deserialize(
            $json,
            Article::class,
            'json',
            ['groups' => ['article:write']]
        );

        // Définition de la date de création
        $article->setCreatedAt(new \DateTime());

        // Gestion de l'auteur

        // Recherche d'un auteur existant correspondant aux données du Json transmis
        $incomingAuthor = $article->getAuthor();
        if($incomingAuthor !== null){
            $existingAuthor = $this->authorResolver->resolve($incomingAuthor);
            if($existingAuthor){
                $article->setAuthor($existingAuthor);
            }
        }

        // Validation des entités
        $errors = $this->validator->validate($article);
        if(count($errors) > 0){
            return new ApiResponseDto(null, $errors);
        }

        // Persistance de l'entité
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        return new ApiResponseDto($article, null);
    }

}
