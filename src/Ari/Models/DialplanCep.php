<?php

namespace Ari\Models;

class DialplanCep extends Model
{
    /**
     * @var string Context in the dialplan
     */
    protected $context;

    /**
     * @var string Extension in the dialplan
     */
    protected $exten;

    /**
     * @var int Priority in the dialplan
     */
    protected $priority;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->context = $this->getResponseValue('context');
        $this->exten = $this->getResponseValue('exten');
        $this->priority = $this->getResponseValue('priority');
    }

    /**
     * @return string Context in the dialplan
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string Extension in the dialplan
     */
    public function getExten()
    {
        return $this->exten;
    }

    /**
     * @return int Priority in the dialplan
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
