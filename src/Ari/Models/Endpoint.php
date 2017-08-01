<?php

namespace Ari\Models;

class Endpoint extends Model implements IdentifiableModelInterface
{
    /**
     * @var array Id's of channels associated with this endpoint
     */
    protected $channelIds;

    /**
     * @var string Identifier of the endpoint, specific to the given technology.
     */
    protected $resource;

    /**
     * @var string (optional) - Endpoint's state
     */
    protected $state;

    /**
     * @var string Technology of the endpoint
     */
    protected $technology;

    /**
     * @param string $response The raw json response response data from ARI
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->channelIds = $this->getResponseValue('channel_ids');
        $this->resource = $this->getResponseValue('resource');
        $this->state = $this->getResponseValue('state');
        $this->technology = $this->getResponseValue('technology');
    }

    /**
     * @return array Id's of channels associated with this endpoint
     */
    public function getChannelIds()
    {
        return $this->channelIds;
    }

    /**
     * @return string Identifier of the endpoint, specific to the given technology.
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string (optional) - Endpoint's state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string Technology of the endpoint
     */
    public function getTechnology()
    {
        return $this->technology;
    }

    public function getIdentifier()
    {
        return $this->resource;
    }
}
