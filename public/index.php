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

    $app->get('/', function (Request $request, Response $response)
    {
        $name = $request->getAttribute('name');
        $response->getBody()->write("Hello, $name");
        return $response;
    });


    $app->get('/hello/{name}', function (Request $request, Response $response)
    {
        $name = $request->getAttribute('name');
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->run();
} else { Throw New \RuntimeException('Failed to locate config...'); }


