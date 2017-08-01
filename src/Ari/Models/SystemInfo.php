<?php

namespace Ari\Models;

class SystemInfo extends Model
{
    /**
     *
     * @var string
     */
    protected $entityId;

    /**
     * @var string Asterisk version.
     */
    protected $version;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->entityId = $this->getResponseValue('entity_id');
        $this->version = $this->getResponseValue('version');
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @return string Asterisk version.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
