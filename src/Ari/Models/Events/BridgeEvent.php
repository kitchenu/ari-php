<?php

namespace Ari\Models\Events;

use Ari\Models\Bridge;

/**
 * Event for bridge
 */
class BridgeEvent extends Event implements IdentifiableEventInterface
{
    /**
     * @var Bridge
     */
    protected $bridge;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridge = $this->getResponseValue('bridge', Bridge::class);
    }

    /**
     * @return Channel
     */
    public function getBridge()
    {
        return $this->bridge;
    }

    public function getEventId()
    {
        return $this->type . '_' . $this->bridge->getIdentifier();
    }
}
