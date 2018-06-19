<?php
##function to send message
function sendmsg($mobile,$message)	{
	
$username="mcode";
$password = "mcode";
$type ="text";
$sender="betpredict";
$baseurl ="http://api.smsbag.com/api/v3/sendsms/plain";
$url=$baseurl."?user=".$username."&password=".$password."&sender=".$sender."&GSM=".$mobile."&SMSText=".$message;
// do send message call
/*$return = file($url);

echo '<?php $return = ' . var_export($return, true) . ';';

$string_data = serialize($return);
file_put_contents("smsbag140915020212.xml", $string_data);*/

$header = array("Accept: application/json");
//URL of targeted site  
$ch = curl_init();  

// set URL and other appropriate options  
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// grab URL and pass it to the browser  

$retValue = curl_exec($ch);
#$response = json_decode(curl_exec($ch));
$ee       = curl_getinfo($ch);
#print_r($ee);

#print_r($retValue);

#echo $output;

// close curl resource, and free up system resources  
curl_close($ch);

return $retValue;
}

?>