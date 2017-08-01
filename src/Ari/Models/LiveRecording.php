<?php

namespace Ari\Models;

class LiveRecording extends Model implements IdentifiableModelInterface
{
    /**
     * @var string (optional) - Cause for recording failure if failed
     */
    protected $cause;

    /**
     * @var int (optional) - Duration in seconds of the recording
     */
    protected $duration;

    /**
     * @var string Recording format (wav, gsm, etc.)
     */
    protected $format;

    /**
     * @var string Base name for the recording
     */
    protected $name;

    /**
     * @var int (optional) - Duration of silence, in seconds, detected in the recording. This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    protected $silenceDuration;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var int (optional) - Duration of talking, in seconds, detected in the recording. This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    protected $talkingDuration;

    /**
     * @var string URI for the channel or bridge being recorded
     */
    protected $targetUri;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->cause = $this->getResponseValue('cause');
        $this->duration = $this->getResponseValue('duration');
        $this->format = $this->getResponseValue('format');
        $this->name = $this->getResponseValue('name');
        $this->silenceDuration = $this->getResponseValue('silence_duration');
        $this->state = $this->getResponseValue('state');
        $this->talkingDuration = $this->getResponseValue('talking_duration');
        $this->targetUri = $this->getResponseValue('target_uri');
    }

    /**
     * @return string (optional) - Cause for recording failure if failed
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * @return int (optional) - Duration in seconds of the recording
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string Recording format (wav, gsm, etc.)
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string Base name for the recording
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int (optional) - Duration of silence, in seconds, detected in the recording. This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    public function getSilenceDuration()
    {
        return $this->silenceDuration;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return int (optional) - Duration of talking, in seconds, detected in the recording. This is only available if the recording was initiated with a non-zero maxSilenceSeconds.
     */
    public function getTalkingDuration()
    {
        return $this->talkingDuration;
    }

    /**
     * @return string URI for the channel or bridge being recorded
     */
    public function getTargetUri()
    {
        return $this->targetUri;
    }

    public function getIdentifier()
    {
        return $this->name;
    }
}
