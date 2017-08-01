<?php

namespace Ari\Models\Events;

use Ari\Models\Model;

/**
 * Base type for errors and events
 */
class Message extends Model
{
    /**
     * @var string Indicates the type of this message.
     */
    protected $type;

    /**
     * @param string $response The raw json response message data from ARI
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->type = $this->getResponseValue('type');
    }

    public function getType()
    {
        return $this->type;
    }
}
