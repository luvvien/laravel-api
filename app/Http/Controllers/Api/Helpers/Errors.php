<?php


namespace App\Http\Controllers\Api\Helpers;


class Errors
{
    const BAD_REQUEST = 400000;

    const UNAUTHORIZED = 401000;

    const FORBIDDEN = 403000;

    const NOT_FOUND = 404000;
    const NO_ONGOING_WORKOUT = 404001;

    const METHOD_NOT_ALLOWED = 405000;

    const CONFLICT = 409000;

    const INTERNAL_SERVER_ERROR = 500000;
//    503001; 非营业时段
//    503002; 算法服务器维护
}
