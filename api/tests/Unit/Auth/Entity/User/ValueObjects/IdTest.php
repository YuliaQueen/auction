<?php

namespace Test\Unit\Auth\Entity\User\ValueObjects;

use App\Auth\Entity\User\ValueObjects\Id;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase
{

    public function testSuccess()
    {
        $id = new Id($value = Uuid::uuid4()->toString());

        $this->assertEquals($value, $id->getValue());
    }

    public function testGenerate()
    {
        $id = Id::generate();

        $this->assertNotEmpty($id->getValue());
    }

    public function testWithEmptyValue()
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }
}
