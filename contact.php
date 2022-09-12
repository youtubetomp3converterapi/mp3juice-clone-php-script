<?php
require_once('_autoload.php');
$title = 'Contact - '.$c['title'];
function hscript($c){
  echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/cstyle.css" >';
}
include('template/header.php');
if(isset($_POST['captcha']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
$captcha = $_POST['captcha'];
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
  if($captcha == 'HAPPINESS'){
  	if(strlen($name) > 3){
  		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	if(strlen($message) > 59){
  		$subject = 'Contact email from '.$name;
  		$txt = "Contact email : ".$email."\n\n".$message;
  		$headers = "From: admin@vevioz.com";
  		mail($c['email'],$subject,$txt,$headers);
  echo '<div class="text"><p>Your contact request was successfully sent. We\'ll try to answer it within the next 48 hours.</p></div>';
  		}else{
  echo '<div class="text"><p>Your contact request must contain at least 60 letters to be sent (anti-spam protection).</p></div>';
  		}
  		}else{
  echo '<div class="text"> <p> Invalid email address. Please, try it again. </p> </div>';
  		}

  	}else{
  echo '<div class="text"> <p> The name need greater than 4 character. Please, try it again. </p> </div>';
  	}
  }else{
  echo '<div class="text"> <p> The captcha is wrong. Please, try it again. </p> </div>';
  }
}else{
?><h1>Contact Us</h1>
<div class="text"> <p> If you ever have any questions or if you want to report an error, just write us an email. Please be sure to write the email in English. We will only answer emails written in English. </p> <p> If you have a question please check if it's not already listed on the <a href="faq/">faq page</a>. If you get an error, please try to describe it as well as you can. It is hard for us to figure out an error if you just write „not working” or „error”. If you see any code errors or error messages - add them to your message. </p> <form id="contact" method="post"> <div> <label for="name">Name:</label> <br> <input id="name" type="text" name="name"> </div> <div> <label for="email">Email:</label> <br> <input id="email" type="text" name="email"> </div> <div> <label for="message">Message:</label> <br> <textarea id="message" name="message"></textarea> </div> <div> <label for="captcha">Captcha (Please, type in HAPPINESS):</label> <br> <input id="captcha" type="text" name="captcha" autocomplete="off"> </div> <input type="submit" value="Send"> </form> </div>
<?php
}
function fscript($c){
echo '<script>
$(document).ready(function(){$("form").submit(function(){var e=!1;switch(0<$("#error").length&&$("#error").remove(),$(this).attr("id")){case"contact":t=["name","email","message","captcha"];break;case"sra":var t=["organization","name","address","state","country","email","phone","document","captcha"]}return $.each(t,function(t,r){(r=$.trim($("#"+r).val())).length<1&&(e=!0)}),!e||($("form").before(\'<div id="error">You need to fill out all fields to send the \'+$(this).attr("id")+" request.</div>"),!1)})});
</script>';
}
include('template/footer.php');
?>
