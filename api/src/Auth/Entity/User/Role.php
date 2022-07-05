<?php

namespace App\Auth\Entity\User;

use Webmozart\Assert\Assert;

class Role
{
    public const USER  = 'user';
    public const ADMIN = 'admin';

    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::USER,
            self::ADMIN
        ]);
        $this->name = $name;
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->name === $other->name;
    }
}
