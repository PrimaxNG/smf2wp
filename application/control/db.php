<?php
## Database Connection function
?>
<?php
## MySQL function connect : To connect Application to a Database
## $host = hostname or IP of database
## $port = database port default 3306 IP of database
## $user = Database User e.g root
## $pass = Database user Password
## $db = Database Name to be connected to

function connect($host, $port, $user, $pass, $db) {
	//merge hostname and port e.g localhost:3306
	$host=$host.":".$port;
	## Using the mysql_connect function to connect to DB..could also use mysql_pconnect 
	$cnx = mysql_connect($host,$user,$pass);
	## selecting the required database for the application
	$dbx = mysql_select_db($db);
	##Check if db is connected
	/*if ($cnx)
		echo 'Database Connection  Possible';
	if (!$cnx)
		echo 'Database Connection Not Possible';
	if ($dbx)
		echo 'Application Database selected';
	if (!$dbx)
		echo 'Application Database not selected';*/
	return $cnx;	
}
?>