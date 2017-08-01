<?php

namespace Ari\Models;

class Peer extends Model
{
    /**
     * @var string ID for this playback operation
     */
    protected $address;

    /**
     * @var string (optional) - For media types that support multiple languages, the language requested for playback.
     */
    protected $cause;

    /**
     * @var string URI for the media to play back.
     */
    protected $peerStatus;

    /**
     * @var string Current state of the playback operation.
     */
    protected $port;

    /**
     * @var string URI for the channel or bridge to play the media on
     */
    protected $time;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->address = $this->getResponseValue('address');
        $this->cause = $this->getResponseValue('cause');
        $this->peerStatus = $this->getResponseValue('peer_status');
        $this->port = $this->getResponseValue('port');
        $this->time = $this->getResponseValue('time');
    }

    /**
     * @return string ID for this playback operation
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string (optional) - For media types that support multiple languages, the language requested for playback.
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @return string URI for the media to play back.
     */
    public function getPeerStatus()
    {
        return $this->peerStatus;
    }

    /**
     * @return string Current state of the playback operation.
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string URI for the channel or bridge to play the media on
     */
    public function getTime()
    {
        return $this->time;
    }
}
