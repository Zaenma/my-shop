<?php

use Router\Router;

require_once "../vendor/autoload.php";

define('ROOT', dirname(__DIR__));

define('DB_NAME', 'zaenma_shop');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');

$router = new Router($_GET['url']);

$router->get('/', 'src\Controllers\SiteController@home');
$router->get('/panier', 'src\Controllers\PanierController@panier');
// $router->get('/produit/:id', 'src\Controllers\SiteController@afficher_produit');
$router->get('/produits/catalogue-produit', 'src\Controllers\SiteController@catalogue');
$router->get('/details-produit/:slug', 'src\Controllers\SiteController@afficher');


$router->run();