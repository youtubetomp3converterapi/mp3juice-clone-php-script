<?php
header('Access-Control-Allow-Origin: *'); 
    header("Content-Type: application/json");

include('function.php');
$q = $_REQUEST['q'];
$url = file_get_contents('https://youtube.com/oembed?url=http://www.youtube.com/watch?v='.$q.'&format=json');
$yts = json_decode($url);
$i = 0;
if(strlen($yts->title) > 0){
echo json_encode(array('query'=>$q,'items'=>['title'=>$yts->title.' - '.$yts->author_name,'id'=>$q,'view'=>'N/A','chtitle'=>$yts->author_name,'duration'=>'N/A'],'status'=>1));
}else{
echo json_encode(array('query'=>$q,'msg'=>'We cant find youtube video please change Youtube URL.','status'=>0));
}