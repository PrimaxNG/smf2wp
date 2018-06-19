<?php
include "../application/controller/msgssf.php"; 
## check profiles
if (isset($_POST['submit_slip']))	{

	$exist=exist_b4(bp_users,tipster,$_POST['tipster']);
	if ($exist<=0) { ## Does tipster exist?
		$errorCode=3;		
		$errorMsg = "Tipster ".$_POST['tipster']." does not exist";		
	}
	else { ## Tipster Exist
		## Check if payment record already exist
		$sql="select * from bp_bettingslip where tipster='".$_POST['tipster']."' and betslip='".$_POST['betslip']."'";
		$query=mysql_query($sql);
		$counter=counter($query);
		if ($counter<=0)	{ ## payment record does not exist, insert it
			$insert=insert_all('bp_bettingslip');
			if ($insert) { ## Update wallet Balance
				$errorCode=1;		
				$errorMsg = "Betslip Information Added Successfully";				
			}
			
		}
		else { ##record exist
			$errorCode=3;		
			$errorMsg = "Betslip Details Already Exist";				
		}
	}
} ## end if submitpay


#### retrieve betslips for history
$sql10="select * from bp_bettingslip where match_date <='".today()."' order by match_date DESC limit 1,20";
$query10=mysql_query($sql10);

#### retrieve betslips for upcoming
$sql10="select * from bp_bettingslip where match_date >='".today()."' order by match_date DESC limit 1,20";
$query10=mysql_query($sql10);

?>