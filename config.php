<?php

return array(
    'data-type' => 'Json',
    'db' => array(
        'class' => 'app\MongoDb',
        'name' => 'app',
        'connect' => 'mongodb://localhost:27017',
    ),
    'cache' => array(
        'on' => true,
        'class' => 'app\cache\MCache',
        'host' => 'localhost',
        'port' => 11211
    )
);