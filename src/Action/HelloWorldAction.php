<?php

namespace Screamer\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Screamer\Domain\HelloWorldDomain;
use Screamer\Responder\HelloWorldResponder;

class HelloWorldAction
{
    private $domain;
    private $responder;

    public function __construct(
        HelloWorldDomain $domain,
        HelloWorldResponder $responder
    ) {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request): Response
    {
        $payload = $this->domain->fetchPage();
        return $this->responder->__invoke($request, $payload);
    }
}
