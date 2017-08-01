<?php

namespace Ari\Exception;

use Exception;

class ForbiddenException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage(), 403, $e->getPrevious());
    }
}
