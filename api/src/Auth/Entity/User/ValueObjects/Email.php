<?php

namespace App\Auth\Entity\User\ValueObjects;

use InvalidArgumentException;

readonly class Email
{
    public function __construct(
        private string $value
    )
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('Email cannot be empty');
        }

        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is not valid');
        }

        mb_strtolower($this->value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}