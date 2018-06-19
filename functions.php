<?php 
/*
Database Reusable Function Scripts written By 
Obembe Olutola Michael
Primax Technologies Limited
General Resuable Line of Codes (Queries)
01/11/2007 - 02/11/2007

Note: This Script is licensed under the GNU Licence 
this section must be left untouched
*/
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

function br() {
	echo '<br>';
}


function fields($table) {
	//select table
	$res = mysql_query("SELECT * FROM $table");
	return $res;
}

//function for select query with where clause
function sel_query($table,$field,$where,$value) {
	//select table
	$res = mysql_query("SELECT $field FROM $table WHERE $where='$value'");
	return $res;
}

// function to pick a db value for a field
function db_value($table,$field, $where,$value)	{
	if (empty($where))	{
		$query = @mysql_query("select $field from $table");
	}
	else{
		$row="select $field from $table where $where='$value'";
		$query = @mysql_query($row);
	}
	
	$row= fetch_assoc($query);
	return $row[$field];
}

// function to pick a db value for a field
function db_value_where($table,$field, $where)	{
	if (empty($where))	{
		$query = @mysql_query("select $field from $table");
	}
	else{
			##echo "select $field from $table where $where";
		$query = @mysql_query("select $field from $table where $where");
	}
	
	$row= fetch_assoc($query);
	return $row[$field];
}

function field_num($result) {
	//get number of table fields
	$num_fields= mysql_num_fields($result); 
	return $num_fields;
}


function value($array) {

	for ($c=0; $c<=count($array); $c++) {
		echo $array[$c];
		
	}
}


function value_arg() {

	$numargs = func_num_args();
	//echo $numargs;
	$arr = func_get_arg(0);
	for ($c=0; $c<=count($arr); $c++) {
		echo $arr[$c];
		br();
	}
}


function field_name($ssql) {
	//get name of fields
		$num_f = mysql_num_fields($ssql);
		
		for ($n = 0; $n<=$num_f; $n++) {
			//declare array list
			$array_list[$n] = @mysql_field_name($ssql, $n);
		}
		return $array_list;
}

// function to insert all fields in a table: argument is the table name
function insert_all($table_tab) {

	//echo fields(reports); br();
	$totalfield = field_num(fields($table_tab)); 
	// list array list (for table fields)
	$arrayfield = field_name( fields( $table_tab ) );

	$total_field = $totalfield;
	/*echo $total_field;*/
	/*value($arr_field);*/
	$arr_field = $arrayfield;
	//$q = "INSERT INTO TABLE SET field1='$field1', field2='$field2'";
		// build insertion field
		$ssql_field_set = "SET ";
		for ($nf = 1; $nf <= ($total_field - 1); $nf++) {
			
			$ssql_field.=  ",";
			$ssql_field.= $arr_field[$nf] ."=";
			$ssql_field.= "'";
			$ssql_field.= $_POST[$arr_field[$nf]];
			$ssql_field.= "'";
		}
		
		$ssql_field = $ssql_field_set . substr($ssql_field,1);
		$sql_str = "INSERT INTO $table_tab $ssql_field";
		$sql_query = @mysql_query($sql_str) or die(mysql_error());

		if ($sql_query)
			$msg =  'Record Successfully Inserted for All Fields';
		if (!$sql_query)
			$msg =  'Invalid Query';
	//$query = mysql_query("") or die('Insertion error'. mysql_error());
	return $msg; 
}


/*//function to insert into selected fields in a table
Use:
1. Create an array list of posted variable and send with the table name to function
e.g 
//create arraylist for posted variable to be inserted
	$posted_var[2]= 'startpage';
	$posted_var[3]= 'keywords';
2. Then call the function. like : $output = insertion (config, $posted_var);*/

function insert_selected($table_tab, $posted_var) {

	//echo fields(reports); br();
	$total_field = field_num(fields($table_tab)); 
	// list array list (for table fields)
	$arr_field = field_name( fields( $table_tab ) );

		// build insertion field
		$ssql_field_set = " SET ";
		for ($nf = 1; $nf <= ($total_field - 1); $nf++) {
			
			if (isset($posted_var[$nf]) ) {
				
				$ssql_field.=  ",";
				$ssql_field.= $arr_field[$nf] ."=";
				$ssql_field.= "'";
				$ssql_field.= $_POST[$arr_field[$nf]];
				$ssql_field.= "'";
			
			}
			else	{
			
				//
			}
		}
		
		$ssql_field = $ssql_field_set . substr($ssql_field,1);
		$sql_str = "INSERT INTO $table_tab $ssql_field";
		$sql_query = mysql_query($sql_str) or die(mysql_error());

		if ($sql_query)
			$msg =  'Record Successfully Inserted for Selected Fields';
		if (!$sql_query)
			$msg =  'Inavlid Query';
	//$query = mysql_query("") or die('Insertion error'. mysql_error());
	return $msg; 
}

//updating selected fields
//parameters (1=>table, 2=>field array, 3=>where field (ARRAY POINT), 4=>check value)

function update_selected($table_tab, $posted_var, $where_field, $value) {

	//echo fields(reports); br();
	$total_field = field_num(fields($table_tab)); 
	// list array list (for table fields)
	$arr_field = field_name( fields( $table_tab ) );
	
	//print where field
	/*echo $where_field; br();*/
		// build updation field
		$ssql_field_set = " SET ";
		for ($nf = 1; $nf <= ($total_field - 1); $nf++) {
			
			if (isset($posted_var[$nf]) ) {
				
				
				$ssql_field.=  ",";
				$ssql_field.= $arr_field[$nf] ."=";
				$ssql_field.= "'";
				$ssql_field.= $_POST[$arr_field[$nf]];
				$ssql_field.= "'";

			}
			else	{
			
				//
			}
			
		}
		
		$ssql_field = $ssql_field_set . substr($ssql_field,1);
		$where = " WHERE $where_field='$value'"; 
		$sql_str = "UPDATE $table_tab $ssql_field $where";
		$sql_query = @mysql_query($sql_str); #or @die(mysql_error());

		if ($sql_query)
			#$msg =  'Record Successfully Updated for Selected Fields';
			$msg=0;
		if (!$sql_query)
			#$msg =  'Invalid Update Query';
			$msg=1;
	//$query = mysql_query("") or die('Updation error'. mysql_error());
	return $msg; 
}

//function to update all fields
//example 
	/*$posted = 'ID'; $value = 1;
	$output = update_all(config, $posted, $value);*/
	
function update_all($table_tab, $where_field, $value) {

	//echo fields(reports); br();
	$total_field = field_num(fields($table_tab)); 
	// list array list (for table fields)
	$arr_field = field_name( fields( $table_tab ) );
	
	//print where field
	/*echo $where_field; br();*/
		// build insertion field
		$ssql_field_set = " SET ";
		for ($nf = 1; $nf <= ($total_field - 1); $nf++) {
			
				$ssql_field.=  ",";
				$ssql_field.= $arr_field[$nf] ."=";
				$ssql_field.= "'";
				$ssql_field.= $_POST[$arr_field[$nf]];
				$ssql_field.= "'";
				
		}
		
		$ssql_field = $ssql_field_set . substr($ssql_field,1);
		$where = " WHERE $where_field='$value'"; 
		$sql_str = "UPDATE $table_tab $ssql_field $where";
		$sql_query = mysql_query($sql_str) or die(mysql_error());

		if ($sql_query)
			$msg =  'Record Successfully Updated for All Fields';
		if (!$sql_query)
			$msg =  'Inavlid Query';
	
	//return message
	return $msg; 
}

