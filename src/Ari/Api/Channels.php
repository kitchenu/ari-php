<?php

namespace Ari\Api;

use Ari\Models\Channel;
use Ari\Models\Playback;
use Ari\Models\LiveRecording;
use Ari\Model\Variable;

/**
 * Channels REST API
 */
class Channels extends Api
{
    /**
     * List all active channels in Asterisk.
     *
     * @return Channel[]
     */
    public function getList()
    {
        $response = $this->request('GET', 'channels');

        return $this->build($response, Channel::class);
    }

    /**
     * Create a new channel (originate). The new channel is created immediately and a snapshot of it
     * returned. If a Stasis application is provided it will be automatically subscribed to the originated
     * channel for further events and updates.
     *
     * @param array $queryParams
     * @param array $variables
     * @return Channel
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\ServerException
     */
    public function originate(array $queryParams, array $variables = []) 
    {
        $params = array_merge([
            'endpoint' => null,
            'extension' => null,
            'context' => null,
            'priority' => null,
            'label' => null,
            'app' => null,
            'appArgs' => null,
            'callerId' => null,
            'timeout' => null,
            'channelId' => null,
            'otherChannelId' => null,
            'originator' => null,
            'formats' => null,
        ], $queryParams);
        $params['variables'] = $variables;

        $response = $this->request('POST', 'channels', $params);

        return $this->build($response, Channel::class);
    }

    /**
     * Channel details.
     *
     * @param string $channelId
     * @return Channel
     * @throws \Ari\Exception\NotFoundException
     */
    public function get($channelId)
    {
        $response = $this->request('GET', "channels/$channelId");

        return $this->build($response, Channel::class);
    }

    /**
     * Create a new channel (originate with id). The new channel is created immediately and a snapshot of it returned.
     * If a Stasis application is provided it will be automatically subscribed to the originated channel for further events and updates.
     *
     * @param string $channelId
     * @param array  $queryParams
     * @param array  $variables
     * @return Channel
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\ServerException
     */
    public function originateWithId($channelId, array $queryParams, array $variables = []) 
    {
        $params = array_merge([
            'endpoint' => null,
            'extension' => null,
            'context' => null,
            'priority' => null,
            'label' => null,
            'app' => null,
            'appArgs' => null,
            'callerId' => null,
            'timeout' => null,
            'otherChannelId' => null,
            'originator' => null,
            'formats' => null,
        ], $queryParams);
        $params['variables'] = $variables;

        $response = $this->request('POST', "channels/$channelId", $params);

        return $this->build($response, Channel::class);
    }

