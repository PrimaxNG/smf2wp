<?php 
include ("../control/headstart.php");
include ("../control/functions.php");
include ("../control/conn.php");
?>
<?php

if(!$_POST['page']) die("0");

#$page = (int)$_POST['page'];

$page = substr($_POST['page'],1);
#echo $sql="select * from bp_match where division='".$page."'";
$result = mysql_query("SELECT * FROM bp_match where league='".$page."'"); 
	while ($row=mysql_fetch_assoc($result))	{
	$json= date_convert($row['matchdate'],11) ." (".$row['matchtime'].") | ".$row['hometeam'] . " VS " . $row['awayteam']."";
	?>
	<div class="row">
	  <div class="col-md-8">
		<div class="input-group">
		  <span class="input-group-addon">
			<input name="<?=$row['id'];?>" type="checkbox" value="<?=$row['id'];?>">
		  </span>
		  <input name="submit" type="button" class="form-control btn btn-primary" id="submit" value="<?php echo $json; ?>" /> 
		</div><!-- /input-group -->
	  </div>
	</div><!-- /.row -->
	<?php
	} ##end while
#echo $_SESSION['week'];
?>
