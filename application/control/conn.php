<?php
## Application  DB Connection 
include ("db.php");
?>
<?php
## MySQL Connection Parameters
$db_server = 'localhost';
$db_port = '3306';
$db_name = 'bpdb';
$db_user = 'root';
$db_password = '';
?>
<?php
## Connect using the connect db function
$conn = connect($db_server,$db_port,$db_user,$db_password,$db_name);
?>