<?php

namespace Ari\Exception;

use Exception;

class MissingParameterException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage(), 400, $e->getPrevious());
    }
}
