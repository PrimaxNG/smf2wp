<?php
$p=$_GET['vha'];

function active($p,$vha)	{
	if ($p==$vha)	{
		echo "active";
	}
}

?>

<ul class="list-group">
  <li class="list-group-item <?php active("1_1",$p); ?>"><a href="?vha=1_1#">My Dashboard</a></li>
</ul>
<div align="left">
<?php if (isset($_GET['l'])) { ###league predictions
echo "<h3>Prev. Prediction Results</h3>";
$st=date("Y-m-d", strtotime("-30 days"));
$ed=today();
	$_POST['total_ftr']=0; ### Total Full Time Result
	$_POST['ftr_success']=0;	### Success Rate for Full Time Result
	$_POST['total_goal25']=0; ### Total Full Time Result
	$_POST['goal25_success']=0;	### Success Rate for Full Time Result	
	$_POST['total_score']=0; ### Total Full Time Result
	$_POST['score_success']=0;	### Success Rate for Full Time Result	
	$_POST['total_btts']=0; ### Total Full Time Result
	$_POST['btts_success']=0;	### Success Rate for Full Time Result	
	$_POST['total_oddeven']=0; ### Total Full Time Result
	$_POST['oddeven_success']=0;	### Success Rate for Full Time Result	
	################
$sqlx="select hometeam,awayteam,ftr,mg,fsh,fsa,btts,aftr,goal25,ahts,aats,abtts from bp_sureview where tipster='surebet' and league='".$_GET['l']."' and (matchdate>='".$st."' and matchdate<='".$ed."')";

$query=mysql_query($sqlx);
	echo "<table class=table table-bordered>";
	echo "<tr>";
	echo "<td>Match</td>";
	echo "<td>Pred.</td>";
	echo "<td>Rst.</td>";		
	echo "</tr>";
	while ($row=fetch_assoc($query))	{ ## loop through for each tipster
		

		##did tipster enter tip for FTR?
		if ($row['aftr']!="")	{ ## FTR not empty
			$_POST['total_ftr']++;
			###Check if FTR is correct for match
			if (($row['aftr']=='H') && ($row['ftr']=='1'))	{
				##record success
				$_POST['ftr_success']++;
			}
			elseif (($row['aftr']=='A') && ($row['ftr']=='2'))	{
				##record success
				$_POST['ftr_success']++;
			}			
			elseif (($row['aftr']=='D') && ($row['ftr']=='1X'))	{
				##record success
				$_POST['ftr_success']++;
			}
			elseif (($row['aftr']=='D') && ($row['ftr']=='X2'))	{
				##record success
				$_POST['ftr_success']++;
			}	
			elseif (($row['aftr']=='H') && ($row['ftr']=='1X'))	{
				##record success
				$_POST['ftr_success']++;
			}	
			elseif (($row['aftr']=='A') && ($row['ftr']=='X2'))	{
				##record success
				$_POST['ftr_success']++;
			}							
			else {
				##Miss
			}		
		}
		
		##echo matches
		echo "<tr><td>".$row['hometeam'] ."-". $row['awayteam'] ."</td><td>". $row['ftr'] ."</td><td>". $row['aftr']."</td></td></tr>";
		##did tipster enter tip for Match Goal 2.5?
		if ($row['mg']!="")	{ ## MG2.5 not empty
			$_POST['total_goal25']++;
			###Check if MG2.5 is correct for match
			if ($row['mg']==$row['goal25'])	{
				##record success
				$_POST['goal25_success']++;
			}
			else	{
				#echo "Shuuuuu!!!";
			}
		}	
		
		##did tipster enter tip for BTTS?
		if ($row['btts']!="")	{ ## BTTS not empty
			$_POST['total_btts']++;
			###Check if MG2.5 is correct for match
			if ($row['btts']==$row['abtts'])	{
				##record success
				$_POST['btts_success']++;
			}
			else	{
				#echo "Shuuuuu!!!";
			}
		}		
		
		##did tipster enter tip for Goals Odd/Even
		if ($row['oddeven']!="")	{ ## BTTS not empty
			$_POST['total_oddeven']++;
			###Check if MG2.5 is correct for match
			if ($row['oddeven']==$row['aoddeven'])	{
				##record success
				$_POST['oddeven_success']++;
			}
			else	{
				#echo "Shuuuuu!!!";
			}
		}			
		##did tipster enter tip for Correct score?
		if (($row['fsh']!="") && ($row['fsa']!=""))	{ ## Score not empty
			$_POST['total_score']++;
			###Check if Scores is correct for match
			if (($row['fsh']==$row['ahts']) && ($row['fsa']==$row['aats']))	{
				##record success
				$_POST['score_success']++;
			}
			else	{
				#echo "Shuuuuu!!!";
			}
		}
					
	} ## while stats
	echo "</table>";
/*	echo "Tipster: ". $_POST['tipster'];	
	echo "<br />";	
	echo "FTR Success:". $_POST['ftr_success'];
	echo "<br />";
	echo "Total FTR Tips:".$_POST['total_ftr'];*/
	echo "<br /><hr />";
	echo "<div align=center><strong>Total FTR win rate:".@number_format((($_POST['ftr_success']/$_POST['total_ftr'])*100),2)."</strong></div>";
	echo "<br /><hr />";	
/*	echo "<br />";	
	echo "Goal 2.5 Success: ".$_POST['goal25_success'];
	echo "<br />";
	echo "Total Goal 2.5 Tips: ".$_POST['total_goal25'];
	echo "<br />";	
	echo "Correct Score Success: ". $_POST['score_success'];
	echo "<br />";
	echo "Total Score Tip: ". $_POST['total_score'];
	echo "<br />";	
	echo "Total BTTS Tip: ". $_POST['total_btts'];
	echo "<br />";	
	echo "Correct BTTS Tip: ". $_POST['btts_success'];
	echo "<br />";		
	echo "Total OddEven Tip: ". $_POST['total_oddeven'];
	echo "<br />";	
	echo "Correct OddEven Tip: ". $_POST['oddeven_success'];
	echo "<br />";				
	$_POST['stat_date']=today();*/
	

} ## ?>

</div>
<div align="center">
<img src="../application/assets/img/bet365_160x600.gif" alt="betAds" />
</div>