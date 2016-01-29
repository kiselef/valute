<?php

namespace app;

use app\request\RequestFactory;
use app\response\ResponseFactory;

class App
{
    private static $core;

    private function __construct() {}
    private function __clone() {}

    public static function go($config)
    {
        self::$core = new \ArrayObject();
        self::$core->db = $config['db']['class']::getInstance()->connect($config['db']);
        self::$core->request = RequestFactory::create($config['data-type']);
        self::$core->response = ResponseFactory::create($config['data-type']);
        if ($config['cache']['on']) {
            self::$core->cache = $config['cache']['class']::getInstance()->create($config['cache']);
        }

        $controller = new Controller();
        $controller->doAction('index');
    }

    public static function core()
    {
        return self::$core;
    }

}
