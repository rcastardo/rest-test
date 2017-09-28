<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

/*
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    //  $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
    $response->headers->set('Access-Control-Allow-Methods: GET, POST, PUT');
});
*/
///https://github.com/jdesrosiers/silex-cors-provider
$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
    "cors.allowOrigin" => "*",
]);

$app["cors-enabled"]($app);

$app->mount('/v1/users', new \Acme\App\Controller\UsersController());

$app->run();


