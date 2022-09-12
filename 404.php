<?php
require_once('_autoload.php');
$title = '404 Not Found - '.$c['title'];
function hscript($c){
  echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/fmain.css" >';
}
include('template/header.php');
?><div class="text"> <p style="
    text-align: center;
">Your Page Request not available</p> </div>
<?php
function fscript($c){
echo '<script src="'.$c['cdns'].'/assets/main.js"></script>';
}
include('template/footer.php');
?>