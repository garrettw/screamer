<?php

use Dice\Dice;
use Dice\Interop\Interop;
use Psr\Http\Message;
use Nyholm\Psr7\Factory\Psr17Factory;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\JsonStrategy;

return [
    '*' => [
        'substitutions' => [
            Dice::class => [Dice::INSTANCE => Dice::SELF],
            Psr\Container\ContainerInterface::class => Interop::class,
            Message\ServerRequestFactoryInterface::class => Psr17Factory::class,
            Message\UriFactoryInterface::class => Psr17Factory::class,
            Message\UploadedFileFactoryInterface::class => Psr17Factory::class,
            Message\StreamFactoryInterface::class => Psr17Factory::class,
            Message\ResponseFactoryInterface::class => Psr17Factory::class,
        ]
    ],
    \Psr\Http\Message\ServerRequestInterface::class => [
        'shared' => true,
        'instanceOf' => Nyholm\Psr7Server\ServerRequestCreator::class,
        'call' => [['fromGlobals', [], Dice::CHAIN_CALL]],
    ],
    ApplicationStrategy::class => [
        'call' => [['setContainer', [[Dice::INSTANCE => Interop::class]], Dice::CHAIN_CALL]],
    ],
    \League\Route\Router::class => [
        'shared' => true,
        'call' => [['setStrategy', [[Dice::INSTANCE => ApplicationStrategy::class]], Dice::CHAIN_CALL]],
    ],
    '$JsonRouter' => [
        'instanceOf' => \League\Route\Router::class,
        'call' => [['setStrategy', [[Dice::INSTANCE => JsonStrategy::class]], Dice::CHAIN_CALL]],
    ]
];
