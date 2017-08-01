<?php

namespace Ari\Models;

class ContactInfo extends Model
{
    /**
     * @var string Default language for media playback.
     */
    protected $aor;

    /**
     * @var int (optional) - Maximum number of simultaneous channels.
     */
    protected $contactStatus;

    /**
     * @var float (optional) - Maximum load avg on system.
     */
    protected $roundtripUsec;

    /**
     * @var int (optional) - Maximum number of open file handles (files, sockets).
     */
    protected $uri;


    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->aor = $this->getResponseValue('aor');
        $this->contactStatus = $this->getResponseValue('contact_status');
        $this->roundtripUsec= $this->getResponseValue('roundtrip_usec');
        $this->uri = $this->getResponseValue('uri');
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
