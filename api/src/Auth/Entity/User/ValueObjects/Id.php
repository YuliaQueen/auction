<?php

namespace App\Auth\Entity\User\ValueObjects;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

readonly class Id
{
    public function __construct(
        private string $value,
    )
    {
        Assert::uuid($value);

        mb_strtolower($this->value);
    }

    /**
     * @return self
     */
    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}