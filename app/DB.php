<?php

namespace app;

abstract class DB
{
    protected $name;
    protected $db;
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

    public function __destruct()
    {
        return $this->close();
    }

    abstract public function connect($config);
    abstract public function insert($table, $row);
    abstract public function close();
}