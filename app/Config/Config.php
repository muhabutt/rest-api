<?php

namespace App\Config;

/**
 * Class Config
 * To get php .env parameters use getValue(ENV_KEY)
 * @package App\Config
 */
class Config
{
    /**
     * @param $key
     * @return mixed|string
     */
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


