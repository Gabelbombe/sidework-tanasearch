<?php
USE \Psr\Http\Message\ServerRequestInterface    AS Request;
USE \Psr\Http\Message\ResponseInterface         AS Response;

require dirname(__DIR__ ). '/vendor/autoload.php';

$app = New \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run();