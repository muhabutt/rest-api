<?php


namespace App\Core\Request;
use App\Core\Request\IRequest as IRequest;

/**
 * Class Request
 * @package App\Core\Request
 */
class Request implements IRequest
{
    /**
     * @var
     */
    private $requestMethod;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    /**
     *
     */
    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * @param $string
     * @return string|string[]
     */
    private function toCamelCase($string)
    {
        $result = strtolower($string);

        //Getting all server keys which starts with _
        preg_match_all('/_[a-z]/', $result, $matches);

        //found _keys
        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * @return array|void
     */
    public function getBody()
    {
        if($this->requestMethod === "GET")
        {
            return;
        }


        if ($this->requestMethod == "POST")
        {

            $body = array();
            foreach($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }


    /**
     * @return array | void
     * @noinspection PhpUnusedFunctionInspection
     */

    public function getJson()
    {
        if ($this->requestMethod == "POST")
        {
            return $_POST;
        }
    }
}
