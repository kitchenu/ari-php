<?php

namespace Ari\Models;

class LogChannel extends Model
{
    /**
     * @var BuildInfo Info about how Asterisk was built
     */
    protected $channel;

    /**
     * @var ConfigInfo Info about Asterisk configuration
     */
    protected $configuration;

    /**
     * @var StatusInfo Info about Asterisk status
     */
    protected $status;

    /**
     * @var SystemInfo Info about Asterisk
     */
    protected $type;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->channel = $this->getResponseValue('channel');
        $this->configuration = $this->getResponseValue('configuration');
        $this->status = $this->getResponseValue('status');
        $this->type = $this->getResponseValue('type');
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getType()
    {
        return $this->type;
    }
}
