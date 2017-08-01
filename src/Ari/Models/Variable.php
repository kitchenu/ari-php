<?php

namespace Ari\Model;

class Variable extends Model
{
    /**
     * @var string The value of the variable requested
     */
    protected $value;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->value = $this->getResponseValue('value');
    }

    /**
     * @return string The value of the variable requested
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->value);
    }

}
