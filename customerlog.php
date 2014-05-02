<?php
require_once('connect.php');
require_once('GetAll.php');
require_once('Bcrypt.php');

$dbc=mysqli_connect(db_host,db_user,db_pass,db_name);

if(isset($_POST['login'])){
$mail=filter_input(INPUT_POST,'cemail',FILTER_VALIDATE_EMAIL);
$pass=filter_input(INPUT_POST,'cpass',FILTER_SANITIZE_STRING);

$error=array();
$err=0;

if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
	$error[0]="Invalid Email Address";
	$err++;
	}
else
{	$stmt=$dbc->prepare("select firstname,lastname,customerID,pass from customer where email=?");
	$stmt->bind_param('s',$mail);
	$stmt->execute();
	$stmt->bind_result($fname,$lname,$cid,$password);
	if($stmt->fetch()) {
		
	$stmt->close();
	if(Bcrypt::check($pass,$password))
	{	session_start();
		$_SESSION['cid']=$cid;
		$username=$fname.' '.$lname;
		$_SESSION['cusername']=$username;
		$_SESSION['cmail']=$mail;
		$_SESSION['clogged_in']=true;
		setcookie("cid",$mid,time()+60*60*24*30);
		setcookie("cusername",$username,time()+60*60*24*30);
		setcookie("cmail",$usrMail,time()+60*60*24*30);
		
		$url='./index.php?id='.$cid;
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
$url = './customerlogin.php?err='.$arr;
header('Location:'.$url);
	}
}
else
print_r("Fields are missing. Go <a href='./customerlogin.php'>Back</a>");
