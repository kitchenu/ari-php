<?php

namespace Ari\Models\Events;

use Ari\Models\LiveRecording;

/**
 * Event showing failure of a recording operation
 */
class RecordingEvent extends Event implements IdentifiableEventInterface
{
    /**
     * @var LiveRecording Recording control object
     */
    protected $recording;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->recording = $this->getResponseValue('recording', LiveRecording::class);
    }

    /**
     * @return LiveRecording Recording control object
     */
    public function getRecording()
    {
        return $this->recording;
    }

    public function getEventId()
    {
        return $this->type . '_' . $this->recording->getName();
    }

}
