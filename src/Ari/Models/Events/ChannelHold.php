<?php

namespace Ari\Models\Events;

/**
 * Event of a channel initiated a media hold
 */
class ChannelHold extends ChannelEvent
{
    /**
     * @var string The string representation of the music class value.
     */
    protected $musicClass;

    /**
     * @return int The string representation of the music class value.
     */
    public function getMusicClass()
    {
        return $this->musicClass;
    }

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->musicClass = $this->getResponseValue('musicclass');
    }
}
