<?php


namespace Shop\Lib\Exceptions;


use Throwable;

class NotFoundException extends ExceptionHandler
{
    public function __construct($message = "Page not found", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}