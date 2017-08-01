<?php

namespace Ari\Api;

use Ari\Models\Bridge;
use Ari\Models\LiveRecording;
use Ari\Models\Playback;

/**
 * Bridges REST API
 */
class Bridges extends Api
{
    /**
     * List all active bridges in Asterisk.
     *
     * @return Bridge[]
     */
    public function getList()
    {
        $response = $this->request('GET', 'bridges');

        return $this->build($response, Bridge::class);
    }

    /**
     * Create a new bridge. This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param array $queryParams
     * @return Bridge
     */
    public function create(array $queryParams)
    {
        $params = array_merge([
            'type' => null,
            'bridgeId' => null,
            'name' => null,
        ], $queryParams);

        $response = $this->request('POST', 'bridges', $params);

        return $this->build($response, Bridge::class);
    }

    /**
     * Create a new bridge or updates an existing one. This bridge persists until it has been shut down, or Asterisk has been shut down.
     *
     * @param array $queryParams
     * @return Bridge
     */
    public function createWithId($bridgeId, array $queryParams)
    {
        $params = array_merge([
            'type' => null,
            'name' => null,
        ], $queryParams);

        $response = $this->request('POST', "bridges/$bridgeId", $params);

        return $this->build($response, Bridge::class);
    }
 
    /**
     * Get bridge details.
     *
     * @param string $bridgeId
     * @return Bridge
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($bridgeId)
    {
        $response = $this->request('GET', "bridges/$bridgeId");

        return $this->build($response, Bridge::class);
    }

    /**
     * Shut down a bridge. If any channels are in this bridge, they will be removed and resume whatever they were doing beforehand.
     *
     * @param string|Bridge $bridgeId
     * @throws \Ari\Exception\NotFoundException
     */
    public function destroy($bridgeId)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $this->request('DELETE', "bridges/$bridgeId");
    }

    /**
     * Add a channel to a bridge.
     *
     * @param string|Bridge $bridgeId
     * @param array  $queryParams
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function addChannel($bridgeId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'channel' => null,
            'role' => null,
        ], $queryParams);

        $this->request('POST', "bridges/$bridgeId/addChannel", $params);
    }

    /**
     * Remove a channel from a bridge.
     *
     * @param string|Bridge $bridgeId
     * @param array  $queryParams
     * @throwe InvalidParameterException
     * @throws NotFoundException
     * @throws ConflictException
     * @throws UnprocessableEntityException
     */
    public function removeChannel($bridgeId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'channel' => null,
        ], $queryParams);

        $this->request('DELETE', "bridges/$bridgeId/removeChannel", $params);
    }

    /**
     * Set a channel as the video source in a multi-party mixing bridge. This operation has no effect on bridges with two or fewer participants.
     *
     * @param string|Bridge $bridgeId
     * @param string $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function setVideoSource($bridgeId, $channelId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'bridgeId' => null,
            'channelId' => null, 
        ], $queryParams);

        $this->request('POST', "bridges/$bridgeId/videoSource/$channelId", $params);
    }

    /**
     * Removes any explicit video source in a multi-party mixing bridge. This operation has no effect on bridges with two or fewer participants.
     * When no explicit video source is set, talk detection will be used to determine the active video stream.
     *
     * @param string|Bridge $bridgeId
     * @throws \Ari\Exception\NotFoundException
     */
    public function clearVideoSource($bridgeId)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $this->request('DELETE', "bridges/$bridgeId/videoSource");
    }

    /**
     * Play music on hold to a bridge or change the MOH class that is playing.
     *
     * @param string|Bridge $bridgeId
     * @param array $queryParams
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function startMoh($bridgeId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'mohClass' => null, 
        ], $queryParams);

        $this->request('POST', "bridges/$bridgeId/moh", $params);
    }

    /**
     * Stop playing music on hold to a bridge. This will only stop music on hold being played via POST bridges/{bridgeId}/moh.
     *
     * @param string|Bridge $bridgeId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function stopMoh($bridgeId)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $this->request('DELETE', "bridges/$bridgeId/moh");
    }

    /**
     * Start playback of media on a bridge. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media (pause, rewind, fast forward, etc.)
     *
     * @param string|Bridge $bridgeId
     * @param array  $queryParams
     * @return Playback
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function play($bridgeId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'media' => null,
            'lang' => null,
            'offsetms' => null,
            'skipms' => null,
            'playbackId' => null,
        ], $queryParams);

        $response = $this->request('POST', "bridges/$bridgeId/play", $params);

        return $this->build($response, Playback::class);
    }

    /**
     * Start playback of media on a bridge. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media (pause, rewind, fast forward, etc.)
     *
     * @param string|Bridge $bridgeId
     * @param string $playbackId
     * @param array  $queryParams
     * @return Playback
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function playWithId($bridgeId, $playbackId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);

        $params = array_merge([
            'media' => null,
            'lang' => null,
            'offsetms' => null,
            'skipms' => null,
        ], $queryParams);

        $response = $this->request('POST', "bridges/$bridgeId/play/$playbackId", $params);

        return $this->build($response, Playback::class);
    }

    /**
     * Start a recording. This records the mixed audio from all channels participating in this bridge.
     *
     * @param string|Bridge $bridgeId
     * @param array  $queryParams
     * @return LiveRecording
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function record($bridgeId, array $queryParams)
    {
        $bridgeId = $this->bridgeId($bridgeId);
        
        $params = array_merge([
            'name' => null,
            'format' => null,
            'maxDurationSeconds' => null,
            'maxSilenceSeconds' => null,
            'ifExists' => null,
            'beep' => null,
            'terminateOn' => null,
        ], $queryParams);

        $this->request('POST', "bridges/$bridgeId/record", $params);

        return $this->build($response, LiveRecording::class);
    }

    /**
     * @param Bridge|string $bridgeId
     * @return string
     */
    protected function bridgeId($bridgeId)
    {
        return $bridgeId instanceof Bridge ? $bridgeId->getId() : $bridgeId;
    }
}