//function to delete a row record
/*example 
$var = 'ID';$val = '3';
$output = delete(config, $var, $val);
echo $output;*/

function delete($table_tab, $where_field, $value) {

	//echo fields(reports); br();
	$total_field = field_num(fields($table_tab)); 
	// list array list (for table fields)
	$arr_field = field_name( fields( $table_tab ) );

		$where = " WHERE $where_field='$value'"; 
		$sql_str = "DELETE FROM $table_tab $ssql_field $where";
		$sql_query = mysql_query($sql_str) or die(mysql_error());

		if ($sql_query)
			$msg =  'Record Successfully Deleted ';
		if (!$sql_query)
			$msg =  'Inavlid Query';
	
	//return message
	return $msg; 
}

/*// function to display a list menu with db values
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field($table, $name, $field, $known_value, $class)	{

	$query = mysql_query("SELECT $field FROM $table") or die("Inavlid Field Select Query". 
	mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- choose $name - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$field]==$known_value ) {
		
			echo "<option value='". $rows[$field] ."' selected=SELECTED>" . $rows[$field] ."</option>";br();
		}
		else	{
		
			echo "<option value='". $rows[$field] ."'>" . $rows[$field] ."</option>";br();
		}
		
		
	}
	echo "</select>";

}

/*// function to display a twin list menu with db values
use: function contains 5 parameters
1=> table name; 
2=> name of list menu 
3=>First field name to display from db 
4=>Second Field to Concatinate
4=>[Optional] default selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_twin_name($table, $name, $f1,$f2,$id,$known_value, $class)	{

	$query = mysql_query("SELECT $id,$f1,$f2 FROM $table ORDER by $f1 ASC") or die("Invalid Field Select Query".
	mysql_error());

	echo "<select name=$name id=$name class=$class onchange=\"showMatch(this.value)\">";
	echo "<option>- choose $f2 - </option>";
	while ($rows=mysql_fetch_assoc($query)) {

		if ( $rows[$id]==$known_value ) {
		
			echo "<option value='". $rows[$id] ."' selected=SELECTED>" . $rows[$f1].' - '.$rows[$f2] ."</option>";br();
		}
		else	{
		
			echo "<option value='". $rows[$id] ."' >" . $rows[$f1].' - '.$rows[$f2] ."</option>";br();
		}
		
		
	}
	echo "</select>";

}

/*// function to display a twin list menu with db values
use: function contains 5 parameters
1=> table name; 
2=> name of list menu 
3=>First field name to display from db 
4=>Second Field to Concatinate
4=>[Optional] default selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_twin_cat($table, $name, $id, $f1,$f2, $known_value, $class)	{

	$query = mysql_query("SELECT $id,$f1,$f2 FROM $table order by $f1 ASC") or die("Inavlid Field Select Query". 
	mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- choose $name - </option>";
	while ($rows=mysql_fetch_assoc($query)) {

		if ( $rows[$id]==$known_value ) {
		
			echo "<option value='". $rows[$id] ."' selected=SELECTED>" . strtoupper($rows[$f1].'-'.$rows[$f2]) ."</option>";br();
		}
		else	{
		
			echo "<option value='". $rows[$id] ."' >" . strtoupper($rows[$f1].'-'.$rows[$f2]) ."</option>";br();
		}
		
		
	}
	echo "</select>";

}

## select while with resource has values
function select_field_resource($query,$table, $name, $field, $known_value, $class)	{

 	echo "<select name=$name id=$name class=$class size=4>";
	//echo "<option>- choose $name - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$field]==$known_value ) {
		
			echo "<option value='". $rows[$field] ."' selected=SELECTED>" . $rows[$field] ."</option>";
		}
		else	{
		
			echo "<option value='". $rows[$field] ."'>" . $rows[$field] ."</option>";
		}
		
		
	}
	echo "</select>";

}

/*// function to display a list menu with db values with values different from label
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_value($table, $name, $field, $value ,$known_value, $class)	{

	$query = mysql_query("SELECT * FROM $table order by $field ASC") or die("Invalid Valued Field Select Query". mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- select - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$value]==$known_value ) {
		
			echo "<option value='". $rows[$value] ."' selected=SELECTED>" . $rows[$field] ."</option>"; br();
		}
		else	{
		
			echo "<option value='". $rows[$value] ."'>" . $rows[$field] ."</option>";br();
		}
		
		
	}
	echo "</select>";

}
/*// function to display a list menu with db values with where clause
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_where($table, $name, $field, $known_value, $class,$where,$value)	{

	$sql = "SELECT $field FROM $table WHERE $where = '$value' ORDER by $field ASC" ;
	$query=mysql_query($sql) or die("Invalid Field Select Query". mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- select - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$field]==$known_value ) {
		
		  echo "<option value='". $rows[$field] ."' selected=SELECTED>" . $rows[$field] ."</option>";
		}
		else	{
		  echo "<option value='". $rows[$field] ."'>" . $rows[$field] ."</option>";
		}
	}
	echo "</select>";

}

  #### how many contacts\
	function howmanycontacts($eid,$gid)	{
		$howcontact=mysql_query("select count(*) as howmany from addressbook where eid='".$eid."' and gid='".$gid."'");
		$rcontact=fetch_assoc($howcontact);
		return $rcontact['howmany'];
	}
	
	  #### how many total contacts\
	function totalcontacts($eid)	{
		$howcontact=mysql_query("select count(*) as howmany from addressbook where eid='".$eid."' ");
		$rcontact=fetch_assoc($howcontact);
		return $rcontact['howmany'];
	}
	
		  #### how many total contacts\
	function uncategorized($eid)	{
		$howcontact=mysql_query("select count(*) as howmany from addressbook where eid='".$eid."' and gid=0");
		$rcontact=fetch_assoc($howcontact);
		return $rcontact['howmany'];
	}
	
/*// function to display a list menu with db values with where clause
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_where_value($table, $name, $field, $id, $known_value, $class,$where,$value)	{

	$query = mysql_query("SELECT $id,$field FROM $table WHERE $where = '$value' ") or die("Invalid Field Select Query". mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- select - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$id]==$known_value ) {
		
		  echo "<option value='". $rows[$id] ."' selected=SELECTED>" . $rows[$field] ."</option>";
		}
		else	{
		  echo "<option value='". $rows[$id] ."'>" . $rows[$field] ."</option>";
		}
	}
	echo "</select>";

}

/*// function to display a list menu with db values with where clause
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_where_empty($table, $name, $field, $known_value, $class,$where,$value)	{

	$query = mysql_query("SELECT $field FROM $table WHERE $where != '$value' ") or die("Invalid Field Select Query". 
	mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- select - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$field]==$known_value ) {
		
			echo "<option value='". $rows[$field] ."' selected=SELECTED>" . $rows[$field] ."</option>";
		}
		else	{
		
			echo "<option value='". $rows[$field] ."'>" . $rows[$field] ."</option>";
		}
		
		
	}
	echo "</select>";

}

/*// function to display a list menu with db values with where clause
use: function contains 4 parameters
1=> table name; 
2=> name of list menu 
3=>field name to display from db 
4=>[Optional] defaut selected value for the list menu
5=>[Otional] Style Class for the list menu*/