    /**
     * Delete (i.e. hangup) a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function hangup($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('DELETE', "channels/{$channelId}");
    }

    /**
     * Exit application; continue execution in the dialplan.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function continueDialplan($channelId, array $queryParams = [])
    {
        $channelId = $this->channelId($channelId);
 
        $params = array_merge([
            'context' => null,
            'extension' => null,
            'priority' => null,
            'label' => null,
        ], $queryParams);
        
        $this->request('POST', "channels/$channelId/continue", $params);
    }

    /**
     * Redirect the channel to a different location.
     *
     * @param string|Channel $channelId
     * @param string $queryParams
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function redirect($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'endpont' => null
        ], $queryParams);

        $this->request('POST', "channels/$channelId/redirect", $params);
    }

    /**
     * Answer a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function answer($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('POST', "channels/$channelId/answer");
    }

    /**
     * Indicate ringing to a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function ring($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('POST', "channels/$channelId/ring");
    }

    /**
     * Stop ringing indication on a channel if locally generated.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function ringStop($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('DELETE', "channels/$channelId/ring");
    }

    /**
     * Send provided DTMF to a given channel.
     *
     * @param string|Channel $channelId
     * @param array $queryParams
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function sendDTMF($channelId, array $queryParams = [])
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'dtmf' => null,
            'before' => null,
            'between' => null,
            'duration' => null,
            'after' => null,
        ], $queryParams);

        $this->request('POST', "channels/$channelId/dtmf", $params);
    }

    /**
     * Mute a channel.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function mute($channelId, array $queryParams = [])
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'direction' => null,
        ], $queryParams);

        $this->request('POST', "channels/$channelId/mute", $params);
    }

    /**
     * Unmute a channel.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function unmute($channelId, array $queryParams = [])
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'direction' => null,
        ], $queryParams);

        $this->request('DELETE', "channels/$channelId/mute", $params);
    }

    /**
     * Hold a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function hold($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('POST', "channels/$channelId/hold");
    }

    /**
     * Remove a channel from hold.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function unhold($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('DELETE', "channels/$channelId/hold");
    }

    /**
     * Play music on hold to a channel.
     * Using media operations such as /play on a channel playing MOH in this manner will suspend MOH without resuming automatically.
     * If continuing music on hold is desired, the stasis application must reinitiate music on hold.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function startMoh($channelId, array $queryParams = [])
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'mohClass' => null,
        ], $queryParams);

        $this->request('POST', "channels/$channelId/moh", $params);
    }

    /**
     * Stop playing music on hold to a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function stopMoh($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('POST', "channels/$channelId/moh");
    }

    /**
     * Play silence to a channel. 
     * Using media operations such as /play on a channel playing silence in this manner will suspend silence without resuming automatically.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function startSilence($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('POST', "channels/$channelId/silence");
    }

    /**
     * Stop playing silence to a channel.
     *
     * @param string|Channel $channelId
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function stopSilence($channelId)
    {
        $channelId = $this->channelId($channelId);

        $this->request('DELETE', "channels/$channelId/silence");
    }

    /**
     * Start playback of media. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media (pause, rewind, fast forward, etc.)
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @retrun Playback
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function play($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'media' => null,
            'lang' => null,
            'offsetms' => null,
            'skipms' => null,
            'playbackId' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/play", $params);

        return $this->build($response, Playback::class);
    }

    /**
     * Start playback of media and specify the playbackId. The media URI may be any of a number of URI's.
     * Currently sound:, recording:, number:, digits:, characters:, and tone: URI's are supported.
     * This operation creates a playback resource that can be used to control the playback of media (pause, rewind, fast forward, etc.)
     *
     * @param string|Channel $channelId
     * @param string $playbackId
     * @param array  $queryParams
     * @retrun Playback
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function playWithId($channelId, $playbackId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'media' => null,
            'lang' => null,
            'offsetms' => null,
            'skipms' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/play/$playbackId", $params);

        return $this->build($response, Playback::class);
    }

    /**
     * Start a recording. Record audio from a channel. Note that this will not capture audio sent to the channel.
     * The bridge itself has a record feature if that's what you want.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @retrun LiveRecording
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\UnprocessableEntityException
     */
    public function record($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'name' => null,
            'format' => null,
            'maxDurationSeconds' => null,
            'maxSilenceSeconds' => null,
            'ifExists' => null,
            'beep' => null,
            'terminateOn' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/record", $params);

        return $this->build($response, LiveRecording::class);
    }

    /**
     * Get the value of a channel variable or function.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @return Variable
     * @throws \Ari\Exception\ConflictException
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function getChannelVar($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'variable' => null,
        ], $queryParams);

        $response = $this->request('GET', "channels/$channelId/variable", $params);

        return $this->build($response, Variable::class);
    }

    /**
     * Set the value of a channel variable or function.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     * @throws \Ari\Exception\ConflictException
     */
    public function setChannelVar($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'variable' => null,
            'value' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/variable", $params);

        return $this->build($response, Variable::class);
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string|Channel $channelId
     * @param array  $queryParams
     * @return Channel
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function snoopChannel($channelId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'spy' => null,
            'whisper' => null,
            'app' => null,
            'appArgs' => null,
            'snoopId' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/snoop", $params);

        return $this->build($response, Channel::class);
    }

    /**
     * Start snooping. Snoop (spy/whisper) on a specific channel.
     *
     * @param string|Channel $channelId
     * @param string $snoopId
     * @param array  $queryParams
     * @return Channel
     * @throws \Ari\Exception\InvalidParameterException
     * @throws \Ari\Exception\NotFoundException
     */
    public function snoopChannelWithId($channelId, $snoopId, array $queryParams)
    {
        $channelId = $this->channelId($channelId);

        $params = array_merge([
            'spy' => null,
            'whisper' => null,
            'app' => null,
            'appArgs' => null,
        ], $queryParams);

        $response = $this->request('POST', "channels/$channelId/snoop/$snoopId", $params);

        return $this->build($response, Channel::class);
    }

    /**
     * @param Channel|string $channelId
     * @return string
     */
    protected function channelId($channelId)
    {
        return $channelId instanceof Channel ? $channelId->getId() : $channelId;
    }
}
