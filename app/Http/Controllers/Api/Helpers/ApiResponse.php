<?php


namespace App\Http\Controllers\Api\Helpers;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    protected $statusCode = FoundationResponse::HTTP_OK;
    protected $data = [];
    protected $errorCode = 0;
    protected $errorMessage = "ok";
    protected $headers = [];

    public function setStatusCode($statusCode): ApiResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setErrorCode($errorCode): ApiResponse
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function setErrorMessage($errorMessage): ApiResponse
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function setData($data): ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    public function response(): JsonResponse
    {
        $body = [
            "err_code" => $this->errorCode,
            "err_msg" => $this->errorMessage
        ];
        if ($this->errorCode == 0) {
//            $body["data"] = $this->data;
            $body = array_merge($body, $this->data);
        }
        return Response::json($body, $this->statusCode, $this->headers);
    }

    public function success($data = []): JsonResponse
    {
        return $this->setStatusCode(FoundationResponse::HTTP_OK)
            ->setErrorCode(0)
            ->setErrorMessage('ok')
            ->setData($data)
            ->response();
    }

    public function failed($errorCode, $errorMessage): JsonResponse
    {
        return $this->setStatusCode(FoundationResponse::HTTP_OK)
            ->setErrorCode($errorCode)
            ->setErrorMessage($errorMessage)
            ->response();
    }

    public function missParameters ($errorMessage = "Miss parameters!"): JsonResponse
    {
        return $this->failed(Errors::BAD_REQUEST, $errorMessage);
    }

    public function notFound($errorCode = Errors::NOT_FOUND, $errorMessage = "Not found!"): JsonResponse
    {
        return $this->failed($errorCode, $errorMessage);
    }

    public function internalError($errorCode = Errors::INTERNAL_SERVER_ERROR, $errorMessage = "Internal error!"): JsonResponse
    {
        return $this->failed($errorCode, $errorMessage);
    }

    public function unauthorized($errorCode = Errors::UNAUTHORIZED, $errorMessage = "Unauthorized!"): JsonResponse
    {
        return $this->failed($errorCode, $errorMessage);
    }

    public function forbidden($errorCode = Errors::FORBIDDEN, $errorMessage = "Permission denied!"): JsonResponse
    {
        return $this->failed($errorCode, $errorMessage);
    }

    public function conflict($errorCode = Errors::CONFLICT, $errorMessage = "Conflict!"): JsonResponse
    {
        return $this->failed($errorCode, $errorMessage);
    }

}
