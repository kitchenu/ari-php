<?php

namespace Ari\Models;

class Application extends Model
{
    /**
     * @var array Id's for bridges subscribed to.
     */
    protected $bridgeIds;

    /**
     * @var array Id's for channels subscribed to.
     */
    protected $channelIds;

    /**
     * @var array Names of the devices subscribed to.
     */
    protected $deviceNames;

    /**
     * @var array {tech}/{resource} for endpoints subscribed to.
     */
    protected $endpointIds;

    /**
     * @var string Name of this application
     */
    protected $name;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridgeIds = $this->getResponseValue('bridge_ids');
        $this->channelIds = $this->getResponseValue('channel_ids');
        $this->deviceNames = $this->getResponseValue('device_names');
        $this->endpointIds = $this->getResponseValue('endpoint_ids');
        $this->name = $this->getResponseValue('name');
    }


    /**
     * @return array Id's for bridges subscribed to.
     */
    public function getBridgeIds()
    {
        return $this->bridgeIds;
    }

    /**
     * @return array Id's for channels subscribed to.
     */
    public function getChannelIds()
    {
        return $this->channelIds;
    }

    /**
     * @return array Names of the devices subscribed to.
     */
    public function getDeviceNames()
    {
        return $this->deviceNames;
    }

    /**
     * @return array {tech}/{resource} for endpoints subscribed to.
     */
    public function getEndpointIds()
    {
        return $this->endpointIds;
    }

    /**
     * @return string string Name of this application
     */
    public function getName()
    {
        return $this->name;
    }
}
