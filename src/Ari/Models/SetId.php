<?php

namespace Ari\Models;

class SetId extends Model
{
    /**
     * @var string Effective user id.
     */
    protected $user;

    /**
     * @var string Effective group id.
     */
    protected $group;

    /**
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response);

        $this->user = $this->getResponseValue('user');
        $this->group = $this->getResponseValue('group');
    }

    /**
     * @return string Effective user id.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string Effective group id.
     */
    public function getGroup()
    {
        return $this->group;
    }
}
