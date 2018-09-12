<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\SukkiriLog;
use Model\Dao\Item;

// スッキリログコントローラ
$app->get('/history/', function (Request $request, Response $response) {

    //GETされた内容を取得します。
    $data = $request->getQueryParams();

//     var_dump($data);

    // 対象ログ取得
    $sukkiriLogQuery = new SukkiriLog($this->db);
    $logs = $sukkiriLogQuery->select(['log_id' => $data['log_id']],null, null, 1);

    // 商品取得
    $itemQuery = new Item($this->db);
    $items = $itemQuery->getItems($logs['ids']);

	// Render index view
	return $this->view->render($response, 'sukkiri/history.twig', ['res' => $items]);
});
