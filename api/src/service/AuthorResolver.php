<?php

namespace App\service;

use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorResolver
{

    public function __construct(private AuthorRepository $repository){}

    public function resolve(Author $incoming){
        // Recherche par id
        $id = $incoming->getId();
        if($id !== null){
            $found = $this->repository->find($id);
            if($found !== null){
                return $found;
            }
        }

        // Recherche par nom et prénom
        $name = $incoming->getName();
        $firstName = $incoming->getFirstName();
        if($firstName === null || $name === null){
            return null;
        }

        return $this->repository->findOneBy(
            ['firstName' => $firstName, 'name' => $name]
        );
    }

}
