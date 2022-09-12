<?php
require_once('_autoload.php');
$title = 'FAQ - '.$c['title'];
function hscript($c){
  echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/fmain.css" >';
}
include('template/header.php');
?><h1>FAQ</h1>
<div class="text"> <p> <strong>I'm getting no results for my search query.</strong> <br> Please be sure that at least 1 download source is activated. You can manage the download sources with the „manage sources” button under the search bar. If you still get no results - please try to delete your browser cache, restart your browser and refresh the page before starting your search again. </p> <p> <strong>I'm not able to enable/disable a download source.</strong> <br> Please try to delete your browser cache, restart your browser and refresh the page. If it still doesn't work write us an email using our <a href="/contact/">contact form</a>. </p> <p> <strong>I just get an error message and no file when I click download.</strong> <br> Please send us the error code you see on the error page via our <a href="/contact/">contact form</a>. We'll check it and then we will try to fix the error. </p> <p> <strong>I am not able to save the file on my Apple Device.</strong> <br> It is not possible to save files on iPhones, iPads or iPods without the use of additional applications. If you would like to save files on your Apple device, you can install a browser app like <a href="https://itunes.apple.com/us/app/documents-by-readdle/id364901807?mt=8" rel="nofollow" target="_blank">Documents by Readdle</a>. With the browser of such an app you can download files to your device. An alternative solution is to save a file to the cloud and stream it from there. </p> <p> <strong>I am receiving push notifications from Download-lagu-mp3.com and would like to stop them.</strong> <br> <a href="/unsubscribe/" rel="nofollow" target="_blank">Unsubscribe (video instruction)</a> </p> <p> <strong>I would like to upload my music to Download-lagu-mp3.com.</strong> <br> It is not possible to upload any files to Download-lagu-mp3.com. If you want to list your files in our search - upload your music on youtube.com, soundcloud.com or any other supported download source. On the next search your music should be listed in our search. </p> </div>
<?php
function fscript($c){
echo '<script src="'.$c['cdns'].'/assets/main.js"></script>';
}
include('template/footer.php');
?>