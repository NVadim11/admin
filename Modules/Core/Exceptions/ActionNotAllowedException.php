<?php

namespace Modules\Core\Exceptions;


use Throwable;

class ActionNotAllowedException extends \LogicException
{
    protected $message = 'У вас нет прав для совершения данного действия.';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: $this->message, $code, $previous);
    }
}