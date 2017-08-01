<?php

namespace Ari;

use GuzzleHttp\Client;
use Ari\Api\Applications;
use Ari\Api\Asterisk;
use Ari\Api\Bridges;
use Ari\Api\Channels;
use Ari\Api\DeviceStates;
use Ari\Api\Endpoints;
use Ari\Api\Events;
use Ari\Api\Mailboxes;
use Ari\Api\Playbacks;
use Ari\Api\Recordings;
use Ari\Api\Sounds;

class AriClient
{
    /**
     * @var array 
     */
    protected $config;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Applications
     */
    protected $applications;

    /**
     * @var Asterisk
     */
    protected $asterisk;

    /**
     * @var Bridges
     */
    protected $bridges;

    /**
     * @var Channels
     */
    protected $channels;

    /**
     * @var DeviceStates
     */
    protected $deviceStates;

    /**
     * @var Endpoints
     */
    protected $endpoints;

    /**
     * @var Events
     */
    protected $events;

    /**
     * @var Mailboxes
     */
    protected $mailboxes;

    /**
     * @var Playbacks
     */
    protected $playbacks;

    /**
     * @var Recordings
     */
    protected $recordings;

    /**
     * @var Sounds
     */
    protected $sounds;

    public function __construct(array $config)
    {
        $this->config = $config + [
            'verify' => false
        ];

        $this->httpClient = new Client($this->config);
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Applications
     */
    public function applications()
    {
        if (!$this->applications instanceof Applications) {
            $this->applications = new Applications($this->httpClient);
        }

        return $this->applications;
    }

    /**
     * @return Asterisk
     */
    public function asterisk()
    {
        if (!$this->asterisk instanceof Asterisk) {
            $this->asterisk = new Asterisk($this->httpClient);
        }

        return $this->asterisk;
    }

    /**
     * @return Bridges
     */
    public function bridges()
    {
        if (!$this->bridges instanceof Bridges) {
            $this->bridges = new Bridges($this->httpClient);
        }

        return $this->bridges;
    }

    /**
     * @return Channels
     */
    public function channels()
    {
        if (!$this->channels instanceof Channels) {
            $this->channels = new Channels($this->httpClient);
        }

        return $this->channels;
    }

    /**
     * @return DeviceStates
     */
    public function deviceStates()
    {
        if (!$this->deviceStates instanceof DeviceStates) {
            $this->deviceStates = new DeviceStates($this->httpClient);
        }

        return $this->deviceStates;
    }

    /**
     * @return Endpoints
     */
    public function endpoints()
    {
        if (!$this->endpoints instanceof Endpoints) {
            $this->endpoints = new Endpoints($this->httpClient);
        }

        return $this->endpoints;
    }

    /**
     * @return Events
     */
    public function events()
    {
        if (!$this->events instanceof Events) {
            $this->events = new Events($this->httpClient);
        }

        return $this->events;
    }

    /**
     * @return Mailboxes
     */
    public function mailboxes()
    {
        if (!$this->mailboxes instanceof Mailboxes) {
            $this->mailboxes = new Mailboxes($this->httpClient);
        }

        return $this->mailboxes;
    }

    /**
     * @return Playbacks
     */
    public function playbacks()
    {
        if (!$this->playbacks instanceof Playbacks) {
            $this->playbacks = new Playbacks($this->httpClient);
        }

        return $this->playbacks;
    }

    /**
     * @return Recordings
     */
    public function recordings()
    {
        if (!$this->recordings instanceof Recordings) {
            $this->recordings = new Recordings($this->httpClient);
        }

        return $this->recordings;
    }

    /**
     * @return Sounds
     */
    public function sounds()
    {
        if (!$this->sounds instanceof Sounds) {
            $this->sounds = new Sounds($this->httpClient);
        }

        return $this->sounds;
    }
}
