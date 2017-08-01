<?php

namespace Ari\Models;

class Bridge extends Model implements IdentifiableModelInterface
{
    const TYPE_MIXING = 'mixing';
    const TYPE_HOLDING = 'holding';
    const TYPE_DTMF_EVENTS = 'dtmf_events';
    const TYPE_PROXY_MEDIA = 'proxy_media';

    /**
     * @var string Bridging class
     */
    protected $bridgeClass;

    /**
     * @var string Type of bridge technology (mixing, holding, dtmf_events, proxy_media)
     */
    protected $bridgeType;

    /**
     * @var array Ids of channels participating in this bridge
     */
    protected $channelIds;

    /**
     * @var string  Entity that created the bridge
     */
    protected $creator;

    /**
     * @var string Unique identifier for this bridge
     */
    protected $id;

    /**
     * @var string Unique identifier for this bridge
     */
    protected $name;

    /**
     * @var string Name of the current bridging technology
     */
    protected $technology;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridgeClass = $this->getResponseValue('bridge_class');
        $this->bridgeType = $this->getResponseValue('bridge_type');
        $this->channels = $this->getResponseValue('channels');
        $this->creator = $this->getResponseValue('creator');
        $this->id = $this->getResponseValue('id');
        $this->name = $this->getResponseValue('name');
        $this->technology = $this->getResponseValue('technology');
    }

    /**
     * @return string Bridging class
     */
    public function getBridgeClass()
    {
        return $this->bridgeClass;
    }

    /**
     * @return string Type of bridge technology (mixing, holding, dtmf_events, proxy_media)
     */
    public function getBridgeType()
    {
        return $this->bridgeType;
    }

    /**
     * @return array Ids of channels participating in this bridge
     */
    public function getChannelIds()
    {
        return $this->channelIds;
    }

    /**
     * @return string Entity that created the bridge
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return string Unique identifier for this bridge
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string Unique identifier for this bridge
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string Name of the current bridging technology
     */
    public function getTechnology()
    {
        return $this->technology;
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}
