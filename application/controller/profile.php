<?php
## Controller Script for Profile Page - /profile/profile/
?>
<?php
## fetch credit details
/*$credit_query = mysql_query("select credit,SubAcct1 from profile where email_id = '".$_SESSION['whoId']."'");
if (counter($credit_query)>=1)	{
	$credit = fetch_assoc($credit_query);
	if ($credit['credit']<0)	{
		$reset=mysql_query("update sms_users set active=2 where email_id = '".$_SESSION['whoId']."'");
		header("location: ../logout.php");
	}
	else	{
		$balance= $credit['credit'];
		$bonus= $credit['SubAcct1'];
	}
}*/
	
?>
<?php
## report Chart Function
/*function chart($email)	{
	$query=mysql_query("SELECT message.datetime, Count(message.gsm) as gsm FROM message WHERE message.email_id = '".$email."' GROUP BY message.datetime");
	return $query;
	
}
*/



?>