<?php

use App\service\CountryService;
use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{

    public function testThatTrueIsTrue(): void{
        $this->assertTrue(true);
    }

    public function testThatgetCountriesReturnsAnArray(): void{
        // 1. Arrange
        $countryService = new CountryService();
        // 2. Act
        $countries = $countryService->getCountries();
        // 3. Assert
        $this->assertIsArray($countries);
    }

}
