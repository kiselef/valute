<?php

namespace app\response;

interface ResponseInterface
{
    public function set($response);
    public function setError($message);
    public function get();
    public function send();
}