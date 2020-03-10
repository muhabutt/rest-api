<?php

namespace App\Config;

class Config
{
    public static function getValue($key)
    {
        $configData = $_ENV;
        $configValue = "";
        if (array_key_exists($key, $configData)) {
            foreach ($configData as $arrayKey => $value) {
                if ($arrayKey === $key) {
                    $configValue = $value;
                }
            }
        }
        return $configValue;
    }
}


