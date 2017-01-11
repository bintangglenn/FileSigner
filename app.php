<?php 
if (! $_POST) {echo "400 Bad Request"; die();} session_start();
if(isset($_FILES['file']) && isset($_FILES['cert'])) {
	$file_name = $_FILES['file']['name'];
	$cert_name = $_FILES['cert']['name'];
	
	$file_tmp = $_FILES['file']['tmp_name'];
	$cert_tmp = $_FILES['cert']['tmp_name'];
 	
 	$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
 	$cert_ext = pathinfo($cert_name, PATHINFO_EXTENSION);

 	$multiple = false;
 	foreach ($_SESSION['dataUpload'] as $value) {
 		if(strpos($value, $file_name) !== false) {
 			$multiple = true;
 			$_SESSION['valid'] = 'There exists a file with same name';
 		}
 	}

 	move_uploaded_file($cert_tmp, ("./tmp/" . $cert_name));
 	move_uploaded_file($file_tmp, ("./tmp/" . $file_name));

 	if($cert_ext == "p12" || $cert_ext == "pem") {
		if($cert_ext == "p12") {
	 		exec('openssl pkcs12 -in ' . '"./tmp/' . $cert_name . '" -out ' . '"./tmp/' . substr($cert_name, 0, -4) . '.pem" -passin pass:' . $_POST['pass'] . ' -passout pass:' . $_POST['pass']);
	 		unlink("./tmp/" . $cert_name);
	 		$cert_name = substr($cert_name, 0, -4) . ".pem";
	 	}

	 	if($_POST['submit'] == "sign" && !$multiple) {
	 		$out = shell_exec('openssl dgst -sha256 -sign "./tmp/' . $cert_name . '" -out "./signature/' . $file_name . '.sha256" -passin pass:' . $_POST['pass'] . ' "./tmp/' . $file_name . '" 2>&1');
	 		if(empty($out)) {
		 		$tmp = "key" . $_SESSION['idx'];
		 		$_SESSION['dataUpload'][$tmp] = "<tr><td>" . $file_name . "</td><td style='text-align: center;'><form action=\"app.php\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" value=\"" . $file_name . ".sha256\" name=\"hapus\"/><input type=\"hidden\" value=\"" . $_SESSION['idx'] . "\" name=\"idxHapus\"/><input type=\"Submit\" value=\"Delete\" name=\"submit\"/></form></td>";
		 		$_SESSION['idx'] += 1;
		 		$_SESSION['valid'] = 'Sign Success!';
		 	} else {
		 		$_SESSION['valid'] = 'There is an error while signing';
		 	}
	 	}
	 	else if($_POST['submit'] == "verify") {
	 		if($multiple) {
		 		exec('openssl x509 -in "./tmp/' . $cert_name . '" -pubkey -noout > "./tmp/' . $file_name . '.pub"');
	 			$out = shell_exec('openssl dgst -sha256 -verify "./tmp/' . $file_name . '.pub" -signature "./signature/' . $file_name . '.sha256" "./tmp/' . $file_name . '"');
		 		$_SESSION['valid'] = $out;
		 	}
		 	else {
		 		$_SESSION['valid'] = "File not signed";
		 	}
	 	}
	} else {
		$_SESSION['valid'] = "Unsupported certificate format";
	}

	unlink("./tmp/" . $file_name . ".pub");
 	unlink("./tmp/" . $cert_name);
 	unlink("./tmp/" . $file_name);
 	header("location: index.php");
}

if(isset($_POST['hapus'])) {
	unlink("./signature/" . $_POST['hapus']);
	$tmp = "key" . $_POST['idxHapus'];
	unset($_SESSION['dataUpload'][$tmp]);
	header("location: index.php");
}
