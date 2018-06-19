<?php
## Controller Script for placebet Page - /bets/placebet.php/
date_default_timezone_set("Africa/Lagos");
?>
<?php
##$week= $weekcheck['current_week'];
if (isset($_GET['l'])) {
	$week=find_match_week($_GET['l'],today());
	$display=1;
}
else {
	$week=find_match_week("e0",today());
	$display=1;
}
?>
<?php
if (isset($_POST['select_country']))	{
	header ("location: ?vha=5_2&league=".$_POST['league']."");
}

?>
