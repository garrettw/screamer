<?php

namespace Screamer;

class App
{
    private $request;
    private $router;
    private $sapiEmitter;

    public function __construct(
        \Psr\Http\Message\ServerRequestInterface $request,
        \League\Route\Router $router,
        \Laminas\HttpHandlerRunner\Emitter\SapiEmitter $sapiEmitter
    ) {
        $this->request = $request;
        $this->router = $router;
        $this->sapiEmitter = $sapiEmitter;
    }

    public function __invoke()
    {
        $this->router->map('GET', '/', Action\HomeAction::class);

        $this->sapiEmitter->emit($this->router->dispatch($this->request));
    }
}
