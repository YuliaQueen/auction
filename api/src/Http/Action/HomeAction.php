<?php

namespace App\Http\Action;

use stdClass;
use JsonException;
use App\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

readonly class HomeAction implements RequestHandlerInterface
{
    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(new stdClass());
    }
}