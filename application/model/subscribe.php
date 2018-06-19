<?php
## check profiles
if (isset($_POST['confirm']))	{
$result = mysql_query("select tipster,sub_status from bp_subscribe where tipster= '".$_SESSION['whoId']."' and sub_status='1'");
### check if account has an active subscription
	if (counter($result)<1)	{ ## no subscription
	##Check for Free Subscription
	if ($_POST['sub1']=="free")	{
		$result3 = mysql_query("select tipster,sub_status,sub_type from bp_subscribe where tipster= '".$_SESSION['whoId']."' and sub_type='free'");
		if (counter($result3)>=1) {
			 $errorCode=3;		
			 $errorMsg = "Hello ".$_SESSION['whoId'].", you have already used your Free 
			 Subscription, Kindly select a paid subscription. Thank You";
		}
		else { ##Activate Free Subscription
			$_POST['tipster']=$_SESSION['whoId'];
			$_POST['sub_type']=$_POST['sub1'];
			$_POST['date_sub_sub']=today();
			$_POST['sub_status']="1";
			$_POST['confirmation']="1";				
			$_POST['amt_due']=sub_price($_POST['sub_type']);
			$_POST['invoice_no']= "BP".date("md").rand(101,9999);
			$_POST['date_sub_active']=today();
			$_POST['date_sub_end']= date("Y-m-d", strtotime('+1 week'));
			
			$insert=insert_all(bp_subscribe);
			echo "<meta http-equiv='Refresh' content='1; URL=?vha=6_10&i=".$_POST['invoice_no']=#Invoice'>";
			header("location: ?vha=6_10&i=".$_POST['invoice_no']."&t=".$_POST['sub_type']."#Invoice");					
		}
		
	}
	else { ## not free subs
	
	#######Check waalet for enough balance to activate sub
		$_POST['sub_type']=$_POST['sub1'];
		$wallet=@db_value('bp_users','wallet','tipster',$_SESSION['whoId']);
		$bonus=@db_value('bp_users','wallet_bonus','tipster',$_SESSION['whoId']);		
		$_POST['amt_due']=sub_price($_POST['sub_type']);
		$totalwallet=($wallet+$bonus);
		if ($totalwallet<$_POST['amt_due']) { ## Not ENough Funds
			 $errorCode=3;		
			 $errorMsg = "Hello ".$_SESSION['whoId'].", you do not have enough funds to subscribe for the ".$_POST['sub1']." predictions. Kindly top up your wallet";			
		}
		else { ## there  is enough funds
			###calculate bonus ish
			$bminus=($bonus-$_POST['amt_due']);
			if ($bminus<0) {
				$walletbonus=0;
				$walletbalance=($wallet-(abs($bminus)));				
			}
			else {
				$walletbonus=$bminus;
				$walletbalance=($wallet+(abs($bminus)));								
			}

			$updwallet=mysql_query("UPDATE bp_users set wallet='".$walletbalance."',wallet_bonus='".$walletbonus."' where tipster='".$_SESSION['whoId']."'");
			########log into bp_wallet
			$_POST['tipster']=$_SESSION['whoId'];
			$_POST['balance_b4']=$wallet;
			$_POST['bonus_b4']=$bonus;
			$_POST['balance_afta']=$walletbalance;
			$_POST['bonus_afta']=$walletbonus;
			$_POST['pay_date']=today();
			$_POST['amt_paid']="-".$_POST['amt_due'];
			$_POST['pay_desc']="Subscription for ".$_POST['sub_type'];
			$insert=insert_all('bp_wallet');		
			######insert into subscription table
			#$_POST['tipster']=$_SESSION['whoId'];
			$_POST['sub_type']=$_POST['sub1'];
			$_POST['date_sub_sub']=today();
			$_POST['sub_status']="1";
			$_POST['confirmation']="1";			
			$_POST['amt_due']=sub_price($_POST['sub_type']);
			$_POST['invoice_no']= "BP".date("md").rand(101,9999);
			$_POST['date_sub_active']=today();
			$_POST['amt_paid']=$_POST['amt_due'];
			$_POST['date_sub_end']= date("Y-m-d", strtotime(days_to_add ($_POST['sub_type'])));			
			$insert=insert_all(bp_subscribe);
			
			#echo "<meta http-equiv='Refresh' content='1; URL=?vha=6_6&i=".$_POST['invoice_no']."#Invoice>";
			header("location: ?vha=6_4&i=".$_POST['invoice_no']."&t=".$_POST['sub_type']."#Invoice");			

		}

		
	  } ## end of free check
	  
	}
	else	{ ## there is an active subscription
		 $errorCode=3;		
		 $errorMsg = "Hello ".$_SESSION['whoId'].", you have an active Subscription. You cannot have dual subscription. Kindly contact support on +2348062741555";
	}
} ##end confirm sub
?>

