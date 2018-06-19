<?php //image upload
		function image_upload()		{
		
			
			$image_tempname = $_FILES['image_filename']['name'];
			$ImageDir ="contents/";
			$ImageName = $ImageDir . $image_tempname;
			//if (move_uploaded_file($_FILES["image_filename"]["tmp_name"],$ImageName)) 
			if (move_uploaded_file($_FILES['image_filename']['tmp_name'],$ImageName))
			{
				/*print "Here's some more debugging info:\n";
				print_r($_FILES);*/
				//get info about the image being uploaded
				list($width, $height, $type, $attr) = getimagesize($uploadfile);
				$ext = pathinfo($image_tempname, PATHINFO_EXTENSION); 
				$newfile = "SA".mt_rand(00000121,999999999).".".$ext;
				rename("$filepath/$image_tempname", "$filepath/$newfile"); 
				
			} 
			else 
			{
				/*print "Possible file upload attack!  Here's some debugging info:\n";
				print_r($_FILES);*/
			}
			//print "</pre>";
		##return $image_tempname;
		return $newfile;
}
?>
<?php //image upload
		function image_upload2($filepath,$filename)		{
		
			
			$image_tempname = $_FILES[$filename]['name'];
			$ImageDir ="$filepath/";
			$ImageName = $ImageDir . $image_tempname;
			//if (move_uploaded_file($_FILES["image_filename"]["tmp_name"],$ImageName)) 
			if (move_uploaded_file($_FILES[$filename]['tmp_name'],$ImageName))
			{
/*				print "Here's some more debugging info:\n";
				print_r($_FILES);*/
				//get info about the image being uploaded
				@list($width, $height, $type, $attr) = @getimagesize($uploadfile);
				$ext = pathinfo($image_tempname, PATHINFO_EXTENSION); 
				$newfile = "SA".mt_rand(00000121,999999999).".".$ext;
				rename("$filepath/$image_tempname", "$filepath/$newfile"); 
				
			} 
			else 
			{
/*				print "Possible file upload attack!  Here's some debugging info:\n";
				print_r($_FILES);*/
			}
			//print "</pre>";
		return $newfile;
}
?>

