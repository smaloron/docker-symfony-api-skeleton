<?php

namespace App\Dto;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ApiResponseDto
{
    public function __construct(
        public Object|array|null $data,
        public ?ConstraintViolationListInterface $errors,
    ){}

    public function isValid(): bool{
        return $this->errors === null || (is_array($this->errors) && count($this->errors) === 0);
    }

}
