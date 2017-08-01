<?php

namespace Ari\Models\Events;

use Ari\Models\Channel;

/**
 * Event of dialing state has changed
 */
class Dial extends Event
{
    /**
     * Valid dialstatus values
     */
    const DIALSTATUS_ANSWER = 'answer';
    const DIALSTATUS_BUSY = 'busy';
    const DIALSTATUS_NOANSWER = 'noanswer';
    const DIALSTATUS_CANCEL = 'cancel';
    const DIALSTATUS_CONGESTION = 'congestion';
    const DIALSTATUS_CHANUNAVAIL = 'chanunavail';
    const DIALSTATUS_DONTCALL = 'dontcall';
    const DIALSTATUS_TORTURE = 'torture';
    const DIALSTATUS_INVALIDARGS = 'invalidargs';

    /**
     * @var Channel (optional) - The channel on which the variable was set. If missing, the variable is a global variable.
     */
    protected $caller;

    /**
     * @var string Current status of the dialing attempt to the peer.
     */
    protected $dialstatus;

    /**
     * @var string (optional) - The dial string for calling the peer channel.
     */
    protected $dialstring;

    /**
     * @var string (optional) - Forwarding target requested by the original dialed channel.
     */
    protected $forward;

    /**
     * @var Channel (optional) - Channel that the caller has been forwarded to.
     */
    protected $forwarded;

    /**
     * @var Channel The dialed channel.
     */
    protected $peer;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->caller = $this->getResponseValue('channel', Channel::class);
        $this->dialstatus = $this->getResponseValue('dialstatus');
        $this->dialstring = $this->getResponseValue('dialstring');
        $this->forward = $this->getResponseValue('forward');
        $this->forwarded = $this->getResponseValue('forwarded', Channel::class);
        $this->peer = $this->getResponseValue('peer', Channel::class);
    }

    /**
     * @return Channel (optional) - The calling channel.
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * @return string - Current status of the dialing attempt to the peer.
     */
    public function getDialstatus()
    {
        return $this->dialstatus;
    }

    /**
     * @return string (optional) - The dial string for calling the peer channel.
     */
    public function getDialstring()
    {
        return $this->dialstring;
    }

    /**
     * @return string (optional) - Forwarding target requested by the original dialed channel.
     */
    public function getForward()
    {
        return $this->forward;
    }

    /**
     * @return Channel (optional) - Forwarding target requested by the original dialed channel.
     */
    public function getForwarded()
    {
        return $this->forwarded;
    }

    /**
     * @return Channel The dialed channel.
     */
    public function getPeer()
    {
        return $this->peer;
    }
}
