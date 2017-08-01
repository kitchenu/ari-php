<?php

namespace Ari\Exception;

use Exception;

class ServerException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage(), 500, $e->getPrevious());
    }
}
