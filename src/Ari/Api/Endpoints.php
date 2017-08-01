<?php

namespace Ari\Api;

use Ari\Models\Endpoint;

class Endpoints extends Api
{
    /**
     * List all endpoints.
     *
     * @return Endpoint[]
     */
    public function getList()
    {
        $response = $this->request('GET', 'endpoints');

        return $this->build($response, Endpoint::class);
    }

    /**
     * Send a message to some technology URI or endpoint.
     *
     * @param array $queryParams
     * @param array $variables
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function sendMessage(array $queryParams, array $variables = [])
    {
        $params = array_merge([
            'to' => null,
            'from' => null,
            'body' => null,
        ], $queryParams);
        $params['variables'] = $variables;

        $this->request('PUT', 'endpoints/sendMessage', $params);
    }

    /**
     * List available endoints for a given endpoint technology.
     *
     * @param string $tech
     * @return Endpoint[]
     * @throws \Ari\Exception\InvalidParameterException 
     * @throws \Ari\Exception\NotFoundException
     */
    public function listByTech($tech)
    {
        $response = $this->request('GET', "endpoints/$tech");

        return $this->build($response, Endpoint::class);
    }

    /**
     * Details for an endpoint.
     *
     * @param string $tech Technology of the endpoint
     * @param string $resource ID of the endpoint
     * @return Endpoint
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($tech, $resource)
    {
        $response = $this->request('GET', "endpoints/$tech/$resource");

        return $this->build($response, Endpoint::class);
    }

    /**
     * Send a message to some endpoint in a technology.
     *
     * @param string $tech
     * @param string $resource
     * @param array  $queryParams
     * @param array  $variables
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function sendMessageToEndpoint($tech, $resource, array $queryParams, array $variables = [])
    {
        $params = array_merge([
            'from' => null,
            'body' => null,
        ], $queryParams);
        $params['variables'] = $variables;

        $this->request('PUT', "endpoints/$tech/$resource/sendMessage", $params);
    }
}
