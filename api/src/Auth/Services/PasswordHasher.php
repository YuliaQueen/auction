<?php

namespace App\Auth\Services;

use Webmozart\Assert\Assert;

class PasswordHasher
{
    public function __construct(
        private int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST
    )
    {
    }

    public function hash(string $password): string
    {
        Assert::notEmpty($password);
        $hash = password_hash($password, PASSWORD_ARGON2I, [
            'memory_cost' => $this->memoryCost,
        ]);

        if (!$hash) {
            throw new \RuntimeException('Failed to create hash');
        }

        return $hash;
    }

    public function validate(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}