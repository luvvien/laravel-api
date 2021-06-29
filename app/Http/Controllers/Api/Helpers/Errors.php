<?php


namespace App\Http\Controllers\Api\Helpers;


class Errors
{
    const BAD_REQUEST = 400000;

    const UNAUTHORIZED = 401000;
    const INVAlID_TOKEN = 401001;

    const FORBIDDEN = 403000;

    const NOT_FOUND = 404000;

    const METHOD_NOT_ALLOWED = 405000;

    const CONFLICT = 409000;

    const INTERNAL_SERVER_ERROR = 500000;

    const SERVER_MAINTENANCE = 503000;
}
