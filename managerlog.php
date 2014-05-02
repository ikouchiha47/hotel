<?php
require_once('connect.php');
require_once('GetAll.php');
require_once('Bcrypt.php');

$dbc=mysqli_connect(db_host,db_user,db_pass,db_name);

if(isset($_POST['login'])){
$mail=filter_input(INPUT_POST,'memail',FILTER_VALIDATE_EMAIL);
$pass=filter_input(INPUT_POST,'mpass',FILTER_SANITIZE_STRING);

$errmsg=array();
$err=0;

if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
	$error[0]="Invalid Email Address";
	$err++;
	}
else
{	$stmt=$dbc->prepare("select firstname,lastname,managerID,pass from manager where email=?");
	$stmt->bind_param('s',$mail);
	$stmt->execute();
	$stmt->bind_result($fname,$lname,$mid,$password);
	if($stmt->fetch()) {
		
	$stmt->close();
	if(Bcrypt::check($pass,$password))
	{	session_start();
		$_SESSION['mid']=$mid;
		$username=$fname.' '.$lname;
		$_SESSION['username']=$username;
		$_SESSION['mmail']=$mail;
		$_SESSION['mlogged_in']=true;
		setcookie("mid",$mid,time()+60*60*24*30);
		setcookie("username",$username,time()+60*60*24*30);
		setcookie("mmail",$mail,time()+60*60*24*30);
		$url='./viewhotel.php?id='.$mid;
		header('Location:'.$url);
	
	}
	else
	{	
		$error[1]="Invalid Combination";
		$err+=1;
	}
}
	else
	{
		$error[2]="Account Doesnot Exist";
		$err++;
	}
}

if($err>0){

$arr=urlencode(serialize($error));
$url = './managerlogin.php?id='.$arr;
header('Location:'.$url);
	}
}
else
print_r("Fields are missing. Go <a href='./managerlogin.php'>Back</a>");
