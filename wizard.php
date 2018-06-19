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

// function to return resource array
function fetch_assoc($resource)	{

	$row = @mysql_fetch_assoc($resource);
	return $row;
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
		$sql_query = mysql_query($sql_str) or die(mysql_error());

		if ($sql_query)
			$msg =  'Record Successfully Inserted for All Fields';
		if (!$sql_query)
			$msg =  'Invalid Query';
	//$query = mysql_query("") or die('Insertion error'. mysql_error());
	return $msg; 
}


// counter function=>to return numbers of rows fetched or found
function counter($resource)	{

	return @mysql_num_rows($resource);
}

//function to check existence of a valued variable
function exist_b4($table,$field,$value)		{
		
		$existed = @mysql_query("SELECT $field FROM $table WHERE $field='$value'");// or die('Invalid Exist 
		//Query'. mysql_error());
		
		$no = counter($existed) ;
		return $no;
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
	   echo "<div class=\"".@$alert."\" role=\"alert\">".@$errorMsg."</div>";
}

function replace ( $post ) {
	$postname = preg_replace('/[^a-zA-Z0-9\s]/', '', strip_tags(html_entity_decode($post)));
	$postname=str_replace(" ","-",$postname);
	$postname=str_replace("--","-",$postname);
	$postname=str_replace("---","-",$postname);
	return $postname;
}


function post_name ( $post ) {
	
	##trim first
	$postname=str_replace(" - "," ",$post);
	$postname=str_replace("!","",$postname);
	$postname=str_replace(",","",$postname);
	$postname=str_replace("&#039;","",$postname);
	$postname=str_replace("'","",$postname);
	$postname=str_replace("’","",$postname);
	$postname=str_replace("‘","",$postname);
	$postname=str_replace(".","",$postname);
	$postname=str_replace(":","",$postname);
	$postname=str_replace("&","",$postname);
	$postname=str_replace("$","",$postname);
	$postname=str_replace("#","",$postname);
	$postname=str_replace("@","",$postname);
	$postname=str_replace("*","",$postname);
	$postname=str_replace("(","",$postname);
	$postname=str_replace(")","",$postname);
	$postname=str_replace("!","",$postname);
	$postname=str_replace("%","",$postname);
	$postname=str_replace("^","",$postname);
	$postname=str_replace("?","",$postname);
	$postname=str_replace("/","",$postname);
	$postname=str_replace("+","",$postname);
	$postname=str_replace(";","",$postname);
	$postname=str_replace(":","",$postname);
	$postname=str_replace("{","",$postname);
	$postname=str_replace("}","",$postname);
	$postname=str_replace("[","",$postname);
	$postname=str_replace("]","",$postname);
	$postname=str_replace("|","",$postname);
	$postname=str_replace("=","",$postname);
	$postname=str_replace('"\"',"",$postname);
	$postname=str_replace("/","",$postname);
	$postname=str_replace('“',"",$postname);
	$postname=str_replace('”',"",$postname);
	$postname=str_replace('"',"",$postname);
	$postname=trim ( $postname );
	$postname=str_replace(" ","-",$postname);
	$postname=str_replace("-–-","",$postname);
	$postname=str_replace("--","",$postname);
	$postname=str_replace(" ","-",$postname);
	$postname=str_replace("- ","",$postname);
	$postname=str_replace("  ","",$postname);
	$postname=str_replace(" ","",$postname);
	$postname=str_replace("-—","-",$postname);
	$postname=str_replace("-—-","",$postname);
	$postname=strtolower ( $postname );
	
	return $postname;
	
}

function title_check ( $title ) {
	
	##trim first
	$title=str_replace("'","",$title);
	$title=str_replace(".","",$title);
	$title=trim ( $title );
	
	return $title;
	
}

function bodyconvert ($post_body) {
	
	###[url= URLs
	$body=str_replace('[url=','<a href="',$post_body);
	$body=str_replace('[/url]','</a>',$body);
	##[img= images
	$body=str_replace('"[img]','"',$body);
	$body=str_replace('[/img]"','"',$body);	
	##real img check
	$body=str_replace('[img]','<img src="',$body);
	$body=str_replace('[/img]','">',$body);
	###
	$body=str_replace('“','"',$body);
	### [b] strong
	$body=str_replace('[b]','<strong>',$body);
	$body=str_replace('[/b]','</strong>',$body);
	### [html] strong
	$body=str_replace('[html]','',$body);
	$body=str_replace('[/html]','',$body); 
	### [youtube] strong
	$body=str_replace('[youtube]','<iframe src="',$body);
	$body=str_replace('[/youtube]','"></iframe>',$body); 
	####HTML encoderd
	$body=str_replace('[&#8230;]','',$body);
	###User Message 
	$body=str_replace(@$smf_message1,'',$body);
	###loose ]
	$body=str_replace(']','">',$body);
	
	return $body;
}

function total_record ( $table_name ) {
	$sqlrec="SELECT count(*) as total from $table_name";
	$qrec=mysql_query($sqlrec);
	$rowrec=fetch_assoc($qrec);
	return $rowrec['total'];
}



?>