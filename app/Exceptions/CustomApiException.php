<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class CustomApiException extends Exception
{
    use ApiResponseTrait;
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse('You are not allowed to access this resource.',403);
        }

        return parent::render($request, $exception);
    }
}
