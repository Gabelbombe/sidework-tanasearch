<?php
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

USE \Psr\Http\Message\ServerRequestInterface    AS Request;
USE \Psr\Http\Message\ResponseInterface         AS Response;

$config = '/home/ubuntu/config.json';

if (file_exists($config))
{
    $app = New \Slim\App([
        'settings' => json_decode(file_get_contents($config), 1) ## requires array =/
    ]);

    $container = $app->getContainer();
    $container['logger'] = function($c)
    {
        $logger       = New \Monolog\Logger('rescue_logger');
        $fileHandler  = New \Monolog\Handler\StreamHandler(dirname(__DIR__) . "/logs/application.log");
        $logger->pushHandler($fileHandler);
        return $logger;
    };

    $container['db'] = function ($c) {
        $db = $c['settings']['db'];
        $pdo = New PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
            $db['user'], $db['pass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        return $pdo;
    };

    $app->get('/', function (Request $request, Response $response)
    {
        $response->getBody()->write("Route slash hit"); ## basic db test

        $mapper = New \Models\ConnectionMapper($this->db);

        $this->logger->addInfo("[info] Testing connection: " . json_encode($mapper->fetch()));

        return $response;
    });

    $app->run();
} else { Throw New \RuntimeException('Failed to locate config...'); }