<?php
if (isset($_POST['search']))	{
	$qinvoice=mysql_query("select invoice_no,tipster,confirmation,sub_type,amt_due from bp_subscribe where invoice_no like  '".$_POST['invoice_no']."%'");
	if (counter($qinvoice)<1)	{
			 $errorCode=3;		
			 $errorMsg = "No Invoice Found";		
	}
	else {
		$list=1;
	}
}

?>
<?php
if (isset($_POST['confirm2']))	{
	$qinv=mysql_query("select invoice_no,tipster,confirmation from bp_subscribe where invoice_no =  '".$_POST['inv']."' and tipster='".$_POST['tipster']."' and confirmation=1");
	if (counter($qinv)>=1)	{
			 $errorCode=3;		
			 $errorMsg = "This Payment has already been confirmed - Tell Customer to Activate
			  Subscription";		
	}
	else {
		if (!$_POST['tipster'])	{
			 $errorCode=3;			
			 $errorMsg = "Error: Cannot process Confirmation";
		}
		else {
			$list=1;
			##Update
			$update=mysql_query("update bp_subscribe set confirmation=1,amt_paid='".$_POST['amt_paid']."',payment_details='".$_POST['payment_details']."' where tipster='".$_POST['tipster']."' and invoice_no='".$_POST['inv']."'");
			if ($update) { 
				 $errorCode=3;			
				 $errorMsg = "Payment Confirmation Successful";
			}
		}		
	}
}

?>

<?php
if (isset($_POST['activatesub']))	{
	$select=mysql_query("select * from bp_subscribe where invoice_no='".$_POST['inv']."'");
	$row=fetch_assoc($select);
	
	$select2=mysql_query("select tipster,sub_status from bp_subscribe where sub_status=1 and tipster='".$_SESSION['whoId']."'");
	$row2=fetch_assoc($select2);	


	if ($row['amt_paid']<$row['amt_due'])	{
		$errorCode=3;			
		$errorMsg = "Subscription Cannot be Activated. Payment not Complete";	
	}
	elseif (counter($select2)>=1)	{
		$errorCode=3;			
		$errorMsg = "You have an active Subscription. You cannot have Dual Activation. Kindly wait till your present Subscription is over to activate this new Subscription.";
	}
	else { #Activate this Sub
		$days_to_add=days_to_add($row['sub_type']);
		$adddays=date("Y-m-d", strtotime($days_to_add));
		$update=mysql_query("UPDATE bp_subscribe set sub_status=1,date_sub_active='".today()."',date_sub_end='".$adddays."' where invoice_no='".$_POST['inv']."' and tipster='".$_SESSION['whoId']."'");
		$errorCode=1;			
		$errorMsg = "Congrats!!! Your new Subscription is now ACTIVE";		
	}


}
?>
<?php
############surebet.php Back to select bet_type
if (isset($_POST['back']))	{
	header("location: ?vha=6_4#view_surebet");
}

?>