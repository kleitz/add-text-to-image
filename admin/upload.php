<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

   	$destination_path = getcwd().DIRECTORY_SEPARATOR;
   	$result = 0;

   	$f_type=$_FILES['file']['type'];
	if ($f_type== "image/png" OR $f_type== "image/jpeg" OR $f_type== "image/JPEG" OR $f_type== "image/PNG"){
		$newname = basename($_FILES['file']['name']);
		$target_path = $destination_path ."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR. basename($_FILES['file']['name']);
		if (file_exists($target_path))
		{
			$newname = time().basename($_FILES['file']['name']);

			$target_path = $destination_path ."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR.$newname;
		}

	   if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
	      $result = $newname;
	   }
	}
?>

<script language="javascript" type="text/javascript">
   window.top.window.stopUpload("<?php echo $result; ?>");
</script> 
