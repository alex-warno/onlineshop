<?php


namespace Shop\Lib\Exceptions;


use Throwable;

class ServerErrorException extends ExceptionHandler
{
    public function __construct($message = "Internal server error", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}