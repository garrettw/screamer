<?php

namespace Screamer\Responder;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;

class HelloWorldResponder extends Responder
{
    protected function found(): void
    {
        $template = new \Transphporm\Builder($this->payload->getResult()['body'], '');
        $responseBody = $this->streamFactory->createStream($template->output()->body);
        $this->response = $this->responseFactory->createResponse(200)->withBody($responseBody);
    }
}
