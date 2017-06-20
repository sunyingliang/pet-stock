<?php

namespace AppBundle\Exception;

class InvalidParameterException extends PSException
{
    public function __construct($message, $code = 1000, $type = 0)
    {
        parent::__construct($message, $code, $type);
    }
}
