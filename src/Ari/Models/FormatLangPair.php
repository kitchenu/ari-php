<?php

namespace Ari\Models;

class FormatLangPair extends Model
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $language;

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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->format = $this->getResponseValue('format');
        $this->language = $this->getResponseValue('language');
    }

}
