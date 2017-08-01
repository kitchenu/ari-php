<?php

namespace Ari\Api;

use Ari\Models\AsteriskInfo;
use Ari\Models\LogChannel;
use Ari\Models\Module;
use Ari\Models\Variable;
use Ari\Models\ConfigTuple;

/**
 * Asterisk REST API
 */
class Asterisk extends Api
{
    /**
     * Retrieve a dynamic configuration object.
     *
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @return ConfigTuple[]
     * @throws \Ari\Exception\NotFoundException
     */
    public function getObject($configClass, $objectType, $id)
    {
        $response = $this->request('GET', "asterisk/config/dynamic/$configClass/$objectType/$id");

        return $this->build($response, ConfigTuple::class);
    }

    /**
     * Create or update a dynamic configuration object.
     *
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @return ConfigTuple[]
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\ForbiddenException
     * @throws \Ari\Exception\NotFoundException
     */
    public function updateObject($configClass, $objectType, $id, array $fields = [])
    {
        $params = [
            'fields' => $fields,
        ];

        $response = $this->request('PUT', "asterisk/config/dynamic/$configClass/$objectType/$id", $params);

        return $this->build($response, ConfigTuple::class);
    }

    /**
     * Create or update a dynamic configuration object.
     *
     * @param string $configClass
     * @param string $objectType
     * @param string $id
     * @throws \Ari\Exception\ForbiddenException
     * @throws \Ari\Exception\NotFoundException
     */
    public function deleteObject($configClass, $objectType, $id)
    {
        $this->request('DELETE', "asterisk/config/dynamic/$configClass/$objectType/$id");
    }

    /**
     * Gets Asterisk system information.
     *
     * @param array $queryParams
     * @return AsteriskInfo
     */
    public function getInfo(array $queryParams)
    {
        $params = array_merge([
            'only' => null,
        ], $queryParams);

        $response = $this->request('GET', 'asterisk/info', $params);

        return $this->build($response, AsteriskInfo::class);
    }

    /**
     * List Asterisk modules.
     *
     * @return Module[]
     */
    public function listModules()
    {
        $response = $this->request('GET', 'asterisk/modules');

        return $this->build($response, Module::class);
    }

    /**
     * Get Asterisk module information.
     *
     * @param string $moduleName
     * @return Module
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function getModule($moduleName)
    {
        $response = $this->request('GET', "asterisk/modules/$moduleName");

        return $this->build($response, Module::class);
    }

    /**
     * Load an Asterisk module.
     *
     * @param string $moduleName
     * @throws \Ari\Exception\ConflictException
     */
    public function loadModule($moduleName)
    {
        $this->request('POST', "asterisk/modules/$moduleName");
    }

    /**
     * Unload an Asterisk module.
     *
     * @param string $moduleName
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function unloadModule($moduleName)
    {
        $this->request('DELETE', "asterisk/modules/$moduleName");
    }

    /**
     * Reload an Asterisk module.
     *
     * @param string $moduleName
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function reloadModule($moduleName)
    {
        $this->request('PUT', "asterisk/modules/$moduleName");
    }

    /**
     * Gets Asterisk log channel information.
     *
     * @return LogChannel[]
     */
    public function listLogChannels()
    {
        $response = $this->request('GET', 'asterisk/logging');

        return $this->build($response, LogChannel::class);
    }

    /**
     * Adds a log channel.
     *
     * @param string $logChannelName
     * @array array  $queryParams
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\ConflictException
     */
    public function addLog($logChannelName, array $queryParams)
    {
        $params = array_merge([
            'configuration' => null,
        ], $queryParams);

        $this->request('POST', "asterisk/logging/$logChannelName", $params);
    }

    /**
     * Deletes a log channel.
     *
     * @param string $logChannelName
     * @throws \Ari\Exception\NotFoundException
     */
    public function deleteLog($logChannelName)
    {
        $this->request('DELETE', "asterisk/logging/$logChannelName");
    }

    /**
     * Rotates a log channel.
     *
     * @param string $logChannelName
     * @throws \Ari\Exception\NotFoundException
     */
    public function rotateLog($logChannelName)
    {
        $this->request('PUT', "asterisk/logging/$logChannelName/rotate");
    }

    /**
     * Get the value of a global variable.
     *
     * @param array $queryParams
     * @return Variable
     * @throws InvalidParameterException
     */
    public function getGlobalVar(array $queryParams)
    {
        $params = array_merge([
            'variable' => null
        ], $queryParams);

        $response = $this->request('GET', 'asterisk/variable', $params);

        return $this->build($response, Variable::class);
    }

    /**
     * Set the value of a global variable.
     *
     * @param array $queryParams
     * @throws InvalidParameterException
     */
    public function setGlobalVar(array $queryParams)
    {
        $params = array_merge([
            'variable' => null,
            'value' => null,
        ], $queryParams);

        $this->request('POST', 'asterisk/variable', $params);
    }
}
