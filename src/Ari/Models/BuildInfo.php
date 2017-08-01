<?php

namespace Ari\Models;

class BuildInfo extends Model
{
    /**
     * @var string Username that build Asterisk
     */
    protected $user;

    /**
     * @var string Compile time options, or empty string if default.
     */
    protected $options;

    /**
     * @var string Machine architecture (x86_64, i686, ppc, etc.)
     */
    protected $machine;

    /**
     * @var string OS Asterisk was built on.
     */
    protected $os;

    /**
     * @var string Kernel version Asterisk was built on.
     */
    protected $kernel;

    /**
     * @var string Date and time when Asterisk was built.
     */
    protected $date;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->user = $this->getResponseValue('user');
        $this->options = $this->getResponseValue('options');
        $this->machine = $this->getResponseValue('machine');
        $this->os = $this->getResponseValue('os');
        $this->kernel = $this->getResponseValue('kernel');
        $this->date = $this->getResponseValue('date');
    }

    /**
     * @return string Username that build Asterisk
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string Compile time options, or empty string if default.
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string Machine architecture (x86_64, i686, ppc, etc.)
     */
    public function getMachine()
    {
        return $this->machine;
    }

    /**
     * @return string OS Asterisk was built on.
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * @return string Kernel version Asterisk was built on.
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return string Date and time when Asterisk was built.
     */
    public function getDate()
    {
        return $this->date;
    }
}
