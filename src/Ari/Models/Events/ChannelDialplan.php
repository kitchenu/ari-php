<?php

namespace Ari\Models\Events;

/**
 * Event of channel changed location in the dialplan
 */
class ChannelDialplan extends ChannelEvent
{
    /**
     * @var string The application about to be executed.
     */
    protected $dialplanApp;

    /**
     * @var string The data to be passed to the application.
     */
    protected $dialplanAppData;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->dialplanApp = $this->getResponseValue('dialplan_app');
        $this->dialplanAppData = $this->getResponseValue('dialplan_app_data');
    }

    /**
     * @return string The application about to be executed.
     */
    public function getDialplanApp()
    {
        return $this->dialplanApp;
    }

    /**
     * @return string The data to be passed to the application.
     */
    public function getDialplanAppData()
    {
        return $this->dialplanAppData;
    }
}
