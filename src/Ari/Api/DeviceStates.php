<?php

namespace Ari\Api;

use Ari\Models\DeviceState;

/**
 * Devicestates REST API
 */
class DeviceStates extends Api
{
    /**
     * List all ARI controlled device states.
     *
     * @return DeviceState[]
     */
    public function getDeviceStates()
    {
        $response = $this->request('GET', 'deviceStates');

        return $this->build($response, DeviceState::class);
    }

    /**
     * Retrieve the current state of a device.
     *
     * @param string $deviceName
     * @return DeviceState
     */
    public function getDeviceState($deviceName)
    {
        $response = $this->request('GET', "deviceStates/$deviceName");

        return $this->build($response, DeviceState::class);
    }

    /**
     * Change the state of a device controlled by ARI. (Note - implicitly creates the device state).
     *
     * @param string $deviceName
     * @param string $queryParams
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function updateDeviceState($deviceName, array $queryParams)
    {
        $params = array_merge([
            'deviceState' => null,
        ], $queryParams);

        $this->request('PUT', "deviceStates/$deviceName", $params);
    }

    /**
     * Destroy a device-state controlled by ARI.
     *
     * @param string $deviceName Name of the device
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function deleteDeviceState($deviceName)
    {
        $this->request('DELETE', "deviceStates/$deviceName");
    }
}
