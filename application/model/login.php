<?php 
/* Login Index DB Model Controller*/
include "application/control/conn.php"; 
include "application/control/mail.php"; 
##
if (isset($_SESSION['whoId']))	{
	header("location: dashboard/?#");
}
if (@$_GET['err']==3)	{
	$errorMsg = 'Current User must be logged out before new Registration';
}

##
if (isset($_POST['signin']))	{
	$errorCode=3;
	$query = mysql_query("select id, email_id,tipster, o_passwd, active from bp_users where tipster='".mysql_real_escape_string($_POST['tipster'])."' or email_id='".mysql_real_escape_string($_POST['tipster'])."' and o_passwd='".d54(mysql_real_escape_string($_POST['password']))."'  ");
	if (counter($query)>=1)	{
		$row = fetch_assoc($query);
		if ($row['active']==2)	{
			$errorMsg = "Account is Blocked, Please Contact Support!!! {support@etpredict.com.ng}";
		}
		elseif ($row['active']!=1)	{
			$errorMsg = "Account Not Activated, Please Contact Support!!!";
		}		
		else	{
			$_SESSION['whoId']=$row['tipster'];
			$_SESSION['sessionId']=session_id();
			setcookie("appUser", $row['email_id'], time()+86400);
			##
			#$newLogin=date("Y-m-d H:i:s");
			#$query = mysql_query("update sms_users set last_login='".$newLogin."' where id='".$row['id']."'");
			## load dashboard
			header("location: dashboard/?vha=1_1#");
		}
	}
	else{
		$errorMsg = "<div>The username or password is incorrect ( <a href=#>?</a> )</div>";
	}
}
?>
<?php

if (isset($_POST['resetp']))	{
	$query = mysql_query("select email_id,tipster from bp_users where email_id='".$_POST['email_id']."' or tipster='".$_POST['email_id']."' ");
	if (counter($query)>=1)	{
		$row = fetch_assoc($query);
		// Get a random string.
		$reset= generateRandomString(11);
		$md5reset=md5($reset);
		####Reset account password
		$updatep=mysql_query("UPDATE bp_users set passwd='".$reset."', o_passwd='".$md5reset."' where email_id='".$row['email_id']."'");
		###send emails
		$resend = resend($_POST['email_id'],$row['passwd']);
		if ($resend)	{
			$errorCode=1;
			$errorMsg = "A mail containing a new password has been sent to your Mail Address, Pls remember to change it";
		}
		else{
			$errorCode=2;		
			$errorMsg = "We could not send the mail: Contact Administrator";
		}
	}
	else{
		$errorCode=3;		
		$errorMsg = "The Account details do not match our Database";
	}
}


###

?>