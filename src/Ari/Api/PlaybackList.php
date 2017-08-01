<?php

namespace phparia\Api;

use phparia\Client\Phparia;
use phparia\Events\PlaybackFinished;
use phparia\Resources\Playback;

class PlaybackList extends \ArrayObject
{
    /**
     * @var Phparia
     */
    protected $phparia;

    protected $playbacks = [];

    public function __construct(Phparia $phparia)
    {
        $this->phparia = $phparia;
        parent::__construct($this->playbacks, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * @param mixed $offset
     * @param Playback $value
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof Playback) {
            throw new \InvalidArgumentException("Value must be of type Playback");
        }
        parent::offsetSet($offset, $value);

        // Remove playbacks when they are done playing
        $value->oncePlaybackFinished(function (PlaybackFinished $playbackFinished) use ($value) {
            if ($playbackFinished->getPlayback()->getId() === $value->getId()) {
                $key = array_search($value, $this->getArrayCopy());
                if ($key !== false) {
                    $this->offsetUnset($key);
                }
            }
        });
    }

    /**
     * @param Playback $value
     */
    public function append($value)
    {
        if (!$value instanceof Playback) {
            throw new \InvalidArgumentException("Value must be of type Playback");
        }
        parent::append($value);

        // Remove playbacks when they are done playing
        $this->phparia->getWsClient()->once('PlaybackFinished',
            function (PlaybackFinished $playbackFinished) use ($value) {
                if ($playbackFinished->getPlayback()->getId() === $value->getId()) {
                    $key = array_search($value, $this->getArrayCopy());
                    if ($key !== false) {
                        $this->offsetUnset($key);
                    }
                }
            });
    }

    /**
     * Stop all the playbacks
     */
    public function stop()
    {
        foreach (array_reverse($this->getArrayCopy()) as $playback) {
            /* @var $playback Playback */
            try {
                $this->phparia->playbacks()->stopPlayback($playback->getId());
            } catch (\Exception $ignore) {
                // Don't throw exception if the playback does not exist
            }
        }
    }
}