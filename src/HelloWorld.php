<?php

namespace Screamer;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HelloWorld
{
    private $psr17Factory;

    public function __construct(\Nyholm\Psr7\Factory\Psr17Factory $psr17Factory)
    {
        $this->psr17Factory = $psr17Factory;
    }

    public function __invoke(Request $request): Response
    {
        $responseBody = $this->psr17Factory->createStream('Hello world');
        return $this->psr17Factory->createResponse(200)->withBody($responseBody);
    }
}
