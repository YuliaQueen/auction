<?php

namespace App\Http\Action;

use App\Http\JsonResponse;
use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomeAction implements RequestHandlerInterface
{
    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): Response
    {
        return new JsonResponse(new \stdClass());
    }
}
