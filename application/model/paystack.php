<?php
if (isset($_POST['makepay']))	{
			
$customer=db_value(bp_users,email_id,tipster,$_SESSION['whoId'],$conn);
$reference=uniqid().strtotime(date("Ymd his"));
$tranx_date=date("Y-m-d h:i:s");
$amount_due=($_POST['amount']+100)*100;
$secret_key='sk_test_d0bc8ad957ccbf4e4874e6e1edd84dfbb8a6f125';

###Insert predata into DB
$insert="INSERT into bp_paystack set email_id='".$customer."', bp_ref='".$reference."', tranx_date='".$tranx_date."', amount_due='".$amount_due."'";
$qinsert=mysql_query($insert);

	if ($qinsert) { ##insert is true goto paystack

		?>
		<html>
			<body onLoad="document.submit2gtpay_form.submit()">
			<form name="submit2gtpay_form" action="http://primaxng.com/paystack/paygo.php" target="_self" method="post">
				<input type="hidden" name="customer" value="<?=$customer;?>">
				<input type="hidden" name="reference" value="<?=$reference;?>">
				<input type="hidden" name="tranx_date" value="<?=$tranx_date;?>">
				<input type="hidden" name="amount_due" value="<?=$amount_due;?>">
				<input type="hidden" name="secret_key" value="<?=$secret_key;?>">
				<input type="hidden" name="betp_key" value="8809">																				
			</form>
			</body>
		</html>
		<?php
		}
		else {
			$errorCode=3;
			$errorMsg="Payment could not be Processed";
		}
	
}


?>