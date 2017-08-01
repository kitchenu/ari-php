<?php

namespace Ari\Api;

use Ari\Models\Application;

class Applications extends Api
{
    /**
     * List all getApplications.
     *
     * @return Application[]
     * @throws \Ari\Exception\NotFoundException
     */
    public function getList()
    {
        $response = $this->request('GET', 'applications');

        return $this->build($response, Application::class);
    }

    /**
     * Get details of an application.
     *
     * @param string $applicationName
     * @return Application
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($applicationName)
    {
        $response = $this->request('GET',  "applications/$applicationName");

        return $this->build($response, Application::class);
    }

    /**
     * Subscribe an application to a event source. Returns the state of the application after the subscriptions have changed
     *
     * @param string $applicationName
     * @param array  $queryParams
     * @return Application
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function subscribe($applicationName, array $queryParams)
    {
        $params = array_merge([
            'eventSource' => null
        ], $queryParams);

        $response = $this->request('POST', "applications/$applicationName/subscription", $params);

        return $this->build($response, Application::class);
    }

    /**
     * Unsubscribe an application from an event source. Returns the state of the application after the subscriptions have changed
     *
     * @param string $applicationName
     * @param array  $queryParams
     * @return Application
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function unsubscribe($applicationName, array $queryParams)
    {
        $params = array_merge([
            'eventSource' => null
        ], $queryParams);

        $response = $this->request('POST', "applications/$applicationName/subscription", $params);
 
        return $this->build($response, Application::class);
    }
}
