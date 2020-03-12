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
     * $view paramter is path to view file, and $data is for passing data to be handled inside view
     * @param $view
     * @param array $data
     */
    protected function view($view, $data = [])
    {
        require_once('../app/Views/' . $view . '.php');
    }

    /**
     *
     * @param $inputName
     * @return string|null
     */
    protected function input($inputName)
    {
        if (!isset($_POST[$inputName]) || !isset($_POST[$inputName])) {
            return null;
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER["REQUEST_METHOD"] === 'post') {
                return htmlspecialchars($_POST[$inputName]);
            } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER["REQUEST_METHOD"] === 'get') {
                return htmlspecialchars($_GET[$inputName]);
            }
        }
    }
}
