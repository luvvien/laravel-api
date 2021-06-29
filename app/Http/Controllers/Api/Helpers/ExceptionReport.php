<?php


namespace App\Http\Controllers\Api\Helpers;


use App\Exceptions\CustomException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
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
        AuthenticationException::class => [Errors::UNAUTHORIZED, 'Unauthorized'],
        ModelNotFoundException::class => [Errors::NOT_FOUND, 'Model not found'],
        AuthorizationException::class => [Errors::FORBIDDEN, 'Permission denied'],
        ValidationException::class => [],
        CustomException::class => [],
        UnauthorizedHttpException::class => [Errors::UNAUTHORIZED, 'Unauthorized'],
        NotFoundHttpException::class => [Errors::NOT_FOUND, 'Resource not found'],
        MethodNotAllowedHttpException::class => [Errors::METHOD_NOT_ALLOWED, 'Method not allowed'],
//        QueryException::class => [Errors::BAD_REQUEST, 'Parameters error', 400]
    ];

    public function register($className, callable $callback)
    {
        $this->doReport[$className] = $callback;
    }

    public function shouldReturn (): bool
    {
        foreach (array_keys($this->doReport) as $report) {
            if ($this->exception instanceof $report) {
                $this->report = $report;
                return true;
            }
        }

        return false;
    }

    public static function make(Throwable $exception): ExceptionReport
    {
        return new static($exception);
    }

    public function report (): JsonResponse
    {
        if ($this->exception instanceof ValidationException) {
            $error = Arr::first($this->exception->errors());
            return $this->failed(Errors::BAD_REQUEST, Arr::first($error));
        }
        if ($this->exception instanceof CustomException) {
            return $this->failed($this->exception->getCode(), $this->exception->getMessage());
        }
        $error = $this->doReport[$this->report];
        return $this->failed($error[0], $error[1]);
    }

    public function prodReport (): JsonResponse
    {
        return $this->internalError();
    }

}
