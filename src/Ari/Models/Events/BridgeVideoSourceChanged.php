<?php

namespace Ari\Models\Events;

use Ari\Models\Bridge;

/**
 * Event of notification that the source of video in a bridge has changed
 */
class BridgeVideoSourceChanged extends BridgeEvent
{
    /**
     * @var Bridge
     */
    protected $oldVideoSourceId;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->oldVideoSourceId = $this->getResponseValue('old_video_source_id');
    }

    /**
     * @return Bridge
     */
    public function getOldVideoSourceId()
    {
        return $this->oldVideoSourceId;
    }
}
