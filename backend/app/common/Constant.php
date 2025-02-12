<?php

namespace App\Common;

class Constant{
    #Panigation
    const PAGINATE_DEFAULT = 5;

    #Format
    const FORMAT_DATE = 'Y-m-d';

    #Status Code
    const OK = 200;
    const MOVED_PERMANENTLY = 301;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const REQUEST_TIMEOUT = 408;
    const TOO_MANY_REQUEST = 429;
    const INTERNAL_SERVER_ERROR = 500;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
}
