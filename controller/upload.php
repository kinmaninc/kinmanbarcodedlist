<?php
require '../configuration.php';

if(isset($_POST["act"])){
	$filename = $_POST['filename'];
	$act = $_POST['act'];
	$id = $_POST['id'];
	$target_directory = "../site_images/";
	
	if($act==0){
		if(file_exists($target_directory.$filename)){
			echo 1;
		}else{
			$target_file = $target_directory.basename($_FILES["file"]["name"]);
			$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$newfilename = $target_directory.$filename;
			
			//check if uploaded or not
			if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)){
				mysqli_query($connection, "UPDATE inv_pickups SET img_path='$filename' WHERE id = '$id'");
				echo 0;
			}
		}
	}
	// if($act==1){
	// 	$target_file = $target_directory.basename($_FILES["file"]["name"]); 
	// 	$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// 	$newfilename = $target_directory.$filename;

	// 		//check if uploaded or not
	// 	if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)){
	// 		mysqli_query($connection, "UPDATE inv_pickups SET img_path='$filename' WHERE id = '$id'");
	// 		echo "Your files has been uploaded.";
	// 	}else{
	// 		echo "Error uploading your file.";
	// 	}
	// }
}


?>