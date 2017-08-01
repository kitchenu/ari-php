<?php

namespace Ari\Models\Events;

use Ari\Models\Bridge;

/**
 * Event of notification that one bridge has merged into another
 */
class BridgeMerged extends BridgeEvent
{
    /**
     * @var Bridge
     */
    protected $bridgeFrom;

    /**
     * @return Bridge
     */
    public function getBridgeFrom()
    {
        return $this->bridgeFrom;
    }

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridgeFrom = $this->getResponseValue('bridge_from', Bridge::class);
    }
}
