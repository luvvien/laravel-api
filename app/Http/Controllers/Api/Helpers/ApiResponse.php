<?php


namespace App\Http\Controllers\Api\Helpers;


use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    protected $statusCode = FoundationResponse::HTTP_OK;
    protected $status = "success";
    protected $data = array();
    protected $errorCode = 0;
    protected $errorMessage = "Undefined error!";
    protected $headers = [];

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function response()
    {
        $body = [
            "status" => $this->status
        ];
        if ($this->status != "error") {
            $body["data"] = $this->data;
        } else {
            $body["err_code"] = $this->errorCode;
            $body["err_msg"] = $this->errorMessage;
        }
        return Response::json($body, $this->statusCode, $this->headers);
    }

    public function success($data = null, $status = "success")
    {
        return $this->setStatusCode(FoundationResponse::HTTP_OK)
            ->setStatus($status)
            ->setData($data)
            ->response();
    }

//    public function created($url = "", $status = "success")
//    {
//        $tmp = $this->setStatusCode(FoundationResponse::HTTP_CREATED)
//            ->setStatus($status);
//        if (!empty($url)) {
//            $tmp = $tmp->setData(['url' => $url]);
//        }
//        return $tmp->response();
//    }

//    public function deleted($status = "success")
//    {
//        return $this->setStatusCode(FoundationResponse::HTTP_NO_CONTENT)
//            ->setStatus($status)
//            ->response();
//    }

    public function failed($errorCode, $errorMessage, $statusCode = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error')
    {
        return $this->setStatusCode($statusCode)
            ->setStatus($status)
            ->setErrorCode($errorCode)
            ->setErrorMessage($errorMessage)
            ->response();
    }

    public function missParameters ($errorMessage = "缺少参数!")
    {
        return $this->failed(Errors::BAD_REQUEST, $errorMessage);
    }

    public function notFound($errorCode = Errors::NOT_FOUND, $errorMessage = "Not found!")
    {
        return $this->failed($errorCode, $errorMessage, FoundationResponse::HTTP_NOT_FOUND);
    }

    public function internalError($errorCode = Errors::INTERNAL_SERVER_ERROR, $errorMessage = "Internal error!")
    {
        return $this->failed($errorCode, $errorMessage, FoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function unauthorized($errorCode = Errors::UNAUTHORIZED, $errorMessage = "Unauthorized!")
    {
        return $this->failed($errorCode, $errorMessage, FoundationResponse::HTTP_UNAUTHORIZED);
    }

    public function forbidden($errorCode = Errors::FORBIDDEN, $errorMessage = "Permission denied!")
    {
        return $this->failed($errorCode, $errorMessage, FoundationResponse::HTTP_FORBIDDEN);
    }

    public function conflict($errorCode = Errors::CONFLICT, $errorMessage = "Conflict!")
    {
        return $this->failed($errorCode, $errorMessage, FoundationResponse::HTTP_CONFLICT);
    }

}
