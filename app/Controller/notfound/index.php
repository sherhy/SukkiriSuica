<?php

use Slim\Http\Request;
use Slim\Http\Response;

// TOPページのコントローラ
$app->get('/notfound/', function (Request $request, Response $response) {

    $data = [];

    // Render index view
    return $this->view->render($response, 'notfound/notfound.twig', $data);
});


