<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Factory\ArticleFactory;
use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\PublisherFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        AuthorFactory::createMany(3);
        AuthorFactory::createOne([
            'login' => 'admin',
        ]);

        ArticleFactory::createMany(100);

        PublisherFactory::createOne(["name" => "Grasset"]);
        PublisherFactory::createOne(["name" => "Hachette"]);
        PublisherFactory::createOne(["name" => "Plume de carotte"]);
        PublisherFactory::createOne(["name" => "Le seuil"]);
        PublisherFactory::createOne(["name" => "PUF"]);
        PublisherFactory::createOne(["name" => "Fleuve noir"]);
        PublisherFactory::createOne(["name" => "Bean Books"]);
        PublisherFactory::createOne(["name" => "Lean Publisher"]);
        PublisherFactory::createOne(["name" => "O'Reilly"]);

        BookFactory::createMany(50);

        $manager->flush();
    }
}
