<?php

namespace App\Core;


/**
 * Class Controller base controller, function which can be used in all the controllers
 * can be implemented here
 * @package App\Core
 */
class Controller
{
    /**
     * Function used to pass data to the vies,
     * $view parameter is path to view file, and $data is for passing data to be handled inside view
     * @param string $view
     * @param array $data
     * @noinspection PhpUnusedParameterInspection
     * @noinspection PhpIncludeInspection
     */
    protected function view(string $view, $data = [])
    {
        require_once("../app/Views/{$view}.php");
    }

    /**
     *
     * @param $inputName
     * @return string|null
     */
    protected function input($inputName)
    {
        $input = null;
        if (!isset($_POST[$inputName])) {
            $input = null;
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER["REQUEST_METHOD"] === 'post') {
               $input = htmlspecialchars($_POST[$inputName]);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER["REQUEST_METHOD"] === 'get') {
                $input = htmlspecialchars($_GET[$inputName]);
            }
        }
        return $input;
    }
}