function select_field_where_empty2($table, $name, $field, $known_value, $class,$where,$value,$val2)	{

	$query = mysql_query("SELECT $field FROM $table WHERE $where != '$value' and $where!= '$val2' order by $field asc ") or die("Invalid Field Select Query". 
	mysql_error());
	
	echo "<select name=$name id=$name class=$class>";
	//echo "<option>- select - </option>";
	while ($rows=mysql_fetch_assoc($query)) {
	
		if ( $rows[$field]==$known_value ) {
		
			echo "<option value='". $rows[$field] ."' selected=SELECTED>" . $rows[$field] ."</option>";
		}
		else	{
		
			echo "<option value='". $rows[$field] ."'>" . $rows[$field] ."</option>";
		}
		
		
	}
	echo "</select>";

}

// function to return message reply
function message($resource)	{

	if ($resource) {
	
		$msg = 'Operation Successful';
	}
	else	{
	
		$msg = 'Operation Unsuccessful';
	}
	return $msg;
}

//function to control while loops for fields data
/*
example: use br if you want a break line for seperation
parameters 1=> resource query, 2=> field name topull from db 3=> optional seperation symbol
$symbol = 'br';
echo while_sel(fields(lga), Lga, $symbol);*/
function while_sel($resource, $field_name, $symbol) {
	
	$echo = '';
	while($row=mysql_fetch_assoc( $resource ) )	{
	
		if ($symbol=='br')	{
		
			$echo .= $row[$field_name];
			$echo .= '<br>';
		}
		else	{
			$echo .= '';
			$echo .= $row[$field_name];
			$echo .= $symbol . '';
		}
		
	}
	echo $echo;
	return $row;
}

// counter function=>to return numbers of rows fetched or found
function counter($resource)	{

	return @mysql_num_rows($resource);
}

// current page
function currentpage()	{

	$page = $_SERVER['PHP_SELF'];
	return $page;
}

//function for header location
// 2 parameters: 1=>page_name put within string tag e.g('index.php') [optional]2=>url variables
function location($page,$url_var)	{

	ob_end_clean();
	header("location: $page?$url_var");
}

// function to return resource array
function fetch_assoc($resource)	{

	$row = @mysql_fetch_assoc($resource);
	return $row;
}

//function to redirect if url variable is missing
function empty_url($url_var,$location) {

	if (empty($url_var)) {
	
		location('show_news.php');
	}
}

// function to dispaly todays date
function today()			{

	$today =  date("Y-m-d");
	return $today;

}

function todaytime()			{
	$today =  date("H:i");
	return $today;
}

function today_d($date)	{
	if ($date == today())	{
		$tod = "Today";
	}
	else	{
		$tod = $date;
	}
	
	return $tod;
}

// function to dispaly todays date
function today_time()			{

	 $today =  date("Y-m-d H:i:s");
	return $today;
}

// function to check for password validity and strlen
//parameters: the two password and validity length
//return is 0=true, 1 or 2 for errors=false
function  check_password($pass,$c_pass,$len)  {

		if ($pass!=$c_pass)		{
		
				$err = 1; // password not equal
		}
		else
		if (strlen($pass)<$len)		{
		
				$err = 2;
		}
		else	{
		
				$err = 0;
		}
		
		return $err;
}


//function to check existence of a valued variable
function exist_b4($table,$field,$value)		{
		
		$existed = @mysql_query("SELECT $field FROM $table WHERE $field='$value'");// or die('Invalid Exist 
		//Query'. mysql_error());
		
		$no = counter($existed) ;
		return $no;
	}

//function to check existence of a valued variable 2
function exist_where_b4($table,$field1,$field2,$value1,$value2)		{
		
		$existed = mysql_query("SELECT $field1 FROM $table WHERE $field1='$value1' and $field2='$value2' ") or die('Invalid Exist Query'. mysql_error());
		
		
		$no = counter($existed) ;
		return $no;
	}
//function to explode a variable and returns the array	
	function explod($value,$sym)		{
	
			$ex = explode($sym,trim($value));
			return $ex;
	}
	
##function to get add or subtract of date
/*$today = Todays Date
$change = Sub or Add expected e.g "-7 day", "+1 Month"
$date->format('Y-m-d');//2013-04-06
$date->modify('+4 year');
$date->modify('+6 day');*/

function datechange($today,$change)	{
	echo $start_date = $today;
	echo $date = DateTime::createFromFormat('Y-m-d',$start_date);
	
	$date->modify("-7 days");
	$newdate = $date->format('Y-m-d');//2013-04-06	
	
	return $newdate;
}


##greater time function, function to find if a date is graeter than present date
function greater_time($dat)
	{
		//explode date posted
		$explode = explode("-",$dat);
		//get year, month and day value from posted date
		$y = $explode[0];
		$m = $explode[1];
		$d = $explode[2];
		//get explode for birthday date
		 $bday = mktime(0, 0, 0, $m, $d, $y);
		//get explode for present date time
		$today = mktime();
		//get date time difference between times in seconds
		$agediv = floor(($today-$bday)/(24*3600));
		
		 return($agediv);
	}
	
	function no_of_days($dat1,$dat2)
	{
		//explode date posted
		$explode = explode("-",$dat1);
		$explode2 = explode("-",$dat2);
		//get year, month and day value from posted date
		$y = @$explode[0];
		$m = @$explode[1];
		$d = @$explode[2];
		##2nd date
		$y2 = @$explode2[0];
		$m2 = @$explode2[1];
		$d2 = @$explode2[2];
		//maketime for 1st date
		$day1 = @mktime(0, 0, 0, $m, $d, $y);
		//get explode for 2nd date time
		$day2 = @mktime(0, 0, 0, $m2, $d2, $y2);
		//get date time difference between times in seconds
		$diff = ($day2-$day1);
		$no_of_days= floor($diff / (24 * 60 * 60));
		return($no_of_days);
	}
##
	function no_of_years($dat1)
	{
		//explode date posted
		$explode = explode("-",$dat1);
		//get year, month and day value from posted date
		$y = $explode[0];
		//maketime for 1st date
		$today = explode ("-",today());
		$y1 = $today[0];
		//get date time difference between times in seconds
		$no_of_years= floor($y1 - $y); // / (24 * 60 * 60 * 7 * 4 * 12));
		return($no_of_years);
	}	
	
// dateadd($datestr, $num, $unit)
//    $datestr is a string that strtotime() is able to parse
//    $num is the number of units to add
//    $unit is either "Y", "m", "d", "H", "i", "s" as understood by date()
//    returns a UNIX timestamp of the resulting date
function dateadd($datestr, $num, $unit) {
       $units = array("Y","m","d","H","i","s");
       $unix = strtotime($datestr);
       while(list(,$u) = each($units)) $$u = date($u, $unix);
       $$unit += $num;
       return mktime($H, $i, $s, $m, $d, $Y);
}
// example: echo date("Y-m-d H:i:s", dateadd("2003-04-12", 5, "d"));

/*$log = login(tb_owner,vehicle_id,$_POST['vehicle_id'],password,$_POST['passwd'],state,$st)	;*/

