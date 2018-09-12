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


// スッキリ画面コントローラ
$app->post('/results/', function (Request $request, Response $response) {

	//GETされた内容を取得します。
	$money = $request->getParsedBody();
	$limit = $money["zangaku"];
	// var_dump($limit);

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


  $minarrays = array();

  $limit = array_sum($minarray);

  $array = array();
  $min=100;

  $l = 4;
  $i=1;

  $minarrayscount = 0;

  while($i<=$l)
  {
    $x=array();
    $x=pat($a,$i);
    foreach($x as $xy)
    {
      $xy=substr($xy,0,-1);
      $arr = explode(',', $xy);


      if(array_sum($arr)==$limit)
      {
        $minarrays[$minarrayscount]=$arr;
        $minarrayscount += 1;
        break;
      }

    }
    $i += 1;

    if ($minarrayscount == 3)
    {
      break;
    }
  }



  $res = array();
  $total = array(0,0,0);
  for($i=0;$i<count($minarrays);$i++)
  {
    for($j=0;$j<count($minarrays[$i]);$j++)
    {
      $param["price"]=$minarrays[$i][$j];
    	$result=$userItem->select($param, "", "", 1, false);
    	$total[$i] += $minarrays[$i][$j];
    	$res[$i][$j] = $result;
    }
  }

	// Render index view
	return $this->view->render($response, 'sukkiri/sukkiri.twig', [
		'res' => $res,
		'total' => $total
	]);

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
