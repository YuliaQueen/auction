<?php

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\NetworkIdentity;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class AttachNetworkTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $network = new NetworkIdentity('vk', '000001');

        $user->attachNetwork($network);

        self::assertCount(1, $networks = $user->getNetworks());
        self::assertEquals($network, $networks[0] ?? null);
    }

    public function testAlready()
    {
        $user = (new UserBuilder())->active()->build();

        $network = new NetworkIdentity('vk', '000001');

        $user->attachNetwork($network);

        $this->expectExceptionMessage('Network is already attached.');

        $user->attachNetwork($network);
    }
}
