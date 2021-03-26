<?php

/**
 * index.php
 * alla request går igenom denna fil
 */

use app\controllers\AuthController;
use app\controllers\SiteController;

use app\core\Application;


// require autoloadaren
require_once __DIR__ . '/../vendor/autoload.php';

//hämtar .env filen
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
];

//skapar en instans av applikationen
$app = new Application(dirname(__DIR__), $config);

//event listener, ska fixa
$app->on(Application::EVENT_BEFORE_REQUEST, function () {
    // echo "Before request from second installation";
});

//alla routes på webbplatsen
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/mobilt-bankid', [SiteController::class, 'mobilt']);
$app->router->get('/mobilt-bankid/other', [SiteController::class, 'otherDevice']);
$app->router->post('/mobilt-bankid/other', [SiteController::class, 'otherDevicePost']);

$app->router->get('/mobilt-bankid/same', [SiteController::class, 'sameDevice']);
$app->router->get('/bankid', [SiteController::class, 'bankid']);





//kör applikationen
$app->run();
