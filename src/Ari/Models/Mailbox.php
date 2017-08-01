<?php

namespace Ari\Models;

class Mailbox extends Model
{
    /**
     * @var string Name of the mailbox.
     */
    private $name;

    /**
     * @var int Count of new messages in the mailbox.
     */
    private $newMessages;

    /**
     * @var int Count of old messages in the mailbox.
     */
    private $oldMessages;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->name = $this->getResponseValue('name');
        $this->newMessages = $this->getResponseValue('new_messages');
        $this->oldMessages = $this->getResponseValue('old_messages');
    }

    /**
     * @return string Name of the mailbox.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int Count of new messages in the mailbox.
     */
    public function getNewMessages()
    {
        return $this->newMessages;
    }

    /**
     * @return int Count of old messages in the mailbox.
     */
    public function getOldMessages()
    {
        return $this->oldMessages;
    }
}
