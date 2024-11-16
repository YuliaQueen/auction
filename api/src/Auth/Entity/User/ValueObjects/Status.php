<?php

namespace App\Auth\Entity\User\ValueObjects;

class Status
{
    private const string ACTIVE = 'active';
    private const string WAIT = 'wait';

    private function __construct(
        private string $status
    )
    {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public function isWait(): bool
    {
        return $this->status === self::WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::ACTIVE;
    }
}