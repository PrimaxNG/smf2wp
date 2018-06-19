<?php
include "../application/controller/msgssf.php"; 
## check profiles
if (isset($_POST['submitpay']))	{
	if ( ($_POST['tipster']=="") && ($_POST['email_id']!="") ) {
		$_POST['tipster']=db_value("bp_users","tipster","email_id",$_POST['email_id']);
	}
	$exist=exist_b4(bp_users,tipster,$_POST['tipster']);
	if ($exist<=0) { ## Does tipster exist?
		$errorCode=3;		
		$errorMsg = "Tipster ".$_POST['tipster']." does not exist";		
	}
	else { ## Tipster Exist
		## Check if payment record already exist
		echo $sql="select * from bp_wallet where tipster='".$_POST['tipster']."' and pay_date='".$_POST['pay_date']."' and amt_paid='".$_POST['amt_paid']."'";
		$query=mysql_query($sql);
		$counter=counter($query);
		if ($counter<=0)	{ ## payment record does not exist, insert it
			$_POST['balance_b4']=@db_value('bp_users','wallet','tipster',$_POST['tipster']);
			$_POST['bonus_b4']=@db_value('bp_users','wallet_bonus','tipster',$_POST['tipster']);
			$_POST['balance_afta']=$_POST['balance_b4']+$_POST['amt_paid'];
			$bonus=(($_POST['bonus']/100) * $_POST['amt_paid']);
			$_POST['bonus_afta']=($bonus+$_POST['bonus_b4']);
			#$_POST['email_id']=$_POST['tipster'];
			$insert=insert_all('bp_wallet');
			if ($insert) { ## Update wallet Balance
				$update=mysql_query("UPDATE bp_users set wallet='".$_POST['balance_afta']."',wallet_bonus='".$_POST['bonus_afta']."' where tipster='".$_POST['tipster']."'");
				###Send payment Confirmation SMS
				$message="Your+Payment+of+N".$_POST['amt_paid']."+is+confirmed+and+your+betpredict+wallet+has+been+credited";
				$_POST['mobile']=@db_value('bp_users','mobile','tipster',$_POST['tipster']);				
				$sendmsg=sendmsg($_POST['mobile'],$message);				
				$errorCode=1;		
				$errorMsg = "Payment Details Inserted Successfully:::"."b4::".$_POST['balance_b4']."- Afta::".$_POST['balance_afta'];				
			}
			
		}
		else { ##record exist
			$errorCode=3;		
			$errorMsg = "Payment Details Already Exist";				
		}
	}
} ## end if submitpay


?>