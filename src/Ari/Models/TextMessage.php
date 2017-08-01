<?php

namespace Ari\Models;

class TextMessage extends Model
{
    /**
     * @var string The text of the message.
     */
    protected $body;

    /**
     * @var string A technology specific URI specifying the source of the message. For sip and pjsip technologies, any SIP URI can be specified. For xmpp, the URI must correspond to the client connection being used to send the message.
     */
    protected $from;

    /**
     * @var string A technology specific URI specifying the destination of the message. Valid technologies include sip, pjsip, and xmp. The destination of a message should be an endpoint.
     */
    protected $to;

    /**
     * @var array (optional) - Technology specific key/value pairs associated with the message.
     */
    protected $variables;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->body = $this->getResponseValue('body');
        $this->from = $this->getResponseValue('from');
        $this->to = $this->getResponseValue('to');
        $this->variables = $this->getResponseValue('variables');
    }

    /**
     * @return string The text of the message.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string A technology specific URI specifying the source of the message. For sip and pjsip technologies, any SIP URI can be specified. For xmpp, the URI must correspond to the client connection being used to send the message.
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string A technology specific URI specifying the destination of the message. Valid technologies include sip, pjsip, and xmp. The destination of a message should be an endpoint.
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return TextMessageVariable[] (optional) - Technology specific key/value pairs associated with the message.
     */
    public function getVariables()
    {
        return $this->variables;
    }
}
