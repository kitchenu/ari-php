<?php

namespace Ari\Models\Events;

use Ari\Models\Channel;
use Ari\Models\Bridge;

/**
 * Event of notification that an attended transfer has occurred
 */
class BridgeAttendedTransfer extends Event
{
    /**
     * @var string (optional) - Application that has been transferred into
     */
    protected $destinationApplication;

    /**
     * @var string (optional) - Bridge that survived the merge result
     */
    protected $destinationBridge;

    /**
     * @var Channel (optional) - First leg of a link transfer result
     */
    protected $destinationLinkFirstLeg;

    /**
     * @var Channel (optional) - Second leg of a link transfer result
     */
    protected $destinationLinkSecondLeg;

    /**
     * @var Bridge (optional) - Bridge that survived the threeway result
     */
    protected $destinationThreewayBridge;

    /**
     * @var Channel (optional) - Transferer channel that survived the threeway result
     */
    protected $destinationThreewayChannel;

    /**
     * @var string How the transfer was accomplished
     */
    protected $destinationType;

    /**
     * @var boolean Whether the transfer was externally initiated or not
     */
    protected $isExternal;

    /**
     * @var Channel (optional) - The channel that is replacing transferer_first_leg in the swap
     */
    protected $replaceChannel;

    /**
     * @var string The result of the transfer attempt
     */
    protected $result;

    /**
     * @var Channel (optional) - The channel that is being transferred to
     */
    protected $transferTarget;

    /**
     * @var Channel (optional) - The channel that is being transferred
     */
    protected $transferee;

    /**
     * @var Channel First leg of the transferer
     */
    protected $transfererFirstLeg;

    /**
     * @var Bridge (optional) - Bridge the transferer first leg is in
     */
    protected $transfererFirstLegBridge;

    /**
     * @var Channel Second leg of the transferer
     */
    protected $transfererSecondLeg;

    /**
     * @var Bridge (optional) - Bridge the transferer second leg is in
     */
    protected $transfererSecondLegBridge;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->destinationApplication = $this->getResponseValue('destination_application');
        $this->destinationBridge = $this->getResponseValue('destination_bridge');
        $this->destinationLinkFirstLeg = $this->getResponseValue('destination_link_first_leg', Channel::class);
        $this->destinationLinkSecondLeg = $this->getResponseValue('destination_link_second_leg', Channel::class);
        $this->destinationThreewayBridge = $this->getResponseValue('destination_threeway_bridge', Bridge::class);
        $this->destinationThreewayChannel = $this->getResponseValue('destination_threeway_channel', Channel::class);
        $this->destinationType = $this->getResponseValue('destination_type');
        $this->isExternal = $this->getResponseValue('is_external');
        $this->replaceChannel = $this->getResponseValue('replace_channel', Channel::class);
        $this->result = $this->getResponseValue('result');
        $this->transferTarget = $this->getResponseValue('transfer_target', Channel::class);
        $this->transferee = $this->getResponseValue('transferee', Channel::class);
        $this->transfererFirstLeg = $this->getResponseValue('transferer_first_leg', Channel::class);
        $this->transfererFirstLegBridge = $this->getResponseValue('transferer_first_leg_bridge', Bridge::class);
        $this->transfererSecondLeg = $this->getResponseValue('transferer_second_leg', Channel::class);
        $this->transfererSecondLegBridge = $this->getResponseValue('transferer_second_leg_bridge', Bridge::class);
    }

    /**
     * @return string (optional) - Application that has been transferred into
     */
    public function getDestinationApplication()
    {
        return $this->destinationApplication;
    }

    /**
     * @return string (optional) - Bridge that survived the merge result
     */
    public function getDestinationBridge()
    {
        return $this->destinationBridge;
    }

    /**
     * @return Channel (optional) - First leg of a link transfer result
     */
    public function getDestinationLinkFirstLeg()
    {
        return $this->destinationLinkFirstLeg;
    }

    /**
     * @return Channel (optional) - Second leg of a link transfer result
     */
    public function getDestinationLinkSecondLeg()
    {
        return $this->destinationLinkSecondLeg;
    }

    /**
     * @return Bridge (optional) - Bridge that survived the threeway result
     */
    public function getDestinationThreewayBridge()
    {
        return $this->destinationThreewayBridge;
    }

    /**
     * @return Channel (optional) - Transferer channel that survived the threeway result
     */
    public function getDestinationThreewayChannel()
    {
        return $this->destinationThreewayChannel;
    }

    /**
     * @return string How the transfer was accomplished
     */
    public function getDestinationType()
    {
        return $this->destinationType;
    }

    /**
     * @return boolean Whether the transfer was externally initiated or not
     */
    public function isExternal()
    {
        return $this->isExternal;
    }

    /**
     * @return Channel (optional) - The channel that is replacing transferer_first_leg in the swap
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
     * @return Channel (optional) - The channel that is being transferred to
     */
    public function getTransferTarget()
    {
        return $this->transferTarget;
    }

    /**
     * @return Channel (optional) - The channel that is being transferred
     */
    public function getTransferee()
    {
        return $this->transferee;
    }

    /**
     * @return Channel First leg of the transferer
     */
    public function getTransfererFirstLeg()
    {
        return $this->transfererFirstLeg;
    }

    /**
     * @return Bridge (optional) - Bridge the transferer first leg is in
     */
    public function getTransfererFirstLegBridge()
    {
        return $this->transfererFirstLegBridge;
    }

    /**
     * @return Channel Second leg of the transferer
     */
    public function getTransfererSecondLeg()
    {
        return $this->transfererSecondLeg;
    }

    /**
     * @return Bridge (optional) - Bridge the transferer second leg is in
     */
    public function getTransfererSecondLegBridge()
    {
        return $this->transfererSecondLegBridge;
    }
}
