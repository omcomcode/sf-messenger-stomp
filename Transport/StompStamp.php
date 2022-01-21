<?php

declare(strict_types=1);

namespace Versh23\Messenger\Stomp\Transport;

use Enqueue\Stomp\StompMessage;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;

class StompStamp implements NonSendableStampInterface
{
    public function __construct(private StompMessage $stompMessage)
    {
    }

    public function getStompMessage(): StompMessage
    {
        return $this->stompMessage;
    }
}
