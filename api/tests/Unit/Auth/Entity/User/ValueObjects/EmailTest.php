<?php

namespace Test\Unit\Auth\Entity\User\ValueObjects;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Auth\Entity\User\ValueObjects\Email;

class EmailTest extends TestCase
{

    public function testSuccess()
    {
        $email = new Email($value = 'test@test.com');

        $this->assertEquals($value, $email->getValue());
    }

    public function testWithIncorrectValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid');
    }

    public function testWithEmptyValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }
}
