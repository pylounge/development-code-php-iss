<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function getData($index)
    {
        return $_SESSION[$index]?? null;
    }

    public function addData($index, $data)
    {
        $_SESSION[$index] = $data;
    }
}