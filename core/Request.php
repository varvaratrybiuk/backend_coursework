<?php

namespace core;

class Request
{
    public static function getPost($key = null)
    {
        return $key == null ? filter_input_array(INPUT_POST) : filter_input(INPUT_POST, $key);
    }
}