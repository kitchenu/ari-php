<?php

namespace Ari\Api;

use Ari\Model\LiveRecording;
use Ari\Model\StoredRecording;

/**
 * Recordings REST API
 */
class Recordings extends Api
{
    /**
     * List recordings that are complete.
     *
     * @return StoredRecording[]
     */
    public function listStored()
    {
        $response = $this->request('GET', 'recordings/stored');

        return $this->build($response, StoredRecording::class);
    }

    /**
     * Get a stored recording's details.
     *
     * @param string $recordingName
     * @return StoredRecording
     * @throws \Ari\Exception\NotFoundException
     */
    public function getStored($recordingName)
    {
        $response = $this->request('GET', "recordings/stored/$recordingName");

        return $this->build($response, StoredRecording::class);
    }

    /**
     * Delete a stored recording.
     *
     * @param string $recordingName
     * @return StoredRecording
     * @throws \Ari\Exception\NotFoundException
     */
    public function deleteStored($recordingName)
    {
        $this->request('DELETE', "recordings/stored/$recordingName");
    }

    /**
     * Copy a stored recording.
     *
     * @param string $recordingName
     * @param array $queryParams
     * @return StoredRecording
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function copyStored($recordingName, array $queryParams)
    {
        $params = array_merge([
            'destinationRecordingName' => null,
        ], $queryParams);

        $response = $this->request('POST', "recordings/stored/$recordingName/copy", $params);

        return $this->build($response, StoredRecording::class);
    }

    /**
     * Get live recording
     *
     * @param string $recordingName The name of the recording
     * @return LiveRecording
     * @throws NotFoundException
     */
    public function getLive($recordingName)
    {
        $response = $this->request('GET', "recordings/live/$recordingName");

        return $this->build($response, LiveRecording::class);
    }

    /**
     * Stop a live recording and discard it.
     *
     * @param string $recordingName
     * @throws \Ari\Exception\NotFoundException
     */
    public function cancel($recordingName)
    {
        $this->request('DELETE', "recordings/live/$recordingName");
    }

    /**
     * Stop a live recording and store it.
     *
     * @param string $recordingName The name of the recording
     * @throws \Ari\Exception\NotFoundException
     */
    public function stop($recordingName)
    {
        $this->request('POST', "recordings/live/$recordingName/stop");
    }

    /**
     * Pause a live recording. Pausing a recording suspends silence detection, which will be restarted
     * when the recording is unpaused. Paused time is not included in the accounting for maxDurationSeconds.
     *
     * @param string $recordingName
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function pause($recordingName)
    {
        $this->request('POST', "recordings/live/$recordingName/pause");
    }

    /**
     * Unause a live recording.
     *
     * @param string $recordingName
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function unpause($recordingName)
    {
        $this->request('DELETE', "recordings/live/$recordingName/pause");
    }

    /**
     * Mute a live recording. Muting a recording suspends silence detection, which will be restarted when the recording is unmuted.
     *
     * @param string $recordingName
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function mute($recordingName)
    {
        $this->request('POST', "recordings/live/$recordingName/mute");
    }

    /**
     * Unmute a live recording.
     *
     * @param string $recordingName The name of the recording
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\NotFoundException
     */
    public function unmute($recordingName)
    {
        $this->request('DELETE', "recordings/live/$recordingName/mute");
    }
}
