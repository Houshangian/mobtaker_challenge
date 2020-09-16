<?php

namespace App\Exceptions;

use App\Models\Lesson;
use App\Traits\ResponderTrait;
use Couchbase\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    use ResponderTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {


    }

    public function render($request,$e)
    {

        if ($e instanceof ValidationException) {
            return $this->errorResponse($e->errors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof ModelNotFoundException) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof QueryException) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($e instanceof RouteNotFoundException) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof AuthenticationException) {
           return $this->errorResponse($e->getMessage(),Response::HTTP_UNAUTHORIZED);
        }
        if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(),Response::HTTP_UNAUTHORIZED);
        }
        return parent::render($request, $e);
    }
}
