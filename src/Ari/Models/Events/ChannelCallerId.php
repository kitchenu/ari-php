<?php

namespace Ari\Models\Events;

/**
 * Event of channel changed Caller ID
 */
class ChannelCallerId extends ChannelEvent
{
    /**
     * @var int The integer representation of the Caller Presentation value.
     */
    protected $callerPresentation;

    /**
     * @var string The text representation of the Caller Presentation value.
     */
    protected $callerPresentationTxt;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->callerPresentation = $this->getResponseValue('caller_presentation');
        $this->callerPresentationTxt = $this->getResponseValue('caller_presentation_txt');
    }
 
    /**
     * @return int The integer representation of the Caller Presentation value.
     */
    public function getCallerPresentation()
    {
        return $this->callerPresentation;
    }

    /**
     * @return string The text representation of the Caller Presentation value.
     */
    public function getCallerPresentationTxt()
    {
        return $this->callerPresentationTxt;
    }
}
