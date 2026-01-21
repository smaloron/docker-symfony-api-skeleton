<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Factory\ArticleFactory;
use App\Factory\AuthorFactory;
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

        $manager->flush();
    }
}
