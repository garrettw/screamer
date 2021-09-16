<?php

namespace Screamer\Responder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;

abstract class Responder
{
    protected $request;
    protected $responseFactory;
    protected $streamFactory;
    protected $response;

    public function __construct(
        ResponseFactory $responseFactory,
        StreamFactory $streamFactory
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    public function __invoke(Request $request, \Screamer\Domain\Payload $payload): Response
    {
        $this->request = $request;
        $this->payload = $payload;
        $this->{$this->getMethodForPayload()}();
        return $this->response;
    }

    protected function getMethodForPayload(): string
    {
        $method = str_replace('_', '', strtolower($this->payload->getStatus()));
        return method_exists($this, $method) ? $method : 'notRecognized';
    }

    protected function found(): void
    {
        $responseBody = $this->streamFactory->createStream($this->payload->getResult()['body']);
        $this->response = $this->responseFactory->createResponse(200)->withBody($responseBody);
    }

    protected function notRecognized(): void
    {
        $domain_status = $this->payload->getStatus();
        $this->response = $this->response->withStatus(500);
        $this->response->getBody()->write("Unknown domain payload status: '$domain_status'");
    }

    protected function notFound(): void
    {
        $this->response = $this->response->withStatus(404);
        $this->response->getBody()->write("<html><head><title>404 Not Found</title></head><body>404 Not Found</body></html>");
    }

    protected function error(): void
    {
        $e = $this->payload->getResult()['exception'];
        $this->response = $this->response->withStatus(500);
        $this->response->getBody()->write($e->getMessage());
    }
}
