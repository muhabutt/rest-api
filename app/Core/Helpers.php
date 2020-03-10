<?php


namespace App\Core;


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
}
