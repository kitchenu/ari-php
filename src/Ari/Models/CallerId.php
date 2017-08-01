<?php

namespace Ari\Models;

class CallerId extends Model
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $number;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->name = $this->getResponseValue('name');
        $this->number = $this->getResponseValue('number');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}
