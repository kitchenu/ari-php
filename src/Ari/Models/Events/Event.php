<?php

namespace Ari\Models\Events;

use DateTime;

/**
 * Base type for events
 */
class Event extends Message implements EventInterface
{
    const APPLICATION_REPLACED = 'ApplicationReplaced';
    const BRIDGE_ATTENDED_TRANSFER = 'BridgeAttendedTransfer';
    const BRIDGE_BLIND_TRANSFER = 'BridgeBlindTransfer';
    const BRIDGE_CREATED = 'BridgeCreated';
    const BRIDGE_DESTROYED = 'BridgeDestroyed';
    const BRIDGE_MERGED = 'BridgeMerged';
    const BRIDGE_VIDEO_SOURCE_CHANGED = 'BridgeVideoSourceChanged';
    const CHANNEL_CALLER_ID = 'ChannelCallerId';
    const CHANNEL_CREATED = 'ChannelCreated';
    const CHANNEL_CONNECTED_LINE = 'ChannelConnectedLine';
    const CHANNEL_DESTROYED = 'ChannelDestroyed';
    const CHANNEL_DIALPLAN = 'ChannelDialplan';
    const CHANNEL_DTMF_RECEIVED = 'ChannelDtmfReceived';
    const CHANNEL_ENTERED_BRIDGE = 'ChannelEnteredBridge';
    const CHANNEL_HANGUP_REQUEST = 'ChannelHangupRequest';
    const CHANNEL_HOLD = 'ChannelHold';
    const CHANNEL_LEFT_BRIDGE = 'ChannelLeftBridge';
    const CHANNEL_STATE_CHANGED = 'ChannelStateChanged';
    const CHANNEL_TALKING_FINISHED = 'ChannelTalkingFinished';
    const CHANNEL_TALKING_STARTED = 'ChannelTalkingStarted';
    const CHANNEL_UNHOLD = 'ChannelUnhold';
    const CHANNEL_USEREVENT = 'ChannelUserevent';
    const CHANNEL_VARSET = 'ChannelVarset';
    const DEVICE_STATE_CHANGE = 'DeviceStateChange';
    const DIAL = 'Dial';
    const DIALED = 'Dialed';
    const ENDPOINT_STATE_CHANGE = 'EndpointStateChange';
    const PEER_STATUS_CHANGE = 'PeerStatusChange';
    const PLAYBACK_FINISHED = 'PlaybackFinished';
    const PLAYBACK_STARTED = 'PlaybackStarted';
    const RECORDING_FAILED = 'RecordingFailed';
    const RECORDING_FINISHED = 'RecordingFinished';
    const RECORDING_STARTED = 'RecordingStarted';
    const STASIS_END = 'StasisEnd';
    const STASIS_START = 'StasisStart';
    const TEXT_MESSAGE_RECEIVED = 'TextMessageReceived';

    protected $asteriskId;

    /**
     * @var string Name of the application receiving the event.
     */
    protected $application;

    /**
     * @var DateTime (optional) - Time at which this event was created.
     */
    protected $timestamp;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->asteriskId = $this->getResponseValue('asterisk_id');
        $this->application = $this->getResponseValue('application');
        $this->timestamp = $this->getResponseValue('timestamp', DateTime::class);
    }

    /**
     * @return string Name of the application receiving the event.
     */
    public function getAsteriskId()
    {
        return $this->asteriskId;
    }

    /**
     * @return string Name of the application receiving the event.
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return \DateTime (optional) - Time at which this event was created.
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
