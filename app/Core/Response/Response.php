<?php

namespace App\Core\Response;

use App\Core\Helpers;

class Response
{
    /**
     * @param null $statusCode
     * @param null $headers
     * @param null $body
     * simple json response
     */
    public static function sendJson200Response($statusCode = null, $data = null)
    {
        $body = [
            'data' => $data
        ];
        header('HTTP/1.0 ' . $statusCode);
        header("Content-type", "application/json");
        print_r(json_encode($body));
        exit(1);
    }

    /**
     * @param null $statusCode
     * @param null $errors
     */
    public static function sendJson400Response($statusCode = null, $errors = null)
    {
        $body = [
            'errors' => $errors
        ];
        header('HTTP/1.0 ' . $statusCode);
        header("Content-type", "application/json");
        print_r(json_encode($body));
        exit(1);
    }

    /**
     * Json 500 response
     */
    public static function sendJson500Response()
    {
        $errors = [
            [
                'id' => Helpers::generateUniqueID(),
                'status' => '500',
                'title' => 'Parameter not given',
                'detail' => 'Please contact customer support'
            ]
        ];

        $body = [
            'errors' => $errors
        ];
        header('HTTP/1.0 ' . 500);
        header("Content-type", "application/json");
        print_r(json_encode($body));
        exit(1);
    }

    /**
     * json response if routes are not found or url is not correctly pointing to api
     */
    public static function sendJsonRouteExceptionResponse()
    {
        $errors = [
            [
                'id' => Helpers::generateUniqueID(),
                'status' => '404',
                'title' => 'URL not found',
                'detail' => 'Please type correct url'
            ]
        ];

        $body = [
            'errors' => $errors
        ];
        header('HTTP/1.0 ' . 500);
        header("Content-type", "application/json");
        print_r(json_encode($body));
        exit(1);

    }

}
