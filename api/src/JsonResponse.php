<?php

namespace App;

use JsonException;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Psr7\Factory\StreamFactory;

class JsonResponse extends Response
{
    /**
     * @throws JsonException
     */
    public function __construct($data, int $status = 200)
    {
        parent::__construct(
            $status,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream(json_encode($data, JSON_THROW_ON_ERROR))
        );
    }
}