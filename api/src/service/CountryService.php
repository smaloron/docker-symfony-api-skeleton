<?php

namespace App\service;

use Symfony\Component\Validator\Constraints\Country;

class CountryService
{

    public function getCountries(): array{

        return  [
            ['id' => 1, 'name' => 'France', 'capital' => 'Paris'],
            ['id' => 2, 'name' => 'Irlande', 'capital' => 'Dublin'],
            ['id' => 3, 'name' => 'Allemagne', 'capital' => 'Berlin'],
            ['id' => 4, 'name' => 'Espagne', 'capital' => 'Madrid'],
            ['id' => 5, 'name' => 'Italie', 'capital' => 'Rome'],
            ['id' => 6, 'name' => 'Japon', 'capital' => 'Tokyo'],
        ];

    }

    public function getOneById(int $id): array
    {
        return array_find(
            $this->getCountries(),
            function (array $country) use ($id) {
                return $country['id'] === $id;
            }
        );
    }

    public function search(string $term): array
    {
        return array_find(
            $this->getCountries(),
            function (array $country) use ($term) {
                return $country['name'] === $term || $country['capital'] === $term;
            }
        );
    }
}
