<?php

namespace Ari\Models\Events;

use Ari\Models\Endpoint;
use Ari\Models\Peer;

/**
 * Event of the state of a peer associated with an endpoint has changed
 */
class PeerStatusChange extends Event implements IdentifiableEventInterface
{
    /**
     * @var Endpoint
     */
    protected $endpoint;

    protected $peer;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->endpoint = $this->getResponseValue('endpoint', Endpoint::class);
        $this->peer = $this->getResponseValue('peer', Peer::class);
    }

    /**
     * @return Playback Playback control object
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return Playback Playback control object
     */
    public function getPeer()
    {
        return $this->peer;
    }

    public function getEventId()
    {
        return $this->getType() . '' . $this->endpoint->getIdentifier();
    }
}
