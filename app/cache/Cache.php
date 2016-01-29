<?php

namespace app\cache;

abstract class Cache
{
    protected $cache;
    protected static $instance;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    abstract public function create($params);
    abstract public function set($key, $value, $exp);
    abstract public function get($key);
}