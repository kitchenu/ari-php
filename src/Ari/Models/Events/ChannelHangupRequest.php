<?php

namespace Ari\Models\Events;

/**
 * Event of a hangup was requested on the channel
 */
class ChannelHangupRequest extends ChannelEvent
{
    /**
     * @var int (optional) - Integer representation of the cause of the hangup.
     */
    protected $cause;

    /**
     * @var boolean (optional) - Whether the hangup request was a soft hangup request.
     */
    protected $soft;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->cause = $this->getResponseValue('cause');
        $this->soft = $this->getResponseValue('soft');
    }

    /**
     * @return int
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @return boolean
     */
    public function getSoft()
    {
        return $this->soft;
    }
}
