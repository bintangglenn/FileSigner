<?php 
if (! $_POST) {echo "400 Bad Request"; die();} session_start();
if(isset($_FILES['p12'])){
	$p12_pass = $_POST['p12Password'];

	$p12_name = $_FILES['p12']['name'];
	
	$p12_type = $_FILES['p12']['type'];
	
	$p12_tmp  = $_FILES['p12']['tmp_name'];
 	
 	$p12_ext  = pathinfo($p12_name,PATHINFO_EXTENSION);

 	$uploadOk = 1;
 	$cek = "./p12/cert.p12";
 	if(file_exists($cek)){
 		$uploadOk =0;
 	}

 	if(($p12_ext == "p12") && $uploadOk === 1) {
 		move_uploaded_file($p12_tmp, ("./p12/".$p12_name));
 		$_SESSION['valid'] = 'File berhasil diupload '.$uploadOk;
 		$_SESSION['idx'] += 1;
 	}
 	else {
 		$_SESSION['valid'] = 'File gagal divalidasi, tidak bisa diupload';
 	}
 	header('location:profil.php');
}
