<?php

namespace Ari\Models\Events;

use Ari\Models\Playback;

/**
 * Event for playback
 */
class PlaybackEvent extends Event implements IdentifiableEventInterface
{
    /**
     * @var Playback Playback control object
     */
    protected $playback;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->playback = $this->getResponseValue('playback', Playback::class);
    }

    /**
     * @return Playback Playback control object
     */
    public function getPlayback()
    {
        return $this->playback;
    }

    public function getEventId()
    {
        return $this->type . '_' . $this->playback->getId();
    }
}
