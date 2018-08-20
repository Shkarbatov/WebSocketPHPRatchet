<?php
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Pusher implements MessageComponentInterface
{
    /** @var array - subscribers */
    protected $subscribedTopics = array();

    public function onMessage(ConnectionInterface $conn, $topic)
    {
        $this->subscribedTopics[substr($conn->httpRequest->getRequestTarget(), 7)] = $conn;

        $message = json_decode($topic, true);
        if (
            isset($message['command'])
            and $message['command'] == 'update_data'
            and isset($this->subscribedTopics[$message['user']])
        ) {
            $this->subscribedTopics[$message['user']]->send('It works!');
        }
    }

    public function onOpen(ConnectionInterface $conn) {}
    public function onClose(ConnectionInterface $conn) {}
    public function onError(ConnectionInterface $conn, \Exception $e) {}
}