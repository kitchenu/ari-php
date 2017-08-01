<?php

namespace Ari\Models;

class StoredRecording extends Model
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->format = $this->getResponseValue('format');
        $this->name = $this->getResponseValue('name');
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
