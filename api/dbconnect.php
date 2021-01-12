
<?php
	define("DBSERVER", "localhost");
	define("DBUSERNAME", "root");
	define("DBPASSWORD", "");
	define("DBNAME", "testdb");

	date_default_timezone_set("Asia/Ho_Chi_Minh");
	$conn = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
	$conn->set_charset("utf8");
	if ( !$conn) {
		die('Connect error: '.mysqli_connect_errno());
	}


// 	mysqli_connect("localhost","root","") or die("Khong the ket noi co so du lieu");
// 	mysqli_select_db("testdb") or die("Khong the chon co so du lieu");

?>
