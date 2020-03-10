<?php

namespace App\Core;


class Controller
{
    protected function view($view, $data = [])
    {
        require_once('../app/Views/' . $view . '.php');
    }

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
