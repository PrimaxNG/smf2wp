<?php 
#include ("../application/control/headstart.php");
#include ("../application/control/functions.php");
#include ("../application/control/conn.php");
?>
<?php
$queryme=mysql_query("select tipster,sub_status from bp_subscribe where tipster='".$_SESSION['whoId']."' and sub_status=1");
if (counter($queryme)<1) { ## no valid subscription
	header("location: ?vha=6_7#noSubscription");
}

if (isset($_GET['i'])) {
$queryme2=mysql_query("select tipster,invoice,sub_status from bp_subscribe where tipster='".$_SESSION['whoId']."' and invoice_no='".$_GET['i']."'");
	if (counter($queryme2)<1) { ## no valid subscription
		header("location: ?vha=6_4#noSubscription");
	}
	else {
		header("location: ?vha=6_1#noSubscription");
	}
}

?>