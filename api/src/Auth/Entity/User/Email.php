<?php

namespace App\Auth\Entity\User;


use Webmozart\Assert\Assert;

class Email {

    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        Assert::email($value);

        $this->value = mb_strtolower($value);
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param Email $other
     *
     * @return bool
     */
    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->value;
    }
}
