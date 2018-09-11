<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Model\Dao\User;
use Model\Dao\Item;

function pat($a, $l) {
  $x = array('');
  for ($i = 0; $i < $l; ++$i) {
    $_x = array();
    foreach ($a as $ak => $av) {
      $j=0;
	    foreach ($x as $xk => $xv) {
        $xv .= $av;
          if($j<count($x))
            $xv .= ',';
          $_x[] = $xv;
          $j=$j+1;
        }
      }
      $x = $_x;
    }
	return $x;
}


		// $data = [];
  //   $userItem = new Item($this->db);
  //   $where = [
  //       'price' => 100,
  //       'name'  => '%チョコレート%'
  //   ];
  //   $data = $userItem->select($where);
  //   var_dump($data);

// スッキリ画面コントローラ
$app->post('/results/', function (Request $request, Response $response) {

	//GETされた内容を取得します。
	$limit = $request->getParsedBody();
	$minarray = array();
  $min=100;

  $userItem = new Item($this->db);
  $c = $userItem->distinct();
  $a = array();
  foreach($c as $b){
		array_push($a, strval($b["price"]));
  }
  // $a = array('11','32','54','108','216','324');
  $l = 4;
  $i=1;
  while($i<=$l)
  {
    $x=array();
    $x=pat($a,$i);
    foreach($x as $xy)
    {
      $xy=substr($xy,0,-1);
      $arr = explode(',', $xy);
      if(array_sum($arr)==$limit){
        $min=0;
        $minarray=$arr;
        break;
      } elseif(array_sum($arr)<$limit) {
        $minx=$limit-array_sum($arr);
        if($min>$minx) {
          $min=$minx;
          $minarray=$arr;
        }
      }
    }
    if($min==0)
    {
      break;
    }
    $i += 1;
  }

  $res = array();
  foreach ($minarray as $_) {
  	$param["price"]=$_;
  	$userItem->select($param, "", "", 1, false);
  	array_push($res, $userItem);
  }
  var_dump($res);
	// $minarray = [324, 206]

  // Render index view
	return $this->view->render($response, 'sukkiri/sukkiri.twig', $res);

});

// [{
// 	"name": asdvasdv,
// 	"price": 324,
// 	"img": "www.family.co.jp/lsdf"
// },{
// 	"name": asdflkj,
// 	"price": 54,
// 	"img": 'www.family.co.jp/adsl;fkjasd'
// }]