<title>SMS Account Profile Settings</title>
<?php
## fetch login details
$result2 = mysql_query("select * from profile where email_id = '".$_SESSION['whoId']."'");
if (counter($result2)>=1)	{
	$row2 = fetch_assoc($result2);
}
## check profiles
if (isset($_POST['update']))	{
$result = mysql_query("select email_id from profile where email_id = '".$_SESSION['whoId']."'");
### check if account has been updated
//echo counter($result);
	if (counter($result)>=1)	{
		$row = fetch_assoc($result);
			#update Transaction in DB
				## Update Transaction Data
				$update = array();
				$update[3]='firstname';
				$update[4]='lastname';
				$update[5]='address';
				$update[6]='city';
				$update[7]='state';
				$update[8]='country';
				$updateRec=update_selected("profile",$update,"email_id", $_SESSION['whoId']);
		
			if ($updateRec==0)	{
				echo "<meta http-equiv='Refresh' content='1; URL=?vha=2_1&u=0#ProfileUpdated'>";
				header("location: ?vha=2_1&u=0#ProfileUpdated");
			}
			else	{
				$errorCode=3;
				$errorMsg = "There was an error with your Account Update";
			}
	}
}
##

	###Echo Updated Message
	if (isset($_GET['u']))	{
			$errorCode=1;
			$errorMsg = "Account (Profile Data) Successfully Updated";
	}
		
	
?>
<?php
## check profiles
if (isset($_POST['updatep']))	{
$result = mysql_query("select tipster,passwd from bp_users where tipster= '".$_SESSION['whoId']."'");
### check if account has been updated
	if (counter($result)>=1)	{
		$row = fetch_assoc($result);
		## check the validity of the new password
		if (strlen($_POST['new_passwd'])<6)	{
			 $errorCode=3;
			 $errorMsg = "New Password Character must be between 6-25";
		}
		elseif($_POST['new_passwd']!=$_POST['o_new_passwd'])	{
 			 $errorCode=3;		
			 $errorMsg = "New Passwords do not Match";
		}
		elseif($_POST['passwd']!=$row['passwd'])	{
 			 $errorCode=3;		
			 $errorMsg = "Error: Old Password Entry is wrong";
		}		
		else	{
			
				$lgn = mysql_query("update bp_users set passwd = '".$_POST['new_passwd']."', o_passwd = '".md5($_POST['new_passwd'])."' where tipster= '".$_SESSION['whoId']."'");
			 	 $errorCode=1;	
				 $errorMsg = "Password Changed Successfully";
		}
	}
	else	{
		 $errorCode=3;		
		 $errorMsg = "Pasword was Invalid: Try Again";
	}
}
?>