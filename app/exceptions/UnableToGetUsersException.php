<?php

namespace SmileTrunk\exceptions;

use Exception;

class UnableToGetUsersException extends Exception
{
    protected $message = 'Unable to get users';
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct($this->message, 500, $previous);
    }
}