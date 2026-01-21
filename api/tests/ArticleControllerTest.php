<?php

use App\Dto\ApiResponseDto;
use App\Entity\Article;
use App\Entity\Author;
use App\service\FromJsonArticleCreator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{

    public function testPostArticleReturns201(){
        $client = self::createClient();
        $creator = $this->createMock(FromJsonArticleCreator::class);

        $author = new Author()
            ->setName('Doe')
            ->setFirstName('John');

        $article = new Article()
            ->setAuthor($author)
            ->setTitle('Title')
            ->setContent('Content');

        $creator->expects($this->once())
            ->method('create')
            ->willReturn(
                new ApiResponseDto($article, null)
            );

        // Remplacement du vrai service par l'instance simulée (Mock)
        self::getContainer()->set(
            FromJsonArticleCreator::class,
            $creator
        );

        $client->request(
            'POST',
            '/article',
            server: ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            content:"{}"
        );

        self::assertEquals(201, $client->getResponse()->getStatusCode());
        self::assertResponseStatusCodeSame(201);
    }

}
