<?php
require_once('_autoload.php');
$title = 'Special Rightholders Accounts - '.$c['title'];
function hscript($c){
  echo '<link rel="stylesheet" type="text/css" href="'.$c['cdns'].'/assets/cstyle.css" >';
}
include('template/header.php');
if(isset($_POST['captcha']) && isset($_POST['organization']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['state']) && isset($_POST['country']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['document'])){
$captcha = $_POST['captcha'];
$organization = $_POST['organization'];
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$state = $_POST['state'];
$country = $_POST['country'];
$phone = $_POST['phone'];
$document = $_POST['document'];
  if($captcha == 'PEACE'){
  	if(strlen($name) > 3){
  		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	if(preg_match("/http:\/\/.*?\.pdf\b/i", $document)){
  		$subject = 'SRA email from '.$name;
  		$txt = "SRA email : ".$email."\n\n NAME : ".$name."\nAddress : ".$address."\nState : ".$state."\nCountry : ".$country."\nPhone : ".$phone."\nDocument URL : ".$document."\n";
  		$headers = "From: admin@vevioz.com";
  		mail($c['email'],$subject,$txt,$headers);
  echo '<div class="text"><p>Your registration request was successfully received. If your request is accepted, we will send you further information via email..</p></div>';
  		}else{
  echo '<div class="text"><p>Your documents must be valid pdf URL format</p></div>';
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
?><h1>Special Rightholders Accounts</h1>
<div class="text"> <p> In our discretion, we may give you a „Special Rightsholders Account” with which you will be permitted to provide a list of URLs in one easy format to have content or search results removed from our website. </p> <p> To register for an account, please fill out the form below. You will need to fill out all the fields to submit the form, including by providing documentation proving your affiliation with a rightsholder (please provide a URL linking to a pdf file with the documentation). </p> <p> You may only be granted a Special Rightsholders Account if you agree to abide by the <a href="special-rightholders-account-terms-and-conditions/">special terms and conditions</a> of the account. </p> <form id="sra" method="post"> <div> <label for="organization">Organization:</label> <br> <input id="organization" type="text" name="organization"> </div> <div> <label for="name">Name:</label> <br> <input id="name" type="text" name="name"> </div> <div> <label for="address">Address:</label> <br> <textarea id="address" name="address" class="ta_small"></textarea> </div> <div> <label for="state">State:</label> <br> <input id="state" type="text" name="state"> </div> <div> <label for="country">Country:</label> <br> <input id="country" type="text" name="country"> </div> <div> <label for="email">Email:</label> <br> <input id="email" type="text" name="email"> </div> <div> <label for="phone">Phone:</label> <br> <input id="phone" type="text" name="phone"> </div> <div> <label for="document">Document of proof (.pdf)</label> <br> <input id="document" type="text" name="document" class="t_large"> </div> <div> <label for="captcha">Captcha (Please, type in PEACE):</label> <br> <input id="captcha" type="text" name="captcha" autocomplete="off"> </div> <input type="submit" value="Send"> </form> </div>
<?php
}
function fscript($c){
echo '<script>$(document).ready(function(){$("form").submit(function(){var e=!1;switch(0<$("#error").length&&$("#error").remove(),$(this).attr("id")){case"contact":t=["name","email","message","captcha"];break;case"sra":var t=["organization","name","address","state","country","email","phone","document","captcha"]}return $.each(t,function(t,r){(r=$.trim($("#"+r).val())).length<1&&(e=!0)}),!e||($("form").before(\'<div id="error">You need to fill out all fields to send the \'+$(this).attr("id")+" request.</div>"),!1)})});
</script>';
}
include('template/footer.php');
?>
