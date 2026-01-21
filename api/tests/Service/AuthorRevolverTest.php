<?php

namespace Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\service\AuthorResolver;
use PHPUnit\Framework\TestCase;

class AuthorRevolverTest extends TestCase
{

    public function testResolveUsesNamesToFindAnAuthor(): void{

        $incomingAuthor = new Author()
            ->setName('Brahé')
            ->setFirstName('Tycho');

        $expectedAuthor = new Author()
            ->setName('Brahé')
            ->setFirstName('Tycho');

        $repository = $this->createMock(AuthorRepository::class);

        $repository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'firstName' => $incomingAuthor->getFirstName(),
                'name' => $incomingAuthor->getName()
            ])
            ->willReturn($expectedAuthor);

        $resolver = new AuthorResolver($repository);
        $result = $resolver->resolve($incomingAuthor);

        $this->assertEquals($expectedAuthor->getName(), $result->getName());
    }

}
