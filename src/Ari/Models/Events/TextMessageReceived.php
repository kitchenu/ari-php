<?php

namespace Ari\Models\Events;

use Ari\Models\Endpoint;
use Ari\Models\TextMessage;

/**
 * Event of a text message was received from an endpoint
 */
class TextMessageReceived extends Event implements IdentifiableEventInterface
{
    /**
     * @var Endpoint  (optional)
     */
    protected $endpoint;

    /**
     * @var TextMessage
     */
    protected $message;

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return TextMessage
     */
    public function getTextMessage()
    {
        return $this->message;
    }

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->endpoint = $this->getResponseValue('endpoint', Endpoint::class);
        $this->message = $this->getResponseValue('message', TextMessage::class);
    }

    public function getEventId()
    {
        return $this->getType() . '_' . $this->endpoint->getIdentifier();
    }
}
