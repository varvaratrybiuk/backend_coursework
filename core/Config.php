<?php

namespace core;
use controllers\ErrorController;

class Config
{
    public static function readAndGet(string $filepath, $key = null){
        $config = null;
        try{
            if (!file_exists($filepath) || is_dir($filepath)) {
                throw new \Exception("Файл не знайдено: $filepath");
            }
            $config = require $filepath;
            if (!is_array($config)) {
                throw new \Exception("Файл конфігурації повинен повертати масив: $filepath");
            }
            return $config[$key] ?? $config;
        }
        catch (\Exception){
            $error = new ErrorController();
            $error->errorPage(500);
        }
    }
}