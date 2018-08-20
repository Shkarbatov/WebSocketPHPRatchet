<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Pusher.php';

$loop   = React\EventLoop\Factory::create();
$pusher = new Pusher;

// PHP client
$webSockPhp = new React\Socket\Server('0.0.0.0:9057', $loop);

new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            $pusher
        )
    ),
    $webSockPhp
);

// WebClient
$webSockClient = new React\Socket\Server('0.0.0.0:9056', $loop);

new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            $pusher
        )
    ),
    $webSockClient
);

$loop->run();