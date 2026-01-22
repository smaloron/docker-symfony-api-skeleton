<?php
namespace App\ApiResource\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BookRepository;

class BookSlimProvider implements ProviderInterface
{


    public function __construct(private BookRepository $bookRepository)
    {}

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []): object|array|null
    {
        return $this->bookRepository->findAll();
    }
}
