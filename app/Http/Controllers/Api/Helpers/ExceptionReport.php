<?php


namespace App\Http\Controllers\Api\Helpers;


use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class ExceptionReport
{
    use ApiResponse;

    protected $exception;

    protected $report;

    function __construct(Throwable $exception)
    {
        $this->exception = $exception;
    }

    public $doReport = [
        AuthenticationException::class => [Errors::UNAUTHORIZED, 'Unauthorized', 401],
        ModelNotFoundException::class => [Errors::NOT_FOUND, 'Model not found', 404],
        AuthorizationException::class => [Errors::FORBIDDEN, 'Permission denied', 403],
        ValidationException::class => [],
        UnauthorizedHttpException::class => [Errors::UNAUTHORIZED, 'Unauthorized', 422],
        NotFoundHttpException::class => [Errors::NOT_FOUND, 'Resource not found', 404],
        MethodNotAllowedHttpException::class => [Errors::METHOD_NOT_ALLOWED, 'Method not allowed', 405],
//        QueryException::class => [Errors::BAD_REQUEST, 'Parameters error', 400]
    ];

    public function register($className, callable $callback)
    {
        $this->doReport[$className] = $callback;
    }

    public function shouldReturn () {
        foreach (array_keys($this->doReport) as $report) {
            if ($this->exception instanceof $report) {
                $this->report = $report;
                return true;
            }
        }

        return false;
    }

    public static function make(Throwable $exception)
    {
        return new static($exception);
    }

    public function report () {
        if ($this->exception instanceof ValidationException) {
            $error = Arr::first($this->exception->errors());
            return $this->failed(Errors::BAD_REQUEST, Arr::first($error), 400);
        }
        $error = $this->doReport[$this->report];
        return $this->failed($error[0], $error[1], $error[2]);
    }

    public function prodReport () {
        return $this->internalError();
    }

}
