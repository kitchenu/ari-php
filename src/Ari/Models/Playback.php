<?php

namespace Ari\Models;

class Playback extends Model
{
    /**
     * @var string ID for this playback operation
     */
    protected $id;

    /**
     * @var string (optional) - For media types that support multiple languages, the language requested for playback.
     */
    protected $language;

    /**
     * @var string URI for the media to play back.
     */
    protected $mediaUri;

    /**
     * @var string Current state of the playback operation.
     */
    protected $state;

    /**
     * @var string URI for the channel or bridge to play the media on
     */
    protected $targetUri;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->id = $this->getResponseValue('id');
        $this->language = $this->getResponseValue('language');
        $this->mediaUri = $this->getResponseValue('media_uri');
        $this->state = $this->getResponseValue('state');
        $this->targetUri = $this->getResponseValue('target_uri');
    }

    /**
     * @return string ID for this playback operation
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string (optional) - For media types that support multiple languages, the language requested for playback.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string URI for the media to play back.
     */
    public function getMediaUri()
    {
        return $this->mediaUri;
    }

    /**
     * @return string Current state of the playback operation.
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string URI for the channel or bridge to play the media on
     */
    public function getTargetUri()
    {
        return $this->targetUri;
    }
}
