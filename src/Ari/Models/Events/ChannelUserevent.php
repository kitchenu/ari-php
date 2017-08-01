<?php

namespace Ari\Models\Events;

use Ari\Models\Bridge;
use Ari\Models\Endpoint;
use Ari\Models\Channel;

/**
 * Event of user-generated event with additional user-defined fields in the object
 */
class ChannelUserevent extends Event implements IdentifiableEventInterface
{
    /**
     * @var Bridge (optional) - A bridge that is signaled with the user event.
     */
    protected $bridge;

    /**
     * @var Channel (optional) - A channel that is signaled with the user event.
     */
    protected $channel;

    /**
     * @var Endpoint (optional) - A endpoint that is signaled with the user event.
     */
    protected $endpoint;

    /**
     * @var string The name of the user event.
     */
    protected $eventname;

    /**
     * @var object Custom Userevent data
     */
    protected $userevent;

    /**
     * @return Bridge (optional) - A bridge that is signaled with the user event.
     */
    public function getBridge()
    {
        return $this->bridge;
    }

    /**
     * @return Channel (optional) - A channel that is signaled with the user event.
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return Endpoint (optional) - A endpoint that is signaled with the user event.
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return string The name of the user event.
     */
    public function getEventname()
    {
        return $this->eventname;
    }

    /**
     * @return mixed Custom Userevent data
     */
    public function getUserevent()
    {
        return $this->userevent;
    }

    public function getEventId()
    {
        $eventId = $this->getType() . '_' . $this->getEventname();

        if ($this->channel) {
            $eventId .= '_' . $this->channel->getIdentifier();
        } elseif ($this->bridge) {
            $eventId .= '_' . $this->bridge->getIdentifier();
        } elseif ($this->endpoint) {
            $eventId .= '_' . $this->endpoint->getIdentifier();
        }

        return $eventId;
    }

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridge = $this->getResponseValue('bridge', Bridge::class);
        $this->channel = $this->getResponseValue('channel', Channel::class);
        $this->endpoint = $this->getResponseValue('endpoint', Endpoint::class);
        $this->eventname = $this->getResponseValue('eventname');
        $this->userevent = $this->getResponseValue('userevent');
    }
    
}
