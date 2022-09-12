<?php
header('Access-Control-Allow-Origin: *'); 
    header("Content-Type: application/json");

include('function.php');
$q = $_REQUEST['q'];
$yt = new Youtube;
$yts = json_decode($yt->search($q));
$i = 0;
foreach ($yts->items as $item){
    $data[$i]['title'] = $item->title;
    $data[$i]['id'] = $item->id;
    $data[$i]['size'] = $item->size;
    $data[$i]['duration'] = $item->duration;
    $i++;
}
echo json_encode(array('query'=>$q,'items'=>$data));