<?php

namespace Ari\Models;

class ConfigTuple extends Model
{
    /**
     * @var string Default language for media playback.
     */
    protected $attribute;

    /**
     * @var int (optional) - Maximum number of simultaneous channels.
     */
    protected $value;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->attribute = $this->getResponseValue('attribute');
        $this->value = $this->getResponseValue('value');
    }

    /**
     * @return string Default language for media playback.
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return int (optional) - Maximum number of simultaneous channels.
     */
    public function getValue()
    {
        return $this->value;
    }
}
