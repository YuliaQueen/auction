<?php

namespace Test\Unit\Auth\Services;

use App\Auth\Services\PasswordHasher;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordHasherTest extends TestCase
{
    public function testPasswordHasher()
    {
        $hasher = new PasswordHasher(16);

        $password = 'password';
        $hash = $hasher->hash($password);
        $this->assertTrue($hasher->validate($password, $hash));
    }

    public function testHashEmpty()
    {
        $this->expectException(InvalidArgumentException::class);

        $hasher = new PasswordHasher();
        $hasher->hash('');
    }
}
