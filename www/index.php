<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

$container = require __DIR__ . '/../app/bootstrap.php';

// absolute filesystem path to this web root
define('WWW_DIR', __DIR__);

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

// absolute temp path to the application root
define('TEMP_DIR', WWW_DIR . '/../temp');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../vendor');

$container->getService('application')->run();
