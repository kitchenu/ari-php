<?php

namespace Ari\Api;

/**
 * Events REST API
 */
class Events extends Api
{
    /**
     * Generate a user event.
     *
     * @param string $eventName
     * @param array  $queryParams
     * @param array  $variables
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function userEvent($eventName, array $queryParams, array $variables = [])
    {
        $params = array_merge([
            'application' => null,
            'source' => null,
        ], $queryParams);
        $params['variables'] = $variables;

        $this->request('POST', "events/user/$eventName", $params);
    }
}
