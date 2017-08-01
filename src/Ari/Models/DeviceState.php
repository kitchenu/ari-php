<?php

namespace Ari\Models;

class DeviceState extends Model implements IdentifiableModelInterface
{
    /**
     * @var string Name of the device.
     */
    protected $name;

    /**
     * @var string Device's state
     */
    protected $state;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->name = $this->getResponseValue('name');
        $this->state = $this->getResponseValue('state');
    }
    
    /**
     * @return string Name of the device.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string Device's state
     */
    public function getState()
    {
        return $this->state;
    }

    public function getIdentifier()
    {
        return $this->name;
    }
}
