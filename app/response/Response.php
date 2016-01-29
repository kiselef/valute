<?php

namespace app\response;

abstract class Response implements ResponseInterface
{
    protected $content;

    public function get()
    {
        return $this->content;
    }

    abstract public function set($response);
    abstract public function setError($message);
    abstract public function send();
}