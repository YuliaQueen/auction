<?php

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Role;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class ChangeRoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->build();
        
        $user->changeRole($role = new Role(Role::ADMIN));
        
        self::assertEquals($role, $user->getRole());
    }
}
