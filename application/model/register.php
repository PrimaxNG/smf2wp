<?php
include "application/control/conn.php"; 
include "application/control/mail.php"; 
include "application/controller/msgssf.php"; 
## registration code
## add command button
if (isset($_POST['register']))	{
	$errorCode=3;

        if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          $errorMsg= "Please check the the captcha form";
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdtlQsTAAAAAI4MgGHAvTyH6V8rnkClQZQ-JEyc&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response.success==false)
        {
          $errorMsg= "Registration not allowed for non-verified humans";
        }else
        {
          #$errorMsg= "Thanks for posting comment.</h2>';
        }

	##logout if user is on
	if (isset($_SESSION['whoId']))	{
		header("location: logout.php?err=3");
	}
	else	{
	## check If data exist already
		$chk = exist_b4(bp_users,email_id,$_POST['email_id']);
		$chkmobile = exist_b4(bp_users,tipster,$_POST['username']);
		if (($chk)>=1)	{
			$errorMsg = "User with this Email ID already Exist";
		}
		elseif(($chkmobile)>=1){
			$errorMsg = "User with this Tipster Username already Exist";
		}
		elseif ((strlen($_POST['passwd'])<6) || (strlen($_POST['passwd'])>25)){
			$errorMsg = "Invalid Password length: Password length should be between 6-25";
		}
		elseif ($_POST['cpasswd']!=$_POST['passwd'])	{
			$errorMsg = "Passwords Confirmation Not Valid";
		}
		else	{
		
			$_POST['act_code'] = sha1($_POST['email_id']);
			$_POST['o_passwd'] = md5($_POST['passwd']);
			$_POST['active']=0;
            $_POST['user_type']="member";
            $_POST['tipster']=$_POST['username'];			
			$_POST['reg_date']=today();
            $_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
            $_POST['email_id']=strtolower($_POST['email_id']);
			insert_all(bp_users);
			// send verification mail
			email($_POST['email_id'],$_POST['username'],substr($_POST['act_code'],0,5));
			reg("tipster@betpredict.com.ng",$_POST['email_id']);
			#header("location: confirmation.php");
			##
			$message="Welcome+to+betpredict.com.ng,Your+Tipster+Activation+Code+is+".substr($_POST['act_code'],0,5);
			$sendmsg=sendmsg($_POST['mobile'],$message);
			$errorCode=1;
			$errorMsg="Account Has been Created Successfully. Contact Admin to Activate your Account. Send an email with your Tipster Code to tipster@betpredict.com.ng";
			header("location: confirm.php?e=".$_POST['tipster']."");
		}
	} // session check
}


##
if (isset($_POST['activate']))	{
	$errorCode=3;
	$tipster=$_GET['e'];
	$query = mysql_query("select id, email_id,tipster, act_code from bp_users where tipster='".mysql_real_escape_string($tipster)."' ");
	if (counter($query)>=1)	{
		$row = fetch_assoc($query);
		$acode=substr($row['act_code'],0,5);
		if ($acode==$_POST['acode'])	{
			$errorCode=1;
			$errorMsg = "Account is Confirmed and Activated, <a href=index.php>You can login now</a>";
			$update=mysql_query("UPDATE bp_users set active=1 where id='".$row['id']."'");
			#header("location: dashboard/?vha=1_1#");
		}
		else	{
			$errorMsg = "Account not confirmed. Invalid Code. Kindly Contact support or try again";
		}
	}
	else{
		$errorMsg = "Something Went Wrong: Contact Support tipstser@betpredict.com.ng";
	}
}
?>