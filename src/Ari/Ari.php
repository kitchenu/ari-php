<?php

namespace Ari;

use Psr\Log\LoggerInterface;
use React\EventLoop\Factory;
use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ari\Models\Events\Message;
use Ari\Models\Events\IdentifiableEventInterface;
use Ari\Models\IdentifiableModelInterface;
use Ari\Models\Events\Event;
use Exception;
use Ari\Models\Channel;
use Ari\Models\Bridge;
use Ari\Models\Endpoint;

class Ari
{
    protected $config;

    /**
     * @var EventLoop\LoopInterface
     */
    protected $eventLoop;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var AriClient
     */
    protected $ariClient;

    /**
     * @var WebSocket
     */
    protected $wsClient;

    /**
     * @var string
     */
    protected $stasisApplicationName;

    /**
     * @var callable
     */
    protected $onConnect;

    /**
     * @var 
     */
    protected $onEvents = [
        'on' => [],
        'once' => [],
    ];

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(array $config, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->config = $config;
        $this->eventLoop = Factory::create();
        $this->ariClient = new AriClient($this->getAriClientConfig());
    }

    protected function getAriClientConfig()
    {
        $httpOptions = $this->config['http_options'] ?? [];

        return [
            'base_uri' => $this->config['base_uri'],
            'auth' => [$this->config['username'], $this->config['password']]
        ] + $httpOptions;
    }

    public function stop()
    {
        $this->wsClient->close();
    }

    /**
     * Connect and start the event loop
     */
    public function run()
    {
        $this->eventLoop->run();
    }
 
    public function connect($appName)
    {
        $connector = new Connector($this->eventLoop);
        $url = $this->getEventWebsocketUrl($appName);
        $connector($url)
            ->then(function(WebSocket $wsClient) {
                $this->wsClient = $wsClient;
                
                $wsClient->on('message', function(MessageInterface $rawMessage) {
                    $message = new Message(\GuzzleHttp\json_decode($rawMessage->getPayload()));

                    $eventType = '\\Ari\\Models\\Events\\' . $message->getType();

                    if (class_exists('\\Ari\\Models\\Events\\' . $message->getType())) {
                        $event = new $eventType(\GuzzleHttp\json_decode($rawMessage->getPayload()));
                    } else {
                        return;
                    }

                    // Emit the specific event (just to get it back to where it came from)
                    if ($event instanceof IdentifiableEventInterface) {
                        $this->logger->notice("Emitting {$event->getApplication()} ID event: {$event->getEventId()}");
                        $this->wsClient->emit($event->getEventId(), [$event]);
                    }
 
                    // Emit the general event
                    $this->logger->notice("Emitting {$event->getApplication()} event: {$message->getType()}");
                    $this->wsClient->emit($message->getType(), [$event]);
                });

                foreach ($this->onEvents['on'] as $eventName => $listeners) {
                    foreach ($listeners as $listener) {
                        $this->wsClient->on($eventName, function ($event) use ($listener) {
                            $listener($event);
                        });
                    }
                }

                foreach ($this->onEvents['once'] as $eventName => $listeners) {
                    foreach ($listeners as $listener) {
                        $this->wsClient->once($eventName, function ($event) use ($listener) {
                            $listener($event);
                        });
                    }
                }

                $wsClient->on('close', function($code = null, $reason = null) {
                    $this->logger->notice('Disconected Asterisk');

                    $this->eventLoop->stop();
                });

                // keep alive
                $this->addPeriodicTimer(60, function () {
                    $this->wsClient->send('ping');
                });

                $this->logger->notice('Connected Asterisk');
                ($this->onConnect)();
            }, function(Exception $e) {
                $this->logger->notice('Could not connect: ' . $e->getMessage());
                $this->stop();
            });
    }

    public function getEventWebsocketUrl($appName)
    {
        $uriParts = explode('://', $this->config['base_uri']);
        $scheme = ($uriParts[0] === 'https') ? 'wss' : 'ws';
        $username = $this->config['username'] ?? null;
        $password = $this->config['password'] ?? null;

        return  "$scheme://{$uriParts[1]}events?api_key=$username:$password&app=$appName";
    }

    public function on($eventName, callable $listener, $once = false)
    {
        if ($this->wsClient instanceof WebSocket) {
            if ($once) {
                $this->wsClient->once($eventName, $listener);
            } else {
                $this->wsClient->on($eventName, $listener);
            }
        } else {
            if ($once) {
                $this->onEvents['once'][$eventName][] = $listener;
            } else {
                $this->onEvents['on'][$eventName][] = $listener;
            }
        }
    }

    public function once($eventName, callable $listener)
    {
        $this->on($eventName, $listener, true);
    }

    public function removeAllListeners($eventName = null)
    {
        if ($this->wsClient instanceof WebSocket) {
            $this->wsClient->removeAllListeners($eventName);
        } else {
            unset($this->listeners['once'][$eventName]);
            unset($this->listeners['on'][$eventName]);
        }
    }

    public function onIdEvent($event, callable $listener, $model = null, $once = false)
    {
        $eventName = $event;

        if ($model !== null) {
            $eventName .= '_';
            $eventName .= $model instanceof IdentifiableModelInterface ? $model->getIdentifier() : $model;
        }
        
        $this->on($eventName, $listener, $once);
    }

    public function onConnect(callable $listener)
    {
        $this->onConnect = $listener;
    }

    /**
     * @param callable $listener
     */
    public function onApplicationReplaced(callable $listener, $once = false)
    {
        $this->on(Event::APPLICATION_REPLACED, $listener, $once);
    }

    /**
     * @param callable $listener
     */
    public function onBridgeAttendedTransfer(callable $listener, $once = false)
    {
        $this->on(Event::BRIDGE_ATTENDED_TRANSFER, $listener, $once);
    }

