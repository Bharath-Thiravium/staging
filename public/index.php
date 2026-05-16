<?php

require_once dirname(__DIR__) . '/bootstrap.php';

use App\Core\Router;
use App\Core\Request;

$router  = new Router();
$request = new Request();

require ROOT_PATH . '/routes/web.php';

$router->dispatch($request);
