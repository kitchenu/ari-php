<?php

namespace Ari\Models\Events;

use Ari\Models\Channel;

/**
 * Event of Notification that a channel has entered a Stasis application
 */
class StasisStart extends ChannelEvent
{
    /**
     * @var array Arguments to the application
     */
    protected $args;

    /**
     * @var Channel
     */
    protected $replaceChannell;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->args = $this->getResponseValue('args');
        $this->replaceChannel = $this->getResponseValue('replace_channel', Channel::class);
    }

    /**
     * @return array Arguments to the application
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @return Channel (optional)
     */
    public function getReplaceChannel()
    {
        return $this->replaceChannel;
    }
}
