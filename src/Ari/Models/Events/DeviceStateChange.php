<?php

namespace Ari\Models\Events;

use Ari\Models\DeviceState;

/**
 * Event of notification that a device state has changed
 */
class DeviceStateChange extends Event
{
    /**
     * @var DeviceState
     */
    protected $deviceState;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->deviceState = $this->getResponseValue('device_state', DeviceState::class);
    }

    /**
     * @return DeviceState
     */
    public function getDeviceState()
    {
        return $this->deviceState;
    }
}
