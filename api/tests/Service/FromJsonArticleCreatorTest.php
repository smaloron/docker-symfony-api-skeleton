<?php

namespace Service;

use App\Entity\Article;
use App\Entity\Author;
use App\service\AuthorResolver;
use App\service\FromJsonArticleCreator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FromJsonArticleCreatorTest extends TestCase
{
    public function testCreateReturnsErrorAndDoesNotPersist(): void {

        $author = new Author()
            ->setName('Doe')
            ->setFirstName('John');

        $article = new Article()
            ->setAuthor($author)
            ->setTitle('Title')
            ->setContent('Content');

        $serializer = $this->createMock(SerializerInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $resolver = $this->createMock(AuthorResolver::class);

        $serializer ->expects($this->once())
                    ->method('deserialize')
                    ->willReturn($article);

        $resolver->expects($this->once())
            ->method('resolve')
            ->willReturn(null);

        $error = new ConstraintViolationList(
            [
                new ConstraintViolation(
                    'Blank',
                    null,
                    [],
                    '',
                    'author.name',
                    ''
                )
            ]
        );

        $validator->expects($this->once())
            ->method('validate')
            ->willReturn($error);

        $em->expects($this->never())->method('persist');
        $em->expects($this->never())->method('flush');

        $creator = new FromJsonArticleCreator(
            $em,
            $validator,
            $serializer,
            $resolver,
        );

        $result = $creator->create('{"json": "bla"}');

        $this->assertFalse($result->isValid());
    }

}
