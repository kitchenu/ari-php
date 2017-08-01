<?php

namespace Ari\Models;

class StatusInfo extends Model
{
    /**
     * @var DateTime Time when Asterisk was last reloaded.
     */
    protected $lastReloadTime;

    /**
     * @var DateTime Time when Asterisk was started.
     */
    protected $startupTime;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->lastReloadTime = $this->getResponseValue('last_reload_time');
        $this->startupTime = $this->getResponseValue('startup_time');
    }

    /**
     * @return DateTime Time when Asterisk was last reloaded.
     */
    public function getLastReloadTime()
    {
        return new $this->lastReloadTime;
    }

    /**
     * @return DateTime Time when Asterisk was started.
     */
    public function getStartupTime()
    {
        return $this->startupTime;
    }
}
