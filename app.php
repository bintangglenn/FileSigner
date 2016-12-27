<?php 
if (! $_POST) {echo "400 Bad Request"; die();} session_start();
if(isset($_FILES['document'])){
	$file_name = $_FILES['document']['name'];
	
	$file_size = $_FILES['document']['size'];

	$p12Content = file_get_contents("./p12/cert.p12");

	if(openssl_pkcs12_read($p12Content, $certs, $_POST['passwordP12'])){
		$p12_type = "test";
	}

	if($file_size > 1000000) {
		$file_size = round($file_size / 1048576, 2) . " MB";
	}
	else if($file_size > 1024) {
		$file_size = round($file_size / 1024, 2) . " KB";
	}
	else {
		$file_size .= " B";
	}
	
	$file_tmp = $_FILES['document']['tmp_name'];
 	
 	$file_type = $_FILES['document']['type'];
 	
 	$file_ext = pathinfo($file_name,PATHINFO_EXTENSION);

 	$time = date_create(null, timezone_open("Asia/Jakarta"));
 	$uploadTime = date_format($time, "d-m-Y H:m:s");
 	
 	if(($file_ext == "pdf" || $file_ext == "docx") && $file_size <= 4194304) {
 		//move_uploaded_file($file_tmp, ("./uploads/".$file_name));
 		
 		$_SESSION['valid'] = 'File berhasil diupload';
 		array_push($_SESSION['dataUpload'], "<tr><td>" . $file_name . "</td><td>" . $file_size . $certs['pkey'] ."</td><td>" . $uploadTime . "</td><td><form action=\"app.php\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" value=\"" . $file_name . "\" name=\"hapus\"/><input type=\"hidden\" value=\"" . $_SESSION['idx'] . "\" name=\"idxHapus\"/><input type=\"Submit\" value=\"Hapus\" name=\"submit\"/></form></td><td><form action=\"app.php\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" value=\"" . $file_name . "\" name=\"download\"/><input type=\"submit\" value=\"Download\" name=\"submit\"/></form></td>");
 		$_SESSION['idx'] += 1;
 	}
 	else {
 		$_SESSION['valid'] = 'File gagal divalidasi, tidak bisa diupload';
 	}
 	header("location: index.php");
}

if(isset($_POST['download'])) {
	header("Content-Type: application/pdf");
	header("Content-Transfer-Encoding: Binary");
	header("content-disposition: attachment; filename=\"" . $_POST['download'] . "\"");
	readfile("/uploads/" . $_POST['donwload']);
	header("location: index.php");
}

if(isset($_POST['hapus'])) {
	unlink("./uploads/" . $_POST['hapus']);
	unset($_SESSION['dataUpload'][$_POST['idxHapus']]);
	header("location: index.php");
}

function sign($file_name, $privateKey) {
	$data = file_get_contents($_FILES['document']);
	openssl_private_encrypt($data, $result, $privateKey);
	$data = $data . "SIGNATURE: " . $result;
	file_put_contents(("./uploads/".$file_name), $data);
}

function verify() {

}