<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsEntityListener(event: Events::prePersist, method: 'preInsert', entity: Author::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Author::class)]
class AuthorPasswordHasherListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ){}

    public function preInsert(Author $author): void{
        $this->hashPassword($author);
    }

    public function preUpdate(Author $author): void{
        $this->hashPassword($author);
    }

    public function hashPassword(Author $author){

        if(!$author->getPlainPassword()){
            return;
        }

        $hash = $this->passwordHasher->hashPassword(
            $author,
            $author->getPlainPassword()
        );

        $author->setPassword($hash);

        $author->eraseCredentials();
    }

}
