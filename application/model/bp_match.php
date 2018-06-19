<?php
### record Match Details
if (isset($_POST['record_match']))	{
	$num=$_GET['num'];
	$l=$_GET['league'];
	#"Number of Matches".$num;
	
	##loop through entry data
	for ($d=1; $d<=$num; $d++)	{
		$hometeam="hometeam".$d;
		$awayteam="awayteam".$d;
		$matchdate="DAT".$d;
		$matchtime="TIM".$d;		
		$hometeam=$_POST[$hometeam];
		$awayteam=$_POST[$awayteam];		
		$sql="select id,league,hometeam,awayteam from bp_match where league='".$l."' and hometeam='".$hometeam."' and awayteam='".$awayteam."'";
		$bp_query=mysql_query($sql);
		$rr=fetch_assoc($bp_query);
		if (counter($bp_query)>=1)	{
			$_POST['matchdate']=$_POST[$matchdate];
			$_POST['matchtime']=$_POST[$matchtime];
			$_POST['week']=@find_match_week($l,$_POST['matchdate']);			
			###Update
			$update = array();
			$update[4]='matchdate';
			$update[5]='week';			
			$update[10]='matchtime';
			update_selected("bp_match", $update, id, $rr['id']);
			$errorCode=1;
			$errorMsg="Match Data Successfully Updated";			
			$display=0;			
		}
		else	{
			##Insert Record to DB
			$_POST['league']=$l;
			$_POST['matchdate']=$_POST[$matchdate];
			$_POST['matchtime']=$_POST[$matchtime];			
			$_POST['hometeam']=mysql_real_escape_string($hometeam);
			$_POST['awayteam']=mysql_real_escape_string($awayteam);
			$_POST['week']=@find_match_week($l,$_POST['matchdate']);
			
			###
			$insert=insert_all("bp_match");
			$errorCode=1;
			$errorMsg="Match Data Successfully Entered";
			$display=0;			
		} ### end counter check
	} ## end for check
} ## end sumbit check

###############<br>


?>