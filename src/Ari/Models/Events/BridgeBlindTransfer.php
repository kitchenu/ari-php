<?php

namespace Ari\Models\Events;

use Ari\Models\Channel;
use Ari\Models\Bridge;

/**
 * Event of notification that a blind transfer has occurred
 */
class BridgeBlindTransfer extends Event
{
    /**
     * @var Bridge (optional) - The bridge being transferred
     */
    protected $bridge;

    /**
     * @var Channel The channel performing the blind transfer
     */
    protected $channel;

    /**
     * @var string The context transferred to
     */
    protected $contex;

    /**
     * @var string The extension transferred to
     */
    protected $exten;

    /**
     * @var boolean Whether the transfer was externally initiated or not
     */
    protected $isExternal;

    /**
     * @var Channel (optional) - The channel that is replacing transferer when the transferee(s) can not be transferred directly
     */
    protected $replaceChannel;

    /**
     * @var string The result of the transfer attempt
     */
    protected $result;

    /**
     * @var Channel (optional) - The channel that is being transferred
     */
    protected $transferee;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->bridge = $this->getResponseValue('bridge', Bridge::class);
        $this->channel = $this->getResponseValue('channel', Channel::class);
        $this->contex = $this->getResponseValue('context');
        $this->exten = $this->getResponseValue('exten');
        $this->isExternal = $this->getResponseValue('is_external');
        $this->replaceChannel = $this->getResponseValue('replace_channel', Channel::class);
        $this->result = $this->getResponseValue('result');
        $this->transferee = $this->getResponseValue('transferee', Channel::class);
    }

    /**
     * @return Bridge (optional) - The bridge being transferred
     */
    public function getBridge()
    {
        return $this->bridge;
    }

    /**
     * @return Channel The channel performing the blind transfer
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return string The context transferred to
     */
    public function getContext()
    {
        return $this->contex;
    }

    /**
     * @return string The extension transferred to
     */
    public function getExten()
    {
        return $this->exten;
    }

    /**
     * @return boolean Whether the transfer was externally initiated or not
     */
    public function isExternal()
    {
        return $this->isExternal;
    }

    /**
     * @return Channel (optional) - The channel that is replacing transferer when the transferee(s) can not be transferred directly
     */
    public function getReplaceChannel()
    {
        return $this->replaceChannel;
    }

    /**
     * @return string The result of the transfer attempt
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return Channel (optional) - The channel that is being transferred
     */
    public function getTransferee()
    {
        return $this->transferee;
    }
}
