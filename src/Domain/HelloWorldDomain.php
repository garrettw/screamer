<?php

namespace Screamer\Domain;

class HelloWorldDomain
{
    private $payload;

    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }

    public function fetchPage()
    {
        return $this->payload->withStatus(Payload::STATUS_FOUND)->withResult(['body' => 'Hello world']);
    }
}
