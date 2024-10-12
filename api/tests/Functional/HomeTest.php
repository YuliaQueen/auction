<?php

namespace Functional;

use Test\Functional\AbstractFunctionalTestCase;

class HomeTest extends AbstractFunctionalTestCase
{
    public function testHomeSuccess()
    {
        $response = $this->app()->handle(self::json('GET', '/'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('{}', (string)$response->getBody());
    }

    public function testHomeErrorWithMethodPost()
    {
        $response = $this->app()->handle(self::json('POST', '/'));
        $this->assertEquals(405, $response->getStatusCode());
    }
}