<?php

namespace Screamer\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Screamer\Domain\HomeDomain;
use Screamer\Responder\HomeResponder;

class HomeAction
{
    private $domain;
    private $responder;

    public function __construct(
        HomeDomain $domain,
        HomeResponder $responder
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
