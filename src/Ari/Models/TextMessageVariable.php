<?php

namespace Ari\Models;

class TextMessageVariable extends Model
{
    /**
     * @var string A unique key identifying the variable.
     */
    private $key;

    /**
     * @var string The value of the variable.
     */
    private $value;

    /**
     * @return string A unique key identifying the variable.
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string The value of the variable.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->key = $this->getResponseValue('key');
        $this->value = $this->getResponseValue('value');
    }

}
