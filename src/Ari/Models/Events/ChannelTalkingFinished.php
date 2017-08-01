<?php

namespace Ari\Models\Events;

/**
 * Event of Talking is no longer detected on the channel
 */
class ChannelTalkingFinished extends ChannelEvent
{
    /**
     * @var int The length of time, in milliseconds, that talking was detected on the channel
     */
    private $duration;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->duration = $this->getResponseValue('duration');
    }

    /**
     * @return int The length of time, in milliseconds, that talking was detected on the channel
     */
    public function getDuration()
    {
        return $this->duration;
    }
}
