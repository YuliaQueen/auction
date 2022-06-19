<?php

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Service\PasswordHasher;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class ChangePasswordTest extends TestCase
{
    /**
     * @return void
     * @throws ReflectionException
     */
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $hasher = $this->createHasher(true, $hash = 'new-hash');

        $user->changePassword($hasher, 'current-password', 'new-password');
        
        self::assertEquals($hash, $user->getPasswordHash());
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function testWrongCurrent(): void
    {
        $user = (new UserBuilder())->active()->build();

        $hasher = $this->createHasher(false, 'new-hash');

        $this->expectExceptionMessage('Incorrect current password');
        $user->changePassword($hasher, 'wrong-current-password', 'new-password');
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function testByNetwork(): void
    {
        $user = (new UserBuilder())->viaNetwork()->build();

        $hasher = $this->createHasher(false, 'new-hash');

        $this->expectExceptionMessage('User does not have an old password');
        $user->changePassword($hasher, 'any-current-password', 'new-password');
    }

    /**
     * @param bool $valid
     * @param string $hash
     *
     * @return PasswordHasher|MockObject
     */
    private function createHasher(bool $valid, string $hash): PasswordHasher
    {
        $hasher = $this->createMock(PasswordHasher::class);
        $hasher->method('validate')->willReturn($valid);
        $hasher->method('hash')->willReturn($hash);

        return $hasher;
    }
}
