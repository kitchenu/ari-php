<?php

namespace Ari\Models;

class MissingParams extends Model
{
    /**
     * @var string Indicates the type of this message.
     */
    private $type;

    /**
     * @var array A list of the missing parameters
     */
    private $params;

    /**
     * @return string Indicates the type of this message.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array A list of the missing parameters
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->type = $this->getResponseValue('type');
        $this->params = $this->getResponseValue('params');
    }
}
