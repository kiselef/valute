<?php

namespace app\request;

interface RequestInterface
{
    public function get($name);
    public function getIP();
    public function getClient();
    public function validate();
}

