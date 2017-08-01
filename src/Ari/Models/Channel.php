<?php

namespace Ari\Models;

use DateTime;

class Channel extends Model implements IdentifiableModelInterface
{
    /**
     * @var string
     */
    protected $accountCode;

    /**
     * @var CallerId
     */
    protected $caller;

    /**
     * @var CallerId
     */
    protected $connected;

    /**
     * @var DateTime
     */
    protected $creationTime;

    /**
     * @var DialplanCep
     */
    protected $dialplan;

    /**
     * @var string Unique identifier of the channel.  This is the same as the Uniqueid field in AMI.
     */
    protected $id;

    /**
     * @var string Name of the channel (i.e. SIP/foo-0000a7e3)
     */
    protected $name;

    /**
     * @var string
     */
    protected $state;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->accountCode = $this->getResponseValue('accountcode');
        $this->caller = $this->getResponseValue('caller', CallerId::class);
        $this->connected = $this->getResponseValue('connected', CallerId::class);
        $this->creationTime = $this->getResponseValue('creationtime', DateTime::class);
        $this->dialplan = $this->getResponseValue('dialplan', DialplanCep::class);
        $this->id = $this->getResponseValue('id');
        $this->name = $this->getResponseValue('name');
        $this->state = $this->getResponseValue('state');
    }

    /**
     * @return string
     */
    public function getAccountCode()
    {
        return $this->accountCode;
    }

    /**
     * @return CallerId Caller identification
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * @return CallerId Connected caller identification
     */
    public function getConnected()
    {
        return $this->connected;
    }

    /**
     * @return DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }

    /**
     * @return DialplanCep Dialplan location (context/extension/priority)
     */
    public function getDialplan()
    {
        return $this->dialplan;
    }

    /**
     * @return string Unique identifier of the channel.  This is the same as the Uniqueid field in AMI.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string Name of the channel (i.e. SIP/foo-0000a7e3)
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}