    /**
     * @param callable $listener
     */
    public function onBridgeBlindTransfer(callable $listener, $once = false)
    {
        $this->on(Event::BRIDGE_BLIND_TRANSFER, $listener, $once);
    }
 
    /**
     * @param callable $listener
     */
    public function onBridgeCreated(callable $listener, $bridge = null, $once = false)
    {
        $this->onIdEvent(Event::BRIDGE_CREATED, $listener, $bridge, $once);
    }

    /**
     * @param callable $listener
     */
    public function onBridgeDestroyed(callable $listener, $bridge = null, $once = false)
    {
        $this->onIdEvent(Event::BRIDGE_DESTROYED, $listener, $bridge, $once);
    }

    /**
     * @param callable $listener
     */
    public function onBridgeMerged(callable $listener, $bridge = null, $once = false)
    {
        $this->onIdlEvent(Event::BRIDGE_MERGED, $listener, $bridge, $once);
    }

    /**
     * @param callable $listener
     */
    public function onBridgeVideoSourceChanged(callable $listener, $bridge = null, $once = false)
    {
        $this->onIdEvent(Event::BRIDGE_VIDEO_SOURCE_CHANGED,  $listener, $bridge, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelCallerId(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_CALLER_ID, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelConnectedLine(callable $listener, $channel = null, $once = false)
    {        
        $this->onIdEvent(Event::CHANNEL_CONNECTED_LINE, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelCreated(callable $listener, $channel = null, $once = false)
    {        
        $this->onIdEvent(Event::CHANNEL_CALLER_ID, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelDestroyed(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_DESTROYED, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelDialplan(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_DIALPLAN, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelDtmfReceived(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_DTMF_RECEIVED, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelEnteredBridge(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_ENTERED_BRIDGE, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelHangupRequest(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_HANGUP_REQUEST, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelHold(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_HOLD, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelLeftBridge(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_LEFT_BRIDGE, $listener, $channel, $once);
    }
    /**
     * @param callable $listener
     */
    public function onChannelStateChange(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_STATE_CHANGED, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelTalkingFinished(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_TALKING_FINISHED, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelTalkingStarted(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_TALKING_STARTED, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelUnhold(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_UNHOLD, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelUserevent(callable $listener, $userEvent = null, $model = null, $once = false)
    {
        $eventName = Event::CHANNEL_USEREVENT;

        if ($userEvent !== null) {
            $eventName .= '_' . $userEvent . '_' ;

            if ($model instanceof Channel) {
                $eventName .= $model->getIdentifier();
            } elseif ($model instanceof Bridge) {
                $eventName .= $model->getIdentifier();
            } elseif ($model instanceof Endpoint) {
                $eventName .= $model->getIdentifier();
            } else {
                $eventName .= $model;
            }
        }

        $this->on($eventName, $listener, $once);
    }

    /**
     * @param callable $listener
     */
    public function onChannelVarset(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::CHANNEL_VARSET, $listener, $channel, $once);
    }

    /**
     * @param callable $listener
     */
    public function onDeviceStateChanged(callable $listener, $deviceState = null, $once = false)
    {
        $this->onIdEvent(Event::DEVICE_STATE_CHANGE, $listener, $deviceState, $once);
    }

    /**
     * @param callable $listener
     */
    public function onDial(callable $listener, $once = false)
    {
        $this->on(Event::DIAL, $listener, $once);
    }

    /**
     * @param callable $listener
     */
    public function onEndpointStateChange(callable $listener, $endpoint = null, $once = false)
    {
        $this->onIdEvent(Event::ENDPOINT_STATE_CHANGE, $listener, $endpoint, $once);
    }

    /**
     * @param callable $listener
     */
    public function onPeerStatusChange(callable $listener, $endpoint = null, $once = false)
    {
        $this->onIdEvent(Event::PEER_STATUS_CHANGE, $listener, $endpoint, $once);
    }

    public function onPlaybackFinished(callable $listener, $playback = null, $once = false)
    {
        $this->onIdEvent(Event::PLAYBACK_FINISHED, $listener, $playback, $once);
    }

    public function onPlaybackStarted(callable $listener, $playback = null, $once = false)
    {
        $this->onIdEvent(Event::PLAYBACK_STARTED, $listener, $playback, $once);
    }

    public function onRecordingFailed(callable $listener, $recording = null, $once = false)
    {
        $this->onIdEvent(Event::RECORDING_FAILED, $listener, $recording, $once);
    }

    public function onRecordingFinished(callable $listener, $recording = null, $once = false)
    {
        $this->onIdEvent(Event::RECORDING_FINISHED, $listener, $recording, $once);
    }

    public function onRecordingStarted(callable $listener, $recording = null, $once = false)
    {
        $this->onIdEvent(Event::RECORDING_STARTED, $listener, $recording, $once);
    }

    public function onStasisEnd(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::STASIS_END, $listener, $channel, $once);
    }

    public function onStasisStart(callable $listener, $channel = null, $once = false)
    {
        $this->onIdEvent(Event::STASIS_START, $listener, $channel, $once);
    }

    public function onTextMessageReceived(callable $listener, $endpoint = null, $once = false)
    {
        $this->onIdEvent(Event::TEXT_MESSAGE_RECEIVED, $listener, $endpoint, $once);
    }

    public function addPeriodicTimer($interval, callable $callback)
    {
        $this->eventLoop->addPeriodicTimer($interval, $callback);
    }

    public function addTimer($interval, callable $callback)
    {
        $this->eventLoop->addTimer($interval, $callback);
    }

    /**
     * @return AriClient
     */
    public function getAriClient()
    {
        return $this->ariClient;
    }
}
