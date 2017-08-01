<?php

namespace Ari\Models\Events;

use Ari\Models\Endpoint;

/**
 * Event of endpoint state changed
 */
class EndpointStateChange extends Event implements IdentifiableEventInterface
{
    /**
     * @var Endpoint
     */
    protected $endpoint;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->endpoint = $this->getResponseValue('endpoint', Endpoint::class);
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getEventId()
    {
        return $this->type . '_' . $this->endpoint->getIdentifier();
    }
}
