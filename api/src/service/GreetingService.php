<?php

namespace App\service;

use Symfony\Contracts\Translation\TranslatorInterface;

class GreetingService
{


    public function __construct(
        private readonly TranslatorInterface $translator
    )
    {}

    public function hello()
    {

        return $this->translator->trans('hello', [], 'messages');
    }

}
