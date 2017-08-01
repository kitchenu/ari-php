<?php

namespace Ari\Models;

use Ari\Models\FormatLangPair;

class Sound extends Model
{
    /**
     * @var FormatLangPair[] The formats and languages in which this sound is available.
     */
    protected $formats;

    /**
     * @var string Sound's identifier.
     */
    protected $id;

    /**
     * @var string (optional) - Text description of the sound, usually the words spoken.
     */
    protected $text;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->formats = $this->getResponseValue('formats', FormatLangPair::class);
        $this->id = $this->getResponseValue('id');
        $this->text = $this->getResponseValue('text');
    }

    /**
     * @return string The formats and languages in which this sound is available.
     */
    public function getFormats()
    {
        return $this->formats;
    }

    /**
     * @return string Sound's identifier.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string (optional) - Text description of the sound, usually the words spoken.
     */
    public function getText()
    {
        return $this->text;
    }
}
