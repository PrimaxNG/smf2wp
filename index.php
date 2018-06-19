<?php
include "settings.php";
include "wizard.php";
## Connect using the connect db function
$conn = connect($db_server,$db_port,$db_user,$db_password,$db_name);

if (isset($_POST['convert']) ) {
	$select="SELECT * from $smf_table_name order by id_msg ASC limit 0,200";
	$smf_query=mysql_query($select);
	while ($row_convert=fetch_assoc($smf_query)) {
		###Avoid duplicates
		$id_exist=exist_b4($wp_post_table,"guid",$row_convert['id_msg']);
		##Check if message is a reply
		$reply=substr($row_convert['subject'],0,3);
		
		
		if ( ($id_exist<=0) && (strtolower($reply)!="re:") )  { ### if ID does not exist
			##convert wordpress posts
			$_POST['post_author']=1;
			$_POST['post_date']=date("Y-m-d h:i:s",$row_convert['poster_time']); 
			$_POST['post_date_gmt']=date("Y-m-d h:i:s",$row_convert['poster_time']); 
			$_POST['post_content']= mysql_real_escape_string(bodyconvert ($row_convert['body']));
			$_POST['post_title']= mysql_real_escape_string( title_check ($row_convert['subject']));
			$_POST['post_excerpt']="";
			$_POST['post_status']="publish";
			$_POST['comment_status']="open";
			$_POST['ping_status']="open";
			$_POST['post_name']= mysql_real_escape_string(replace($row_convert['subject']));
			$_POST['post_modified']=$_POST['post_date'];
			$_POST['post_modified_gmt']=$_POST['post_date'];
			$_POST['guid']=$row_convert['id_msg'];
			$_POST['menu_order']=0;
			$_POST['post_type']="post";
			$_POST['comment_count']=0;
			
			###insert into DB
			$insert=@insert_all( $wp_post_table );
			
			
			
		} ##end if ID exist
		## Insert Comments - Replies in SMF
		$comment_id=mysql_real_escape_string(replace($row_convert['subject']));
		if (strtolower($reply)=="re:") {
			###Comment Time
			##get post ID
			$_POST['comment_post_ID']=db_value($wp_post_table,"ID","post_name",$comment_id);
			$_POST['comment_author']=$author;
			$_POST['comment_author_email']=$author_email;
			$_POST['comment_author_url']="";
			$_POST['comment_author_IP']="";
			$_POST['comment_date']=date("Y-m-d h:i:s",$row_convert['poster_time']); 
			$_POST['comment_date_gmt']=date("Y-m-d h:i:s",$row_convert['poster_time']); 
			$_POST['comment_content']=mysql_real_escape_string(bodyconvert ($row_convert['body']));
			$_POST['comment_approved']=1;
			$_POST['comment_type']="";
			$_POST['user_id']=0;
			
			###insert into Comment Table
			$insert=@insert_all( $wp_comment_table );
		}##end if comments
		
			$errorCode=1;
			$errorMsg="SMF Message Convertion to Wordpress Table Completed!";
		
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Convert SMF to WORDPRESS</title>
<link href="application/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
<div class="row">
  <h1><img src="logo.png" alt="smf_to_wordpress" width="300" height="100"></h1>
  <h1>Convert SMF Messages to Wordpress Posts </h1>
  <hr class="label-danger" />
</div>

<div class="well">
	Welcome to SMF to Wordpress converter, before you start, kindly ensure the following
	<ul>
	<li>Make sure your SMF message table and Wordpress posts table are in the same Database</li>
	<li>Have the settings.php file set with the right variables</li>
	</ul>
</div>
<?php
echo displayMsg (@$errorCode,@$errorMsg);
?>
<form id="form1" name="form1" method="post" action="">

<div class="row">
  <div class="col-lg-4">
    <h4>SMF Table Name: <span class="text-danger"><?=$smf_table_name;?></span></h4>
	<h4>Total Records: <br />
	<span class="text-danger"><?php echo total_record ( $smf_table_name ) ;?></span></h4>
	<hr class="label-warning" />
  </div>
  
  <div class="col-lg-4" align="center">
	 <input name="convert" type="submit" class="btn-lg btn-success" id="convert" value="Convert SMF &gt;&gt; WP" />
  </div>
  		
  <div class="col-lg-4" align="right">
    <h4>Wordpress Table Name: <span class="text-success"><?=$wp_post_table;?></span></h4>
	<h4>Total Records: <br />
	<span class="text-danger"><?php echo total_record ( $wp_post_table ) ;?></span></h4>
	<hr class="label-success" />
  </div>
</div>

<!--footer-->
  <hr class="label-danger" />
  <p align="center">SMF to Wordpress Converter by Olutola Michael Obembe &copy; 2017</p>
  <p align="center">Email Me: <a href="mailto:olutola.obembe@primaxng.com">olutola.obembe@primaxng.com</a></p>

</form>
	
	
</div>
</body>
</html>
