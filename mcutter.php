<?php
include('application/config.php');
$title = 'Mobile Cutter - '.$c['title'];
function hscript($c){
echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/cstyle.css" >';
}
include('template/header.php');
?>
  <h1>MP3 Cutter</h1> <div class="text"> <p> Here you can quickly and easily cut or remove soundless parts from your MP3 files. If you would only like to remove the soundless part of an MP3, please select a file and press „Cut MP3”. </p> <p> If you would like to cut the file, please enter a start or end time, or both and press „Cut MP3”. As soon as the MP3 file has been processed, a download link will appear. Through this link you will be able to download the final file. </p> <p> <strong>Please note:</strong> <br> The maximum length of an MP3 file must not exceed 1:59:59. By pressing „Select MP3” you confirm your consent to our <a href="terms-of-use/" style=" color: white; ">Terms of Use</a>. </p> <div id="cutter"> <iframe src="https://cutter.vevioz.com/" width="100%" height="400" scrolling="no" frameborder="no"></iframe> </div> </div>
<?php
function fscript($c){
echo '<script src="'.$c['cdns'].'/assets/main.js"></script>';
}
include('template/footer.php');
?>