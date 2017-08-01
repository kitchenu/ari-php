<?php

namespace Ari\Models\Events;

/**
 * Event of DTMF received on a channel
 */
class ChannelDtmfReceived extends ChannelEvent
{
    /**
     * @var string DTMF digit received (0-9, A-E, # or *)
     */
    protected $digit;

    /**
     * @var int Number of milliseconds DTMF was received
     */
    protected $durationMs;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->digit = $this->getResponseValue('digit');
        $this->durationMs = $this->getResponseValue('duration_ms');
    }

    /**
     * @return string DTMF digit received (0-9, A-E, # or *)
     */
    public function getDigit()
    {
        return $this->digit;
    }

    /**
     * @return int Number of milliseconds DTMF was received
     */
    public function getDurationMs()
    {
        return $this->durationMs;
    }
}
