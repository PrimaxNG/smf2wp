<?php
if (isset($_POST['select_league']))	{
	header ("location: ?vha=2_2&league=".$_POST['league']."&num=".$_POST['num']."");
}

?>
