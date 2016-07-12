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

    ## // begin containers

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

    ## // end containers

    $app->get('/', function (Request $request, Response $response)
    {
        $mapper = New \Models\ConnectionMapper($this->db);
        $blob   = json_encode($mapper->fetch(), \JSON_PRETTY_PRINT);

        $this->logger->addInfo("[info] Testing connection: $blob");

        $response->getBody()->write("
            Route received...
            Database connection: ok
            Received: $blob"
        ); ## basic db test

        $plainHeader = $response->withHeader('Content-type', 'text/plain');
        return $plainHeader;
    });
/*
    $app->get('/login', function (Request $request, Response $response)
    {

        $username = null;

        if ($app->request()->isPost()) {
            $username = $app->request->post('username');
            $password = $app->request->post('password');

            $result = $app->authenticator->authenticate($username, $password);

            if ($result->isValid()) {
                $app->redirect('/');
            } else {
                $messages = $result->getMessages();
                $app->flashNow('error', $messages[0]);
            }
        }

        $app->render('login.twig', array('username' => $username));

    })->via('GET', 'POST')->name('login');
*/
    $app->run();
} else { Throw New \RuntimeException('Failed to locate config...'); }


