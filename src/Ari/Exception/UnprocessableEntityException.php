<?php

namespace Ari\Exception;

use Exception;

class UnprocessableEntityException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct($e->getMessage(), 422, $e->getPrevious());
    }
}