function login($table,$id,$id_val,$pass,$pass_val,$st,$st_val)			{
			//
			
			$md5pass =  md5(mysql_real_escape_string($pass_val));
			$id_val = mysql_real_escape_string($id_val);
			
			$query = "SELECT $id, $pass FROM $table WHERE $id = '$id_val'  AND $pass = '$md5pass' AND $st='$st_val'";
			$result = @mysql_query($query)or die("Inavlid User Access Query".mysql_error());
				// if user exist
			$num = mysql_num_rows($result);
					
			return $num;
		}

//function for select query with where clause and order clause
function sel_query_order($table,$field,$where,$value,$orderval,$order) {
	//select table
	$res = mysql_query("SELECT $field FROM $table WHERE $where='$value' ORDER BY $orderval $order");
	return $res;
}

//function for select query with where clause and order clause
function sel_query_double($table,$field,$where,$value,$sec,$secval) {
	//select table
	$res = mysql_query("SELECT $field FROM $table WHERE $where='$value' AND $sec='$secval' ");
	$rel= fetch_assoc($res);
	return $rel[$field];
}

function date_convert($date,$type){
  $date_year=substr($date,0,4);
  $date_month=substr($date,5,2);
  $date_day=substr($date,8,2);
  $date_hour = 0;
  $date_min = 10;
  $date_sec = 10;
  if($type == 1):
  	// Returns the year Ex: 2003
  	$date=date("Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 2):
  	// Returns the month Ex: January
  	$date=date("F", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 3):
  	// Returns the short form of month Ex: Jan
  	$date=date("M", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 4):
  	// Returns numerical representation of month with leading zero Ex: Jan = 01, Feb = 02
  	$date=date("m", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 5):
  	// Returns numerical representation of month without leading zero Ex: Jan = 1, Feb = 2
  	$date=date("n", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 6):
  	// Returns the day of the week Ex: Monday
  	$date=date("l", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 7):
  	// Returns the day of the week in short form Ex: Mon, Tue
  	$date=date("D", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 8):
  	// Returns a combo ExL Wed,Nov 12th,2003
  	$date=date("D, M jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 9):
  	// Returns a combo Ex: November 12th,2003
  	$date=date("F jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 10):
  	// Returns a combo ExL Wed,Nov 12th,2003
  	$date=date("M jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 11):
  	// Returns a combo ExL Nov 12th,2003
  	$date=date("M jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 15):
  	// Returns a combo ExL Nov 12th,2003
  	$date=date("M jS", mktime(0,0,0,$date_month,$date_day,$date_year));	
  elseif($type == 16):
  	// Returns a combo ExL Nov 12th,2003
  	$date=date("d/m/Y", mktime(0,0,0,$date_month,$date_day,$date_year));		
  elseif($type == 14):
  	// Returns a combo ExL Nov 12th,2003
  	$date=date("jS M, Y", mktime(0,0,0,$date_month,$date_day,$date_year));	
  elseif($type == 12):  
  	// Returns a combo ExL Wed,Nov 12th,2003
  	$date=date("F jS, Y H:i:s", mktime($date_hour,$date_min,$date_sec,$date_month,$date_day,$date_year));
  endif;
  return $date;
}
## miscellanous function to get sttament
function complete($sign)	{
	if ($sign=='I')
		$letter = "INCOMPLETE";
					
	if ($sign=='C')
		$letter = "COMPLETE";
	return $letter;
}

## function to get the letter versions of the month  (1 = short form, >=2 Long form
function month_var($id,$ver)	{

	if ($id==01)	{
		$mth = "Jan";
		$mth2 = "January";
	}
	elseif ($id==02)	{
		$mth = "Feb";
		$mth2 = "February";
	}
	elseif ($id==03)	{
		$mth = "Mar";
		$mth2 = "March";
	}
	elseif ($id==04)	{
		$mth = "Apr";
		$mth2 = "April";
	}
	elseif ($id==05)	{
		$mth = "May";
		$mth2 = "May";
	}
	elseif ($id==06)	{
		$mth = "Jun";
		$mth2 = "June";
	}
	elseif ($id==07)	{
		$mth = "Jul";
		$mth2 = "July";
	}
	elseif ($id==08)	{
		$mth = "Aug";
		$mth2 = "August";
	}
	elseif ($id==09)	{
		$mth = "Sep";
		$mth2 = "September";
	}
	elseif ($id==10)	{
		$mth = "Oct";
		$mth2 = "October";
	}
	elseif ($id==11)	{
		$mth = "Nov";
		$mth2 = "November";
	}
	elseif ($id==12)	{
		$mth = "Dec";
		$mth2 = "December";
	}
	## check version
		if  ($ver==1)	{
		return $mth;	
		}
		else	{
		return $mth2; 
		}
}

## function to get the letter versions of the day  (1 = short form, >=2 Long form
function week($id,$ver)	{

	if ($id==01)	{
		$day = "Mon";
		$day2 = "Monday";
	}
	elseif ($id==02)	{
		$day = "Tue";
		$day2 = "Tuesday";
	}
	elseif ($id==03)	{
		$day = "Wed";
		$day2 = "Wednesday";
	}
	elseif ($id==04)	{
		$day = "Thur";
		$day2 = "Thursday";
	}
	elseif ($id==05)	{
		$day = "Fri";
		$day2 = "Friday";
	}
	elseif ($id==06)	{
		$day = "Sat";
		$day2 = "Saturday";
	}
	elseif ($id==07)	{
		$day = "Sun";
		$day2 = "Sunday";
	}
	
	## check version
		if  ($ver==1)	{
			return $day;	
		}
		else	{
			return $day2; 
		}
}

##list menu function to display months
function months()	{
	echo "<select name=month id=month class=page>";
	echo "<option>-select month-</option>";
	echo "<option value=01>January</option>";
	echo "<option value=02>Feburary</option>";
	echo "<option value=03>March</option>";
	echo "<option value=04>April</option>";
	echo "<option value=05>May</option>";
	echo "<option value=06>June</option>";
	echo "<option value=07>July</option>";
	echo "<option value=08>August</option>";
	echo "<option value=09>September</option>";
	echo "<option value=10>October</option>";
	echo "<option value=11>November</option>";
	echo "<option value=12>December</option>";
}
## functiion for day variable 5 to 05 e.t.c
function day_var($did)	{
	if ($did<10)	{
		$did = "0".$did;
	}
	return $did;
}

## simple arithmetic
//function to perform simple arithmetic: 
// uses 3 variables: 1st Number, 2nd Number, Operation
function arithmetic($num, $num2,$math)	{
	if ($math=="add")	{
		$ans = ($num +$num2);
	}
	elseif ($math=="divide")	{
		$ans = ($num / $num2);
	}
	elseif ($math=="multiply")	{
		$ans = ($num *$num2);
	}
	elseif ($math=="subtract")	{
		$ans = ($num -$num2);
	}
	elseif ($math=="exp")	{
		$ans = pow($num,$num2);
	}
	else		{
	}
	
	return $ans;
}

## md5 function
function d54($txt)	{
	$md5 = md5($txt);
	return $md5;
}
##table=> Table to fetch data| id=index to identify data | field to display back
function value_name($table,$id_field,$id,$field)	{
##
	$query = mysql_query("select * from $table where $id_field='$id'") or die("Error".mysql_error());
	$row=fetch_assoc($query);
	return  $row[$field];
}

function user_type($post)	{

	$str = substr($post,0,1);
	return $str;
}

## function to change to upper case
function ucase($str)	{
	$str = strtoupper($str);
	return $str;
}

##function to post session variable
function post_to_session($var)	{
	$var = $_SESSION['$var']=$row['$var'];
	return $var;
}

##function to return values from db (funny)
function names($table,$f1,$f2,$where,$value){
	$query = mysql_query("select $f1,$f2 from $table where $where='$value'");
	if (counter($query)>=1)	{
		$row= fetch_assoc($query);
	}
	$var = $row[$f1]. " " . $row[$f2];
	return $var;

}

##function to find values on most recent date
function latest_date($table,$var_find,$where,$value,$order){
	$query = mysql_query("select $var_find from $table where $where='$value' order by $order DESC");
	if (counter($query)>=1)	{
		$row= fetch_assoc($query);
	}
	$var = $row[$var_find];
	return $var;
}
// table counter for parameters
//e.g echo sty_counter(health_medical_history,student_id,$_SESSION['student_id']) . " ";
function sty_counter($table,$where,$value){
	$query = mysql_query("select * from $table where $where ='$value'");
	$count = counter($query);
	return $count;
}

?>
<?php function tt_setup()	{
global $term; global $year;
	$sql = mysql_query("select class from tt_setup where session= '".$year."' and term = '".$term."' and class = '".$_SESSION['room_id']."' ");
	if (counter($sql)<1)	{
		header("location: settings.php?err=2");
		//echo "error";
	}
}
?>

<?php
function gtime ()	{ // function for greeting
$timer = date("H:i:s");  
	if (($timer >= "00:00:00") && ($timer <= "11:59:59"))	{
		// Morning Dew
		$gtime= "Good Morning";
	}
	elseif (($timer >= "12:00:00") && ($timer <= "15:59:59"))	{
		// Afternoon greeting
		$gtime= "Good Afternoon";
	}
	elseif (($timer > "16:00:00") && ($timer <= "19:59:59"))	{
		// evening key
		$gtime= "Good Evening";
	}
	else	{
		// Night Shift
		$gtime= "Its Night Time";
	}
	return $gtime;
} // end function

##Function for calculating Gradepoints
function gp($sco)	{
	## check d for settings
	$sel_gp = mysql_query("select * from grade_point order by upp_bd ASC");
	
	## conditions for grade
	while ($rgp = fetch_assoc($sel_gp))	{
		if (($sco>= $rgp['low_bd']) and ($sco<=$rgp['upp_bd']) )	{
			$grad = $rgp['grade'];
		}
	}
	return $grad;
}
?>
<?php
 function edit_job($cat_id)			{
	  	echo  "<table border=0 >";
			$qy = mysql_query("select * from j_type where j_cat_id = '".$cat_id."'");
			while ($row = fetch_assoc($qy))	{
				## check inserted types
				$sql = mysql_query("select * from account_tool where ref_id = '".$_SESSION['ref_id']."' and tool= '".$row['id']."'");
				$rw = fetch_assoc($sql);
					if ($rw['tool']==$row['id'])	{
						echo "<tr><td><label>";
						echo " <input name='". $row['id'] ."' type=checkbox value=1 checked=checked />";
						echo $row['j_type'];
						echo "</label></td></tr>";
					}					
					else	{
						echo "<tr><td><label>";
						echo " <input name='". $row['id'] ."' type=checkbox value=1 />";
						echo $row['j_type'];
						echo "</label></td></tr>";
					}				
			}
		echo "</table>";
	} // end of function 
?>
<?php
 function subject($cat_id)			{
	  	echo  "<table border=0 >";
			$qy = mysql_query("select * from j_type where j_cat_id = '".$cat_id."'");
			while ($row = fetch_assoc($qy))	{
			echo "<tr><td><label>";
			echo " <input name='". $row['id'] ."' type=checkbox value=1 />";
			echo $row['j_type'];;
			echo "</label></td></tr>";
			}
		echo "</table>";
	} // end of function 
?>
<?php
 function job_type($st,$ed)			{
	  	echo  "<table border=0 >";
			$qy = mysql_query("select * from j_type order by j_type ASC limit $st,$ed");
			while ($row = fetch_assoc($qy))	{
			## get projects on site that are opened
			$select = mysql_query("select count(*) as number from (select * from project_tool where proj_id in (select proj_id from project where status = 'Open')) as JobType where j_type = '".$row['id']."'");
			$fetch = fetch_assoc($select);
			echo "<tr><td><label>";
			echo "<a href=/project/job_view.php?jid=".$row['id'].">".$row['j_type']. " (".$fetch['number'].") </a>";
			echo "</label></td></tr>";
			}
		echo "</table>";
	} // end of function 
?>
<?php
## Function to calculate sms price per Quantity
function smsrate($smsamt)	{
	if ($smsamt<200) 	{
		$rate = 5.50;
	}
	elseif (($smsamt>=200) && ($smsamt<=1000))	{
		$rate = 2.00;
	}
	elseif(($smsamt>=1001) && ($smsamt<=2000)) {
		$rate = 2.00;
	}
	elseif(($smsamt>=2001) && ($smsamt<=5000))	{
		$rate = 1.90;
	}
	elseif(($smsamt>=5001) && ($smsamt<=10000))	{
		$rate = 1.85;
	}
	elseif (($smsamt>=10001))	{
		$rate = 1.75;
	}

	return $rate;
}
?>
<?php
## function to determine cost of credit

	function creditcost($msglength)	{
		$msglen = strlen($msglength);
		if ($msglen<=160){
			$mlen =1;
		}
		elseif(($msglen>=161) && ($msglen<=320)){
			$mlen=2;
		}
		elseif(($msglen>=321) && ($msglen<=450)){
			$mlen =3;
		}
		elseif($msglen>451){
			$mlen= "4";
		}
		return $mlen;
	}
?>
<?php
/**
 * Function to calculate date or time difference.
 * 
 * Function to calculate date or time difference. Returns an array or
 * false on error.
 *
 * @author       J de Silva                             <giddomains@gmail.com>
 * @copyright    Copyright &copy; 2005, J de Silva
 * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
 * @param        string                                 $start
 * @param        string                                 $end
 * @return       array
 */
function get_time_difference( $start, $end )
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );            
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}
?>
<?php
function testDate( $startdate )	{
	return preg_match( '/^(\d{4})-(\d{1,2})-(\d{1,2})/' , $startdate );
}
	
function testTime( $starttime )	{
	return preg_match( '/^\d{2}:\d{2}([ap]m)?$/' , $starttime );
}

function timeDiff($firstTime,$lastTime)	{
	// convert to unix timestamps
	$firstTime=strtotime($firstTime);
	$lastTime=strtotime($lastTime);
	
	// perform subtraction to get the difference (in seconds) between times
	$timeDiff=$lastTime-$firstTime;
	
	// return the difference
	return $timeDiff;
}

function validateint($inData) {
  $intRetVal = -1;

  $IntValue = intval($inData);
  $StrValue = strval($IntValue);
  if($StrValue == $inData) {
    $intRetVal = $IntValue;
  }

  return $intRetVal;
}
?>
<?php
function addfind($eid,$gsm)	{
	$query=mysql_query("select icontact from addressbook where eid='".$eid."' and gsm='".$gsm."'");
	$rows=fetch_assoc($query);
	return $rows['icontact'];
}

function quicksend($email)	{
	$select = mysql_query("select id,gsm,count(gsm) as glist from message where email_id='".$email."' group by gsm order by glist DESC limit 0,10");
	while ($row=fetch_assoc($select))	{
		$eid = db_value(profile,id,email_id,$email);
		echo "<dt>".$row['gsm']."&nbsp;(".addfind($eid,$row['gsm']).")</dt>";
	}
}

function quicksend2($email)	{
	$select = mysql_query("select  DISTINCT gsm,email_id,id from message where email_id='".$email."' order by id DESC limit 0,10");
	while ($row=fetch_assoc($select))	{
		$eid = db_value(profile,id,email_id,$email);
		echo "<dt>".$row['gsm']."&nbsp;(".addfind($eid,$row['gsm']).")</dt>";
	}
}
?>
<?php
function editreplace($messagetext)		{
	
	$messagetext = str_replace('\"','"',$messagetext);
	$messagetext = str_replace("\'","'",$messagetext);
	
	return $messagetext;
}
?>
<?php
function dashex ($page, $num)	{
		$vha=explode ("_",$page);
		$sbar=$vha[1];
		$page=$vha[0];
			
			if ($num==1)	{
				return $page;
			}
			elseif ($num==2)		{
				return $sbar;
			}
}
?>
	<?php
	## Function  to get <a link class [link or nolink]
		function getlink($page, $link) {
		$vha=explode ("_",$page);
		$sbar=$vha[1];
		
		if ($sbar==$link)		{
				$lnk="link";
		}
		else		{
				$lnk="nolink";
		}
		return $lnk;
	}
?>
<?php
	##Page Sidebar Checker
	function sbar ($section, $page, $sub)		{
			if ($sub=="")		{
				if ($section==1 && $page==1)		{
					$vpage="../pages/bp/index.php";
				}
				else	if ($section==1 && $page==2)		{
					$vpage="../pages/profile/profile.php";
				}
				else	if ($section==1 && $page==3)		{
					$vpage="../pages/profile/phistory.php";
				}
				else	if ($section==2 && $page==1)		{
					$vpage="../pages/admin/select_league.php";
				}
				else	if ($section==2 && $page==2)		{
					$vpage="../pages/admin/match.php";
				}
				else	if ($section==2 && $page==3)		{
					$vpage="../pages/account/change_password.php";
				}	
				else	if ($section==2 && $page==4)		{
					$vpage="../pages/admin/confirm_payment.php";
				}
				else	if ($section==2 && $page==5)		{
					$vpage="../pages/admin/enter_payment.php";
				}	
				else	if ($section==2 && $page==6)		{
					$vpage="../pages/admin/enter_betslip.php";
				}	
				else	if ($section==2 && $page==7)		{
					$vpage="../pages/admin/betslip_history.php";
				}	
				else	if ($section==2 && $page==8)		{
					$vpage="../pages/admin/load_shortcode.php";
				}	
				else	if ($section==2 && $page==9)		{
					$vpage="../pages/admin/shortcode_history.php";
				}
				else	if ($section==2 && $page==10)		{
					$vpage="../pages/admin/enter_tips.php";
				}	
				else	if ($section==2 && $page==11)		{
					$vpage="../pages/admin/tips_history.php";
				}	
				else	if ($section==2 && $page==12)		{
					$vpage="../pages/admin/query_manager.php";
				}																	
				else	if ($section==3 && $page==1)		{
					$vpage="../pages/account/change_password.php";
				}
				else	if ($section==3 && $page==2)		{
					$vpage="../pages/bets/placebet.php";
				}
				else	if ($section==3 && $page==3)		{
					$vpage="../pages/sendsms/scheduled.php";
				}
				else	if ($section==3 && $page==4)		{
					$vpage="../pages/sendsms/numbercontext.php";
				}	
				else	if ($section==3 && $page==6)		{
					$vpage="../pages/sendsms/bulksms.php";
				}
				else	if ($section==3 && $page==8)		{
					$vpage="../pages/sendsms/sendinvite.php";
				}	
				else	if ($section==3 && $page==7)		{
					$vpage="../pages/sendsms/phonecode.php";
				}					
				else	if ($section==3 && $page==9)		{
					$vpage="../pages/sendsms/transfercredit.php";
				}	
				else	if ($section==3 && $page==10)		{
					$vpage="../pages/sendsms/bulkscheduled.php";
				}													
				elseif ($section==4 && $page==1)		{
					$vpage="../pages/bets/league.php";
				}
				elseif ($section==4 && $page==2)		{
					$vpage="../pages/bets/placebet.php";
				}
				else	if ($section==4 && $page==3)		{
					$vpage="../pages/addressbook/addgroup.php";
				}
				else	if ($section==5 && $page==1)		{
					$vpage="../pages/bets/mystat.php";
				}	
				else	if ($section==5 && $page==2)		{
					$vpage="../pages/bets/allstat.php";
				}		
				else	if ($section==5 && $page==3)		{
					$vpage="../pages/payment/bankdeposit.php";
				}
				else	if ($section==5 && $page==4)		{
					$vpage="../pages/payment/deposit_history.php";
				}	
				else	if ($section==5 && $page==5)		{
					$vpage="../pages/payment/online_history.php";
				}	
				else	if ($section==5 && $page==6)		{
					$vpage="../pages/payment/credit_list.php";
				}
				else	if ($section==5 && $page==7)		{
					$vpage="../pages/payment/afterpay.php";
				}				
				else	if ($section==6 && $page==1)		{
					$vpage="../pages/surebet/subscribe.php";
				}	
				else	if ($section==6 && $page==2)		{
					$vpage="../pages/surebet/activatesub.php";
				}	
				else	if ($section==6 && $page==3)		{
					$vpage="../pages/surebet/viewsubs.php";
				}	
				else	if ($section==6 && $page==4)		{
					$vpage="../pages/surebet/surebet_type.php";
				}	
				else	if ($section==6 && $page==5)		{
					$vpage="../pages/surebet/surebet.php";
				}	
				else	if ($section==6 && $page==6)		{
					$vpage="../pages/surebet/surebet2.php";
				}	
				else	if ($section==6 && $page==7)		{
					$vpage="../pages/surebet/nosubscription.php";
				}	
				else	if ($section==6 && $page==8)		{
					$vpage="../pages/surebet/betslip.php";
				}
				else	if ($section==6 && $page==9)		{
					$vpage="../pages/surebet/resources.php";
				}	
				else	if ($section==6 && $page==10)		{
					$vpage="../pages/surebet/invoice.php";
				}
				else	if ($section==6 && $page==11)		{
					$vpage="../pages/surebet/fund_wallet.php";
				}		
				else	if ($section==6 && $page==12)		{
					$vpage="../pages/surebet/surebet3.php";
				}	
				else	if ($section==6 && $page==13)		{
					$vpage="../pages/surebet/surebet4.php";
				}	
				else	if ($section==6 && $page==14)		{
					$vpage="../pages/surebet/diy_analysis.php";
				}
				else	if ($section==6 && $page==15)		{
					$vpage="../pages/pay/epayment.php";
				}
				else	if ($section==6 && $page==16)		{
					$vpage="../pages/pay/callback.php";
				}																																				
				else	if ($section==8 && $page==1)		{
					$vpage="../pages/help/index.php";
				}																																																																			
				else	{
					$vpage="../pages/profile/index.php";
				}
				
			}
			else		{		
				if ($section==3 && $page==6 && $sub==1)		{
					$vpage="../pages/sendsms/upload/bulksms_text.php";
				}
				elseif ($section==3 && $page==6 && $sub==2)		{
					$vpage="../pages/sendsms/upload/bulksms_analysis.php";
				}
				elseif ($section==3 && $page==6 && $sub==3)		{
					$vpage="../pages/sendsms/upload/bulksms_send.php";
				}				
			}
			return $vpage;
	}
	
	?>
	<?php
	## Function to switch page
		function vpage($page, $bar)	{
		
		$vha=explode ("_",$page);
		$page=@$vha[0]; 
		$sbar=@$vha[1];
		$sublink=@$vha[2];
			if ($page=="1")		{
				$page=sbar ($page, $sbar,$sublink);
				#$sbar="../pages/profile/sidebar.php";
			}
			elseif ($page=="2")	{
				$page=sbar ($page, $sbar,$sublink);
				#$sbar="../pages/sendsms/sidebar.php";
			}
			elseif ($page=="3")		{
				$page=sbar ($page, $sbar,$sublink);
				#$sbar="../pages/contact/sidebar.php";
			}
			elseif ($page=="4")		{
				$page=sbar ($page, $sbar,$sublink);
				#$page="../pages/buy/index.php";
			}
			elseif ($page=="5")		{
				$page=sbar ($page, $sbar,$sublink);
			}
			elseif ($page=="6")		{
				$page=sbar ($page, $sbar,$sublink);
			}
			elseif ($page=="8")		{
				$page=sbar ($page, $sbar,$sublink);
			}							
			else		{	
				$page="../pages/bp/index.php";
				##$sbar="../pages/smsbag/sidebar.php";
			}
			
			if ($bar==1)	{
				return $page;
			}
			elseif ($bar==2)		{
				return $sbar;
			}
	}
	?>
<?php
function bettype($bettype,$oe)	{

	if ($bettype!="")	{

		if ($bettype=="H")	{
			$bt="<td class=bg-primary align=center width=30%>Fixed Odds</td>";
		}
		elseif ($bettype=="D") {
			$bt="<td class=bg-primary align=center width=30%>Fixed Odds</td>";
		}
		elseif ($bettype=="A")	{
			$bt="<td class=bg-primary align=center width=30%>Fixed Odds</td>";		
		}
		elseif ($bettype=="U")	{
			$bt="<td class=bg-warning align=center width=30%>Goals U/O(2.5)</td>";		
		}
		elseif (($bettype=="O") and ($oe==0))	{
			$bt="<td class=bg-warning align=center width=30%>Goals U/O(2.5)</td>";		
		}
		elseif ($bettype=="Y")	{
			$bt="<td class=bg-default align=center width=30%>BTTS</td>";		
		}
		elseif ($bettype=="N")	{
			$bt="<td class=bg-default align=center width=30%>BTTS</td>";		
		}	
		elseif (($bettype=="O") and ($oe==1))	{
			$bt="<td class=bg-warning align=center width=30%>Odds/Even</td>";		
		}
		elseif ($bettype=="E")	{
			$bt="<td class=bg-warning align=center width=30%>Odds/Even</td>";		
		}						
		
	}
	return $bt;
}

###betpredict
function betscore($fsh,$fsa,$display)	{
	
	if (($fsh!="") && ($fsa!=""))	{
	
		if ($display==0)	{
			$bt = "<td class=bg-info align=center>Correct Score</td>";		
		}
		else	{
			$bt = "<td class=bg-info align=center>".($fsh." - ".$fsa)."</td>";
		}
		
	}
	
	return $bt;
}

function bettip($tip,$home,$away,$oe)	{

	if ($tip!="")	{
	
		if ($tip=="H")	{
			$bt="<td class=bg-primary align=center>".$home. " Wins";
		}
		elseif ($tip=="D") {
			$bt="<td class=bg-primary align=center>Draw</td>";
		}
		elseif ($tip=="A")	{
			$bt="<td class=bg-primary align=center>".$away." Wins</td>";		
		}
		elseif ($tip=="U")	{
			$bt="<td class=bg-warning align=center>Under 2.5</td>";		
		}
		elseif (($tip=="O") && ($oe==0))	{
			$bt="<td class=bg-warning align=center>Over 2.5</td>";		
		}	
		elseif ($tip=="Y")	{
			$bt="<td class=bg-default align=center>BTTS (Yes)</td>";		
		}
		elseif ($tip=="N")	{
			$bt="<td class=bg-default align=center>BTTS (No)</td>";		
		}	
		elseif (($tip=="O") && ($oe==1))	{
			$bt="<td class=bg-warning align=center>Odd</td>";		
		}
		elseif ($tip=="E")	{
			$bt="<td class=bg-warning align=center>Even</td>";		
		}					
	
	}
	return $bt;
}

function betresult($tip,$result)	{

	if ($tip!="")	{
	
		if ($tip==$result)	{
			$bt="<td align=center class=bg-success width=20%>Hit</td>";
		}
		elseif (($tip!=$result) && ($result!="")) {
			$bt="<td align=center class=bg-danger width=20%>Miss</td>";
		}
		elseif (($tip!=$result) && ($result=="")) {
			$bt="<td align=center class=bg-default width=20%>N/A</td>";
		}
	}

	return $bt;
}

function betscoreline($fsh,$fsa,$ahts,$aats)	{

	if (($fsh!="") && ($fsa!=""))	{
	
		if (($fsh==$ahts) && ($fsa==$aats))	{
			$bt="<td align=center class=bg-success >Hit (".$ahts."-".$aats.")</td>";
		}
		else if (($ahts=="") && ($aats=="") && ($fsh!="")) {
			$bt="<td align=center class=bg-default>N/A</td>";
		}		
		else {
			$bt="<td align=center class=bg-danger >Miss (".$ahts."-".$aats.")</td>";
		}
	}
	
	return $bt;
}

###Betpredict - Find Match week
function find_match_week ($league,$matchdate)	{
	$sqldate="select startdate from bp_league where code='".$league."'";
	$qdate=mysql_query($sqldate);
	$rdate=fetch_assoc($qdate);
	###
	$diff = no_of_days($rdate['startdate'],$matchdate);
	$week = ceil($diff / 7 );
	
	return $week;
}

	function totaltips($tipster)	{
		$sqlsum=mysql_query("select count(tipster) as tipsum from bp_tipview where tipster='".
		$tipster."'");
		$rowsum=fetch_assoc($sqlsum);
		
		return $rowsum['tipsum'];
	}
	
### calculate Tip Rate
function calc_tip_rate($tipster,$table)	{

$qsql="select tipster,total_ftr,total_goal25,total_score,ftr_success,goal25_success,score_success,total_btts,btts_success,total_oddeven,oddeven_success from $table where tipster='".$tipster."'";

	$qrate=@mysql_query($qsql);
	$rowtip=fetch_assoc($qrate);
	####Calculate Total Tips Made
	#$totaltipscount=$rowtip['total_ftr']+$rowtip['total_goal25']+$rowtip['total_score'];
	@$totaltipscount=$rowtip['total_ftr']+$rowtip['total_goal25'];
	##Calculate Total Success Rate
	#$successrate=$rowtip['ftr_success']+$rowtip['goal25_success']+$rowtip['score_success'];
	@$successrate=$rowtip['ftr_success']+$rowtip['goal25_success'];
	##Calculate Success %
	@$totaltips=(($successrate/$totaltipscount)*100);
	@$ftr_tip=(($rowtip['ftr_success']/$rowtip['total_ftr'])*100);
	@$g25_tip=(($rowtip['goal25_success']/$rowtip['total_goal25'])*100);
	@$score_tip=(($rowtip['score_success']/$rowtip['total_score'])*100);
	@$oddeven_tip=(($rowtip['oddeven_success']/$rowtip['total_oddeven'])*100);
	@$btts_tip=(($rowtip['btts_success']/$rowtip['total_btts'])*100);

	###
	if (@mysql_num_rows($qrate)<1)	{
		$totaltips=0;
	}
	
	return array($totaltips,$ftr_tip,$g25_tip,$score_tip,$btts_tip,$oddeven_tip,$totaltipscount,$successrate);
}	

function calc_tip_rate_2($tipster,$table,$fromdate,$todate)	{

$qsql="select tipster,total_ftr,total_goal25,total_score,ftr_success,goal25_success,score_success,total_btts,btts_success,total_oddeven,oddeven_success from $table where tipster='".$tipster."' and stat_date>='".$fromdate."' and stat_date<='".$todate."' ";

	$qrate=@mysql_query($qsql);
	$rowtip=fetch_assoc($qrate);
	####Calculate Total Tips Made
	#$totaltipscount=$rowtip['total_ftr']+$rowtip['total_goal25']+$rowtip['total_score'];
	@$totaltipscount=$rowtip['total_ftr']+$rowtip['total_goal25'];
	##Calculate Total Success Rate
	#$successrate=$rowtip['ftr_success']+$rowtip['goal25_success']+$rowtip['score_success'];
	@$successrate=$rowtip['ftr_success']+$rowtip['goal25_success'];
	##Calculate Success %
	@$totaltips=(($successrate/$totaltipscount)*100);
	@$ftr_tip=(($rowtip['ftr_success']/$rowtip['total_ftr'])*100);
	@$g25_tip=(($rowtip['goal25_success']/$rowtip['total_goal25'])*100);
	@$score_tip=(($rowtip['score_success']/$rowtip['total_score'])*100);
	@$oddeven_tip=(($rowtip['oddeven_success']/$rowtip['total_oddeven'])*100);
	@$btts_tip=(($rowtip['btts_success']/$rowtip['total_btts'])*100);

	###
	if (@mysql_num_rows($qrate)<1)	{
		$totaltips=0;
	}
	
	return array($totaltips,$ftr_tip,$g25_tip,$score_tip,$btts_tip,$oddeven_tip,$totaltipscount,$successrate);
}	

?>
<?php
##function to generate random numbers for betslips
function random($cnt,$total) {
	$count = $cnt;
	$highball = $total;
	$numbers = range(0, $highball);
	shuffle($numbers);
	$drawn = array_slice($numbers, - $count);
	sort($drawn);
	
/*	echo "Numbers: "; 
	for ($i=1; $i<=10; $i++)	{
		echo " - ";
		echo $drawn[$i];
	
	}*/
	return $drawn;
}
?>
<?php
function tips_points($tips)	{
	if ($tips=="ftr")	{
		$pts="3";
	}
	elseif($tips=="mg")	{
		$pts="3";
	}
	elseif($tips=="btts") {
		$pts="3";	
	}
	elseif($tips=="oddeven") {
		$pts="3";
	}
	elseif($tips=="score") {
		$pts="5";
	}	
	elseif($tips=="scorediff") {
		$pts="2";
	}		
	
	return $pts;
}
?>
<?php
function sub_price ($sub_type) {
	if ($sub_type=="free")	{
		$price="0";
	}
	elseif ($sub_type=="weekly")	{
		$price="1000";
	}
	elseif ($sub_type=="monthly")	{
		$price="3000";
	}
	elseif ($sub_type=="quarterly")	{
		$price="7500";
	}
	elseif ($sub_type=="biannual")	{
		$price="14000";
	}
	elseif ($sub_type=="yearly")	{
		$price="22500";
	}
	else {
		$price="30000";
	}				
	return $price;
}

?>
<?php
function days_to_add ($sub_type) {
	if ($sub_type=="free")	{
		$add="+1 week";
	}
	elseif ($sub_type=="weekly")	{
		$add="+1 week";
	}
	elseif ($sub_type=="monthly")	{
		$add="+1 month";
	}
	elseif ($sub_type=="quarterly")	{
		$add="+3 months";
	}
	elseif ($sub_type=="biannual")	{
		$add="+6 months";
	}
	elseif ($sub_type=="yearly")	{
		$add="+1 year";
	}
	else {
		$add="+1 Day";
	}				
	return $add;
}
?>
<?php 
function sidemenu($page, $linkno, $plain, $withlink)		{
	if (dashex ($page, 2)== $linkno)	{
			$menu = $plain;
	}
	else		{
			$menu =  $withlink;
	}
	
	return $menu;
}
?>
<?php
####bootstrap Alert display based on error code
function displayMsg ($errorCode,$errorMsg)	{
	   if (($errorCode>0) && ($errorMsg!=""))	{
	   		if ($errorCode==1)	{
				$alert="alert alert-success";
			}
			elseif ($errorCode==2) {
				$alert="alert alert-warning";
			}
			elseif ($errorCode==3)	{
				$alert="alert alert-danger";
			}
			else { 
				$alert="alert alert-warning";
			}
	   }
	   echo "<div class=\"".$alert."\" role=\"alert\">".$errorMsg."</div>";
}

####String Random
function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function stringcheck($sentword)	{
###set a flag for restricted words
	$flag=0;
	
	$word[0]="BANK";
	$word[1]="MONEY";
	$word[2]="GTB";
	$word[3]="SMSBAG";
	$word[4]="ARIK";
	$word[5]="COCACOLA"; 
	$word[6]="CLYDE";
	$word[7]="POLICE";	
	$word[8]="PAYMENT";
    $word[9]="ARMY";
	$word[10]="HOMELAND";	
	$word[11]="TREASURY";
    $word[12]="RESERVE";
    $word[13]="CBN";
    $word[14]="MILITARY";		
	$word[15]="FIFA";	
	$word[16]="INTERPOL";		
	$word[17]="NNPC";	
	$word[18]="N.N.P.C";	
	$word[18]="DHL";
	$word[19]="HSBC";	
	$word[20]="EFCC";	
	$word[21]="OCEANIC";		
	$word[22]="ALERT";
	$word[23]="EMBASSY";
	
	#echo count($word);
	
	for ($ch=0; $ch<count($word); $ch++)	{
		if (preg_match("/".$word[$ch]."/i", strtolower($sentword ))) {
			#echo "A match was found in " . $word[$ch] . "<br />";
			$flag=$flag+1;
		} else {
			#echo "A match was not found.". "<br />";
		}
	
	}

	return $flag;
} ## end of function
?>
<?php ##include "conn.php"; ?>