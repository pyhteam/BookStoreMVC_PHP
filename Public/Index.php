<?php

use App\Core\App;
use App\Core\ErrorMiddleware;
use App\Core\Logger;
use App\Core\Router;

// Public\Index.php
require_once '../vendor/autoload.php'; // Assuming you're using Composer for autoloading
$logger = new Logger();
$router = new Router();
$errorMiddleware = new ErrorMiddleware($logger);
$app = new App($router, $errorMiddleware);
$app->run();
