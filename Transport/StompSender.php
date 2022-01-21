<?php

declare(strict_types=1);

namespace Versh23\Messenger\Stomp\Transport;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class StompSender implements SenderInterface
{
    public function __construct(private Connection $connection, private SerializerInterface $serializer)
    {
    }

    /**
     * Sends the given envelope.
     *
     * The sender can read different stamps for transport configuration,
     * like delivery delay.
     *
     * If applicable, the returned Envelope should contain a TransportMessageIdStamp.
     */
    public function send(Envelope $envelope): Envelope
    {
        $encodedMessage = $this->serializer->encode($envelope);

        try {
            $message = $this->connection->send($encodedMessage['body'], $encodedMessage['headers'] ?? []);
        } catch (\Throwable $e) {
            throw new TransportException($e->getMessage(), 0, $e);
        }

        return $envelope->with(new StompStamp($message));
    }
}
