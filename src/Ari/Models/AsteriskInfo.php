<?php

namespace Ari\Models;

use Ari\Models\BuildInfo;
use Ari\Models\ConfigInfo;
use Ari\Models\StatusInfo;
use Ari\Models\SystemInfo;

class AsteriskInfo extends Model
{
    /**
     * @var BuildInfo Info about how Asterisk was built
     */
    protected $buildInfo;

    /**
     * @var ConfigInfo Info about Asterisk configuration
     */
    protected $configInfo;

    /**
     * @var StatusInfo Info about Asterisk status
     */
    protected $statusInfo;

    /**
     * @var SystemInfo Info about Asterisk
     */
    protected $systemInfo;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->buildInfo = $this->getResponseValue('build', BuildInfo::class);
        $this->configInfo = $this->getResponseValue('config', ConfigInfo::class);
        $this->statusInfo = $this->getResponseValue('status', StatusInfo::class);
        $this->systemInfo = $this->getResponseValue('system', SystemInfo::class);
    }

    public function getBuildInfo()
    {
        return $this->buildInfo;
    }

    public function getConfigInfo()
    {
        return $this->configInfo;
    }

    public function getStatusInfo()
    {
        return $this->statusInfo;
    }

    public function getSystemInfo()
    {
        return $this->systemInfo;
    }
}
