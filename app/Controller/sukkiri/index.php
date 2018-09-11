<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;

// スッキリ画面コントローラ
$app->get('/results/', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $data = $request->getQueryParams();

    // Render index view
    return $this->view->render($response, 'sukkiri/sukkiri.twig', $data);

});
