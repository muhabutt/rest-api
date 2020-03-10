<?php


namespace App\Core\Request;
use App\Core\Request\IRequest as IRequest;

class Request implements IRequest
{
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }
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
    public function getJson()
    {
        if ($this->requestMethod == "POST")
        {
            return $_POST;
        }
    }
}
