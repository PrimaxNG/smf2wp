<?php
## fetch user data
$result2 = mysql_query("select * from smssettings where email_id = '".$_SESSION['whoId']."'");
if (counter($result2)>=1)	{
	$row2 = fetch_assoc($result2);
}
## check profiles
if (isset($_POST['update']))	{
$result = mysql_query("select email_id from smssettings where email_id = '".$_SESSION['whoId']."'");
### check if account has been updated
//echo counter($result);
	if (counter($result)>=1)	{
		$row = fetch_assoc($result);
		
		$update = update_all(smssettings, email_id, $_SESSION['whoId']);
			if ($update)	{

				echo "<meta http-equiv='Refresh' content='1; 
				URL=../dashboard/?vha=2_1#settings'>";
				header("location: ?vha=2_2&u=0#settingsupdated");
			}
			else	{
				$errorCode=3;
				$errorMsg = "There was an error with your Account Update";
			}
	}
	else { // data was not found
		$insert = insert_all(smssettings);
		if ($insert)	{
				echo "<meta http-equiv='Refresh' content='1; 
				URL=../dashboard/?vha=2_2#settings'>";
				header("location: ?vha=2_2&u=0#settingsinsert");
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
			$errorMsg = "SMS Settings Successfully Updated";
	}

?>