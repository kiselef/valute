<?php
//ini_set("display_errors", true);

use app\App;

require('./vendor/autoload.php');

$config = require('./config.php');

App::go($config);