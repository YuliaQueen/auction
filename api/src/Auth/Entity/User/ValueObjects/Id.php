<?php

namespace App\Auth\Entity\User\ValueObjects;

use DomainException;
use Ramsey\Uuid\Uuid;

readonly class Id
{
    public function __construct(
        private string $value,
    )
    {
        if (empty($this->value)) {
            throw new DomainException("Id can't be empty");
        }

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