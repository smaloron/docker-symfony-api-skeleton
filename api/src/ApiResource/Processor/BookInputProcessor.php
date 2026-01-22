<?php

namespace App\ApiResource\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Book;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\LogRecord;


class BookInputProcessor implements ProcessorInterface
{


    public function __construct(
        private EntityManagerInterface $entityManager,
        private PublisherRepository $publisherRepository,
    )
    {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $book = new Book();
        $book->setTitle($data->title);
        $book->setPublisher(
            $this->publisherRepository->find($data->publisherId)
        );

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;

    }
}
