<?php

namespace Test\Unit\Auth\Entity\User;

use App\Auth\Entity\User\User;
use App\Auth\Entity\User\ValueObjects\Email;
use App\Auth\Entity\User\ValueObjects\Id;
use App\Auth\Entity\User\ValueObjects\Token;
use DateTimeImmutable;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testCreate()
    {
        $user = new User(
            $id = Id::generate(),
            $email = new Email('test@test.com'),
            $hash = 'hash',
            $token = new Token(Uuid::uuid4()->toString()),
            $date = new DateTimeImmutable(),
        );

        Assert::assertEquals($id->getValue(), $user->getId());
        Assert::assertEquals($email->getValue(), $user->getEmail());
        Assert::assertEquals($hash, $user->getHash());
        Assert::assertEquals($token, $user->getJoinConfirmToken());
        Assert::assertEquals($date, $user->getCreatedAt());
        Assert::assertTrue($user->isWait());
        Assert::assertFalse($user->isActive());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testConfirmJoinSuccess()
    {
        // TODO create test
    }
}
