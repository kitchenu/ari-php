<?php

namespace Ari\Models\Events;

use Ari\Models\ContactInfo;
use Ari\Models\Endpoint;

/**
 * Event of the state of a contact on an endpoint has changed
 */
class ContactStatusChange extends Event
{
    /**
     * @var int (optional) - Integer representation of the cause of the hangup.
     */
    protected $contactInfo;

    /**
     * @var boolean (optional) - Whether the hangup request was a soft hangup request.
     */
    protected $endpoint;

    /**
     * @param AriClient $client
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->contactInfo = $this->getResponseValue('contact_info', ContactInfo::class);
        $this->endpoint = $this->getResponseValue('endpoint', Endpoint::class);
    }

    /**
     * @return int
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * @return boolean
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }
}
