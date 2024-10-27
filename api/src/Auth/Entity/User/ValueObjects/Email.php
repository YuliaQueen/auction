<?php

namespace App\Auth\Entity\User\ValueObjects;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

readonly class Email
{
    public function __construct(
        private string $value
    )
    {
        Assert::notEmpty($value);
        Assert::email($value);

        mb_strtolower($this->value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}