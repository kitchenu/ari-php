<?php

namespace Ari\Models\Events;

use Ari\Models\Bridge;

/**
 * Event of notification that a channel has entered a bridge
 */
class ChannelEnteredBridge extends ChannelEvent
{
    /**
     * @var Bridge
     */
    protected $bridge;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridge = $this->getResponseValue('bridge', Bridge::class);
    }

    /**
     * @return Bridge
     */
    public function getBridge()
    {
        return $this->bridge;
    }
}
