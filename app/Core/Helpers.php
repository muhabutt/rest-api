<?php


namespace App\Core;

use App\Core\Response\Response;

/**
 * Class Helpers
 * @package App\Core
 */
class Helpers
{

    /**
     * @return string
     * Generate alphanumeric unique id
     * using hexadecimal notations generate unique numbers
     */
    public static function generateUniqueID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),//1
            mt_rand(0, 0xffff),//2
            mt_rand(0, 0xffff),//3
            mt_rand(0, 0x0fff),//4
            mt_rand(0, 0x3fff) | 0x8000,//5
            mt_rand(0, 0xffff),//6
            mt_rand(0, 0xffff),//7
            mt_rand(0, 0xffff)//8
        );
    }

    /**
     * @param $message
     */
    public static function errorResponse500($message){
        $errors = [
            [
                'id' => Helpers::generateUniqueID(),
                'status' => '500',
                'title' => 'Parameter not given',
                'detail' => 'Please contact customer support',
                'error' => $message
            ]
        ];
        Response::jsonResponse(500, $errors);
    }

    /**
     * @param $message
     */
    public static function errorResponse404($message){
        $errors = [
            [
                'id' => Helpers::generateUniqueID(),
                'status' => '400',
                'title' => 'Parameter not given',
                'detail' => 'Parameter, search not given or empty',
                'error' => $message
            ]
        ];
        Response::jsonResponse(500, $errors);
    }

    /**
     * Encode special characters
     * Prevent special characters & " ' < >, this way we can protect against XSS attack
     * @param $input
     * @param string $encoding
     * @return string
     */
    public static function noSpecialCharacters($input, $encoding = 'UTF-8')
    {
        return htmlspecialchars($input, ENT_QUOTES, $encoding);
    }

    /**
     * Encode html characters
     * Prevent special characters & " ' < >, this way we can protect against XSS attack
     * @param $input
     * @param string $encoding
     * @return string
     */
    public static function noHtmlXHTMLXML1Characters($input, $encoding = 'UTF-8')
    {
        return htmlspecialchars($input, ENT_HTML5 | ENT_XHTML | ENT_XML1, $encoding);
    }
}
