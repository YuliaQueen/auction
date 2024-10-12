<?php

namespace Test\Unit\Http;

use stdClass;
use App\Http\JsonResponse;
use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    /**
     * @param mixed $source
     * @param mixed $expect
     * @dataProvider getCases
     * @return void
     */
    public function testResponse($source, $expect)
    {
        $response = new JsonResponse($source);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals($expect, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return array
     */
    public function getCases()
    {
        $object = new stdClass();
        $object->str = 'value';
        $object->int = 1;
        $object->none = null;

        $array = [
            'str'  => 'value',
            'int'  => 1,
            'none' => null,
        ];

        return [
            'null'   => [null, 'null'],
            'empty'  => ['', '""'],
            'number' => [12, '12'],
            'string' => ['value', '"value"'],
            'object' => [$object, '{"str":"value","int":1,"none":null}'],
            'array'  => [$array, '{"str":"value","int":1,"none":null}'],
        ];
    }
}