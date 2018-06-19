<?php
$league=$_GET['l'];
#$week variable from controller bet.php

#query matchdate with week
$qdate="select distinct matchdate from bp_match where league='".$league."' ORDER by matchdate ASC";
$querydate=mysql_query($qdate);

#############submit match tips
if (isset($_POST['submit']))	{
	###
	$tqdate="select id,week,league,hometeam from bp_match where league='".$league."'";	
	$tipsdate=mysql_query($tqdate);
	###
	while ($tips=fetch_assoc($tipsdate))	{ ###loop through week matches
		#update matches
			
		##insert into tips table
		$_POST['tipster']=$_SESSION['whoId'];
		$_POST['match_id']=$tips['id'];
		$ftr="FTR".$tips['id'];
		$_POST['ftr']=$_POST[$ftr];
		$mg="G25".$tips['id'];
		$_POST['mg']=$_POST[$mg];
		$fsh="HS".$tips['id'];
		$_POST['fsh']=$_POST[$fsh];
		$fsa="AS".$tips['id'];
		$_POST['fsa']=$_POST[$fsa];
		$btts="BTTS".$tips['id'];
		$_POST['btts']=$_POST[$btts];
		$oddeven="OE".$tips['id'];
		$_POST['oddeven']=$_POST[$oddeven];				
		###tip registered date
		$_POST['tip_date']=today();
		##check for duplicates and update
		$check=mysql_query("select match_id,tipster from bp_tips where match_id='".$_POST['match_id']."' and tipster='".$_POST['tipster']."'");
		if (counter($check)>=1)	{ ## tips has been posted #Update
			if (($_POST['ftr']=="") && ($_POST['mg']=="") && ($_POST['fsh']=="") && ($_POST['fsa']==""
			) && ($_POST['btts']=="") && ($_POST['oddeven']==""))	{
				##do nothing	
				#echo "Nothing dey here - Update";
			}
			else	{		
				$update=mysql_query("UPDATE bp_tips 
				set ftr='".$_POST['ftr']."',
				mg='".$_POST['mg']."',
				fsh='".$_POST['fsh']."',
				fsa='".$_POST['fsa']."',
				tip_date='".$_POST['tip_date']."',
				btts='".$_POST['btts']."',
				oddeven='".$_POST['oddeven']."' 
				where tipster='".$_POST['tipster']."' and match_id='".$_POST['match_id']."'");
				$errorCode=1;
				$errorMsg="Success!!! Your tips have been updated successfully";
				$display=0;	
			}		
		}
		else	{ ##tips for match doesnt exist, insert
			##check if there are any tips for the match
			if (($_POST['ftr']=="") && ($_POST['mg']=="") && ($_POST['fsh']=="") && ($_POST['fsa']==""
			)&& ($_POST['btts']=="") && ($_POST['oddeven']==""))	{
				##do nothing	
				#echo "Nothing dey here  Insert";
			}
			else	{
				$insert=insert_all(bp_tips);
				$errorCode=1;
				$errorMsg="Success!!! Your new tips have been registered";
				$display=0;
			}
		}
	}
}

?>