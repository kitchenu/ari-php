<?php

namespace Ari\Api;

use Ari\Models\Playback;

/**
 * Playbacks REST API
 */
class Playbacks extends Api
{
    /**
     * Get a playback's details.
     *
     * @param string $playbackId Playback's id
     * @return Playback
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($playbackId)
    {
        $response = $this->request('GET', "playbacks/$playbackId");

        return $this->build($response, Playback::class);
    }

    /**
     * Stop a playback.
     *
     * @param string $playbackId Playback's id
     * @throws \Ari\Exception\NotFoundException
     */
    public function stop($playbackId)
    {
        $this->request('DELETE', "playbacks/$playbackId");
    }

    /**
     * Control a playback.
     *
     * @param string $playbackId
     * @param array  $queryParams
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function control($playbackId, array $queryParams)
    {
        $params = array_merge([
            'operation' => null,
        ], $queryParams);

        $this->request('POST', "playbacks/$playbackId/control", $params);
    }
}
