<?php

use Slim\Http\Request;
use Slim\Http\Response;

// スッキリログコントローラ
$app->get('/history/', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $data = $request->getQueryParams();

	// Render index view
	return $this->view->render($response, 'sukkiri/history.twig', $data);
});
