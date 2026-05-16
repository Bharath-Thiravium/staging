<?php

use App\Core\Router;
use App\Modules\Home\HomeController;
use App\Modules\Blog\BlogController;
use App\Modules\Page\PageController;
use App\Modules\RealEstate\RealEstateController;

/** @var Router $router */

$router->get('/',                  [HomeController::class, 'index']);
$router->get('/blog',              [BlogController::class, 'index']);
$router->get('/blog/{slug}',       [BlogController::class, 'single']);
$router->get('/category/{slug}',        [BlogController::class, 'category']);
$router->get('/services/real-estate',   [RealEstateController::class, 'show']);
$router->get('/{slug}',                 [PageController::class, 'show']);
