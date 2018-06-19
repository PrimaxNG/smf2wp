<?php
ob_start();

function email($email_id,$tipster,$code)	{
//Here we are going to declare the variables*/
$name = 'betpredict';
$email = 'info@betpredict.com';
$message = "
<html>
<head>
<title> betpredict Account Activation Code</title>

<style type=text/css>
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
	font-family: \"Open Sans\", Arial, Helvetica, sans-serif;
	color: #000000;
	padding: 20px;
}
.style2 {
	font-size: 12px;
	font-weight: bold;
	color: #990000;
}
body,td,th {
	font-family: \"Open Sans\", Lucida Sans Unicode, Lucida Grande, Verdana, Sans-Serif;
	font-size: 10pt;
}
-->
</style>
</head>
<body>
<div style=border:#000000 solid 1px; width:600px;>
  <table width=600 border=0 align=center cellpadding=5 cellspacing=0 style=border:2px #999999 solid; line-height:20px>
    <tr>
      <td ><span class=style1><img src=http://app.betpredict.com.ng/application/assets/img/btlogo.png alt=betpredict logo></span></td>
    </tr>
    <tr>
      <td bgcolor=#FF9900><span class=style1>betpredict Account Code</span></td>
    </tr>
    <tr>
      <td> You have just started a registration process at betpredict.com.ng. As part of the registration process, we need to confirm your email address. To finalize your registration, Kindly use the Activation below on http://app.betpredict.com.ng/confirm.php?e=$tipster  </td>
    </tr>
    <tr>
      <td><span class=style2><u> Accounts Details </u></span></td>
    </tr>
    <tr>
      <td><strong>Tipster/Username</strong> :  $tipster</td>
    </tr>
    <tr>
      <td><strong>Activation Code </strong> : $code </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Thank you for joining betpredict! </td>
    </tr>
    <tr>
      <td align=left><a href=mailto:tipster@betpredict.com.ng>contact us via our email address </a></td>
    </tr>
  </table>
</div>
</body>
</html>";

//Save visitor name and entered message into one variable:
$formcontent="$message\n\n ";
$recipient = "$email_id";
$subject = "betpredict Registration Code";
$mailheader = "From: $email\r\n";
$mailheader .= "Reply-To: $email\r\n";
$mailheader .= "MIME-Version: 1.0\r\n";
$mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//HTML version of message
$mailsent = @mail($recipient, $subject, $formcontent, $mailheader);

return $mailsent;
}

?>
<?php
## mail for forgotten password
function resend($email_id,$passwd)	{
//Here we are going to declare the variables*/
$name = 'betpredict';
$email = 'info@betpredict.com';
$message = "
<html>
<head>
<title> betpredict Password retrieval</title>


<style type=text/css>
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	color: #000000;
	padding: 20px;
}
.style2 {
	font-size: 12px;
	font-weight: bold;
	color: #990000;
}
body,td,th {
	font-family: Lucida Sans Unicode, Lucida Grande, Verdana, Sans-Serif;
	font-size: 8pt;
}
-->
</style>
</head>
<body>
<div style=border:#000000 solid 1px; width:600px;>
  <table width=600 border=0 align=center cellpadding=5 cellspacing=0 style=border:2px #999999 solid; line-height:20px>
    <tr>
      <td bgcolor=#009CFF><span class=style1>betpredict Account Password  </span></td>
    </tr>
    <tr>
      <td> You have requested your password from our wesbsite    
	</tr>
    <tr>
      <td><span class=style2><u> Accounts Details </u></span></td>
    </tr>
    <tr>
      <td><strong>Username</strong> :  $email_id</td>
    </tr>
    <tr>
      <td><strong>Reset Password </strong> : $passwd </td>
    </tr>
    <tr>
      <td> Note!!! Kindly remember to change this reset password after you login successfully.    
	</tr>       
    <tr>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td>Thank you for using betpredict! </td>
    </tr>
    <tr>
      <td align=left><a href=mailto:support@betpredict.com>contact us</a> via mail</td>
    </tr>
  </table>
</div>
</body>
</html>";

//Save visitor name and entered message into one variable:
$formcontent="$message\n\n ";
$recipient = "$email_id";
$subject = "betpredict Password Retrieval";
$mailheader = "From: $email\r\n";
$mailheader .= "Reply-To: $email\r\n";
$mailheader .= "MIME-Version: 1.0\r\n";
$mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//HTML version of message
$mailsent = @mail($recipient, $subject, $formcontent, $mailheader);

return $mailsent;
}

?>
<?php
## mail for forgotten password
function reg($email_id,$reg_email)	{
//Here we are going to declare the variables*/
$name = 'betpredict';
$email = 'tipster@betpredict.com.ng';
$message = "
<html>
<head>
<title> New registration</title>

</head>
<body>
<div style=border:#000000 solid 1px; width:600px;>
  <table width=600 border=0 align=center cellpadding=5 cellspacing=0 style=border:2px #999999 solid; line-height:20px>
    <tr>
      <td bgcolor=#009CFF><span > New Registration </span></td>
    </tr>
    <tr>
      <td> This is a new Registration    </tr>
    <tr>
      <td><span class=style2><u> Accounts Email </u></span></td>
    </tr>
    <tr>
      <td><strong>Username</strong> :  $reg_email</td>
    </tr>
 </table>
</div>
</body>
</html>";

//Save visitor name and entered message into one variable:
$formcontent="$message\n\n ";
$recipient = "$email_id";
$subject = "$email_id";
$mailheader = "From: $email\r\n";
$mailheader .= "Reply-To: $email\r\n";
$mailheader .= "MIME-Version: 1.0\r\n";
$mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//HTML version of message
$mailsent = @mail($recipient, $subject, $formcontent, $mailheader);

return $mailsent;
}

?>

<?php
## mail for forgotten password
function facebook($mstatus,$delemail,$usermail)	{
	//Here we are going to declare the variables*/
	$email="$usermail";
	$message="Updating Facebook";
	$formcontent="$message\n\n ";
	$recipient = "$delemail";
	$subject = "$mstatus";
	$mailheader = "From: $email\r\n";
	$mailheader .= "Reply-To: $email\r\n";
	$mailheader .= "MIME-Version: 1.0\r\n";
	$mailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//HTML version of message
	$mailsent = @mail($recipient, $subject, $formcontent, $mailheader);
	
	return $mailsent;
}

?>