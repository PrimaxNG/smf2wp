<?php

function quickSearchAll($string,$table,$start,$limit)	{

	$sql="SELECT * from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
	for($i=1 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}
	#$logicStr=$logicStr." eid=".$id." and icontact LIKE '%".$string."%'";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	$sql="SELECT id,country,network,country_code,credit from $table ".$logicStr ." ORDER by country ASC LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>
<?php

function quickSearchLog($string,$table,$start,$limit,$tipster)	{

	$sql="SELECT * from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
/*	for($i=1 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}*/
	#$logicStr=$logicStr." eid=".$id." and icontact LIKE '%".$string."%'";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	$logicStr=$logicStr." tipster='".$tipster."' and matchdate>='".$_SESSION['fromdate']."' and matchdate<='".$_SESSION['todate']."' ";
	$sql="SELECT * from $table ".$logicStr ." ORDER by id ASC LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>

<?php

function quickSearchUpload($string,$table,$start,$limit,$email)	{

	$sql="SELECT filetext,filename,dateupload from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
/*	for($i=1 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}*/
	#$logicStr=$logicStr." eid=".$id." and icontact LIKE '%".$string."%'";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	$logicStr=$logicStr." email_id='".$email."' and filetext LIKE '%".$string."%'";
	$sql="SELECT id,filetext,filename,dateupload from $table ".$logicStr ." ORDER by id DESC LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>
<?php

function quickSearch($string,$table,$start,$limit,$id)	{

	$sql="SELECT * from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
/*	for($i=1 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}*/
	$logicStr=$logicStr." eid=".$id." and icontact LIKE '%".$string."%'";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	echo $sql="SELECT * from $table ".$logicStr ." LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>
<?php

function quickSearchPay($string,$table,$start,$limit,$email)	{

	$sql="SELECT * from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
	for($i=2 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}
	$logicStr=$logicStr." and email_id='".$email."' ";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	$sql="SELECT * from $table ".$logicStr ." LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>

<?php

if (isset($_POST['search']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=4_2&qs=$qs#quicksearch");
}

if (isset($_POST['reset']))	{
	#change page to list page
	header("location: ?vha=4_2#resetlist");
}

?>

<?php

function quickSearchGroup($string,$table,$start,$limit,$id)	{

	$sql="SELECT * from $table";
	$sql_query=mysql_query($sql);
	$logicStr="WHERE ";
	$count=mysql_num_fields($sql_query);
/*	for($i=1 ; $i < mysql_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' ";
	else
	$logicStr=$logicStr."".mysql_field_name($sql_query,$i)." LIKE '%".$string."%' OR ";
	}*/
	$logicStr=$logicStr." eid=".$id." and group_name LIKE '%".$string."%'";
	// start the search in all the fields and when a match is found, go on printing it .
	#echo $logicStr;
	$sql="SELECT * from $table ".$logicStr ." LIMIT $start, $limit";
	//echo $sql;
	#$query=mysql_query($sql);
	
	return $sql;
}
?>

<?php

if (isset($_POST['searchGroup']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=4_4&qs=$qs#quickSearchGroupList");
}

if (isset($_POST['resetGroup']))	{
	#change page to list page
	header("location: ?vha=4_4#ResetGroupList");
}

?>

<?php

if (isset($_POST['searchcredit']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=5_6&qs=$qs#quickSearchCreditList");
}

if (isset($_POST['resetcredit']))	{
	#change page to list page
	header("location: ?vha=5_6#ResetCreditList");
}

?>

<?php

if (isset($_POST['searchsms']))	{
	#change page to search page
	$qs=$_POST['fromdate'];
	$_SESSION['fromdate']=$_POST['fromdate'];
	$_SESSION['todate']=$_POST['todate'];	
	header("location: ?vha=5_1&qs=$qs#quickSearchbp");
}

if (isset($_POST['resetsms']))	{
	#change page to list page
	header("location: ?vha=6_2#ResetSMSList");
}

?>
<?php

if (isset($_POST['searchsms2']))	{
	#change page to search page
	$qs=$_POST['fromdate'];
	$_SESSION['fromdate']=$_POST['fromdate'];
	$_SESSION['todate']=$_POST['todate'];	
	header("location: ?vha=6_3&qs=$qs#quickSearchSMSList");
}

if (isset($_POST['resetsms2']))	{
	#change page to list page
	header("location: ?vha=6_3#ResetSMSList");
}

?>

<?php

if (isset($_POST['searchupload']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=6_5&qs=$qs#quickSearchUploadList");
}

if (isset($_POST['resetupload']))	{
	#change page to list page
	header("location: ?vha=6_5#ResetUploadList");
}

?>

<?php

if (isset($_POST['searchsmsgroup']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=4_6&qs=$qs#quickSearchGroupSMS");
}

if (isset($_POST['resetsmsgroup']))	{
	#change page to list page
	header("location: ?vha=4_6#ResetGroupSMSList");
}

?>
<?php

if (isset($_POST['searchsmscontact']))	{
	#change page to search page
	$qs=$_POST['qs'];
	header("location: ?vha=4_5&qs=$qs#quickSearchContactSMS");
}

if (isset($_POST['resetsmscontact']))	{
	#change page to list page
	header("location: ?vha=4_5#ResetGroupContactSMSList");
}

?>