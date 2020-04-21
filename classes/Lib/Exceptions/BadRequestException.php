<?php


namespace Shop\Lib\Exceptions;


use Throwable;

class BadRequestException extends ExceptionHandler
{
    public function __construct($message = "Bad request", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}