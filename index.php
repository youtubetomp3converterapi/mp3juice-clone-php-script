<?php
require_once('_autoload.php');
function hscript($c){
  echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/main.css" >';
}
include('template/header.php');
include('template/form.php');
?>
<div id="text">
   <h1>Free MP3 Downloads</h1>   
   <p> 
    Welcome to Vevioz mp3 downloader - a popular and free mp3 search engine and tool. Just type in your search query, choose the sources you would like to search on and click the search button. The search will take only a short 
    while (if you select all sources it may take a bit longer). As soon as we find any results matching your search query - you will get a list of your results. It is that simple.
   </p>
   <p>
    Alternatively, you can also paste in a video URL and click the search button to convert a video's audio into an mp3. Once you click the search button the conversion of the video will start. As soon it is ready you
    will be able to download the converted file.
   </p>
   <p>
    The usage of our website is free and does not require any software or registration. By using our website you accept our <a href="/terms-of-use/">Terms of Use</a>.
   </p>
   <p>
    Have fun and enjoy the use of our website.
   </p>
  </div>

</div>
</div>
<?php
function fscript($c){
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.5.14/iframeResizer.min.js"></script><script src="https://assets.vevioz.com/vendor/main.js?v=1329019219"></script>';
}
include('template/footer.php');
?>