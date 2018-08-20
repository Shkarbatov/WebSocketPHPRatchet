<?php
require __DIR__ . '/vendor/autoload.php';

$connection = \Ratchet\Client\connect('ws://127.0.0.1:9057')->then(function($conn) {
    $conn->on('message', function($msg) use ($conn) {
        echo "Received: {$msg}\n";
        $conn->close();
    });

    $conn->send('{"command": "update_data", "user": "tester01"}');
    $conn->close();

}, function ($e) {
    echo "Could not connect: {$e->getMessage()}\n";
});