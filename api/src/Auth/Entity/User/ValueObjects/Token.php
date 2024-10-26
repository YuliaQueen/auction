<?php

namespace App\Auth\Entity\User\ValueObjects;

use InvalidArgumentException;

class Token
{
    public function __construct(
        private string $value
    )
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException('Token cannot be empty');
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}