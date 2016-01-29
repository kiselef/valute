<?php

namespace app\request;

abstract class Request implements RequestInterface
{
    abstract public function get($name);

    public function getIP()
    {
        return isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : @$_SERVER['REMOTE_ADDR'];
    }

    public function getClient()
    {
        return isset($_SERVER ['HTTP_USER_AGENT']) ? $_SERVER ['HTTP_USER_AGENT'] : null;
    }

    public function validate()
    {
        return true;
    }
}