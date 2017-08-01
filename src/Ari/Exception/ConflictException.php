<?php

namespace Ari\Exception;

use Exception;

class ConflictException extends Exception
{
    public function __construct(\Exception $e)
    {
        parent::__construct($e->getMessage(), 409, $e->getPrevious());
    }
}
