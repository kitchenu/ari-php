<?php

namespace Ari\Api;

use Ari\Models\Sound;

/**
 * Sounds REST API
 */
class Sounds extends Api
{
    /**
     * List all sounds.
     *
     * @return Sound[]
     */
    public function getSounds(array $queryParams = [])
    {
        $params = array_merge([
            'lang' => null,
            'format' => null,
        ], $queryParams);

        $response = $this->request('GET', 'sounds', $params);

        return $this->build($response, Sound::class);
    }

    /**
     * Get a sound's details.
     *
     * @param string $soundId
     * @return Sound
     */
    public function getSound($soundId)
    {
        $response = $this->request('GET', "sounds/$soundId");

        return $this->build($response, Sound::class);
    }
}
