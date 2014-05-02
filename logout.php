<?php
require_once('StartSession.php');

if(isset($_SESSION) && isset($_COOKIE)) {
 if(isset($_GET['mid']) && isset($_SESSION['mid'])){
	$mid=filter_input(INPUT_GET,'mid',FILTER_VALIDATE_INT);
	if($mid==$_SESSION['mid'])
		$uid=$mid;
	}
 if(isset($_GET['cid']) && isset($_SESSION['cid']))
	{
		$cid=filter_input(INPUT_GET,'cid',FILTER_VALIDATE_INT);
		if($cid==$_SESSION['cid'])
			$uid=$cid;
	}

if(isset($uid)) {
	setcookie("uid",NULL,time()-60*60*24*30);
	setcookie("username",NULL,time()-60*60*24*30);
	setcookie("mail",NULL,time()-60*60*24*30);
	setcookie("token",NULL,time()-60*60*24*30);
	setcookie("seriesID",NULL,time()-60*60*24*30);
	setcookie("session_id",NULL,time()-60*60*24*30);


unset($_SESSION['seriesID']);
unset($_SESSION['uid']);
unset($_SESSION['token']);
unset($_SESSION['username']);
unset($_SESSION['logged_in']);
$_SESSION=array();
session_destroy();
session_write_close();
echo 'looged out';
header('Location:./index.php');
}
}
?>
		
