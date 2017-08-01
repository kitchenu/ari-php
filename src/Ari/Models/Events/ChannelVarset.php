<?php

namespace Ari\Models\Events;
/**
 * Event of Channel variable changed
 */
class ChannelVarset extends ChannelEvent
{
    /**
     * @var string The new value of the variable.
     */
    protected $value;

    /**
     * @var string The variable that changed.
     */
    protected $variable;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->value = $this->getResponseValue('value');
        $this->variable = $this->getResponseValue('variable');
    }

    /**
     * @return string The new value of the variable.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string The variable that changed.
     */
    public function getVariable()
    {
        return $this->variable;
    }
}
