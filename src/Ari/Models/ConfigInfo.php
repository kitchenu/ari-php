<?php

namespace Ari\Models;

use Ari\Models\SetId;

class ConfigInfo extends Model
{
    /**
     * @var string Default language for media playback.
     */
    private $default_language;

    /**
     * @var int (optional) - Maximum number of simultaneous channels.
     */
    private $max_channels;

    /**
     * @var float (optional) - Maximum load avg on system.
     */
    private $max_load;

    /**
     * @var int (optional) - Maximum number of open file handles (files, sockets).
     */
    private $max_open_files;

    /**
     * @var string Asterisk system name.
     */
    private $name;

    /**
     * @var SetId Effective user/group id for running Asterisk.
     */
    private $setid;


    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->default_language = $this->getResponseValue('default_language');
        $this->max_channels = $this->getResponseValue('max_channels');
        $this->max_load = $this->getResponseValue('max_load');
        $this->max_open_files =$this->getResponseValue('max_open_files');
        $this->name = $this->getResponseValue('name');
        $this->setid = $this->getResponseValue('setid', SetId::class);
    }

    /**
     * @return string Default language for media playback.
     */
    public function getDefaultLanguage()
    {
        return $this->default_language;
    }

    /**
     * @return int (optional) - Maximum number of simultaneous channels.
     */
    public function getMaxChannels()
    {
        return $this->max_channels;
    }

    /**
     * @return float (optional) - Maximum load avg on system.
     */
    public function getMaxLoad()
    {
        return $this->max_load;
    }

    /**
     * @return int (optional) - Maximum number of open file handles (files, sockets).
     */
    public function getMaxOpenFiles()
    {
        return $this->max_open_files;
    }

    /**
     * @return string Asterisk system name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return SetId Effective user/group id for running Asterisk.
     */
    public function getSetid()
    {
        return $this->setid;
    }
}
