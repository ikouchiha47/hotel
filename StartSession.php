<?php

class StartSession {
	
	private $is_set;
	private $is_cookie;
	function isSessionSet(){
		session_start();
		global $is_set;
		$is_set=false;
		if( isset($_SESSION['uid']) && isset($_SESSION['username'])){
			$is_set=true;
		}
		return $is_set;
}
	function setSessionFromCookie(){
		global $is_cookie;
		$is_cookie=false;
		if(isset($_COOKIE['uid']) &&  isset($_COOKIE['username']))
		{ 
			if(isset($_COOKIE['uid']) && !(isset($_SESSION['uid'])))
			{
				$_SESSION['uid']=$_COOKIE['uid'];
				$is_cookie=true;
			}
			else
			$is_cookie=false;
			

			if(isset($_COOKIE['username']) && !(isset($_SESSION['username'])))
			{
				$_SESSION['username']=$_COOKIE['username'];
				$is_cookie=true;
			}
			else
			$is_cookie=false;
			
	}
	return $is_cookie;
}
}

$session_start=new StartSession();
$res=(bool)$session_start->isSessionSet();

if(!$res)
{
$set_cookie=(bool)$session_start->setSessionFromCookie();
if($set_cookie)
$session_start->isSessionSet();
}


?>
