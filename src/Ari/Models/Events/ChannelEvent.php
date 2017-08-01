<?php

namespace Ari\Models\Events;

use Ari\Models\Channel;

/**
 * Event for channel
 */
class ChannelEvent extends Event implements IdentifiableEventInterface
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->channel = $this->getResponseValue('channel', Channel::class);
    }

    /**
     * @return Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    public function getEventId()
    {
        return $this->type . '_' . $this->channel->getIdentifier();
    }
}
