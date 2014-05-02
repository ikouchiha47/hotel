<?php 

	define('db_host',"localhost");
	define('db_user',"root");
	define('db_name',"hotelbook");
	define('db_pass',"");
	$dbc=mysqli_connect(db_host,db_user,db_pass,db_name) or die("Connect error");
	//print_r( $dbc);
mysqli_select_db($dbc,db_name) or die("database connect error");

?>

