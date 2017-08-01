<?php

namespace Ari\Models;

class Module extends Model
{
    /**
     * @var BuildInfo Info about how Asterisk was built
     */
    protected $description;

    /**
     * @var ConfigInfo Info about Asterisk configuration
     */
    protected $name;

    /**
     * @var StatusInfo Info about Asterisk status
     */
    protected $status;

    /**
     * @var SystemInfo Info about Asterisk
     */
    protected $supportLevel;

    /**
     * @var SystemInfo Info about Asterisk
     */
    protected $useCount;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->description = $this->getResponseValue('description');
        $this->name = $this->getResponseValue('name');
        $this->status = $this->getResponseValue('status');
        $this->supportLevel = $this->getResponseValue('support_level');
        $this->useCount = $this->getResponseValue('use_count');
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getSupportLevel()
    {
        return $this->supportLevel;
    }

    public function getUseCount()
    {
        return $this->useCount;
    }
}
