<?php 
require_once('connect.php');
require_once('Bcrypt.php');
require_once('GetAll.php');
$dbc=mysqli_connect(db_host,db_user,db_pass,db_name);

if(isset($_POST['signup'])) {
	$fnam=trim(filter_input(INPUT_POST,'cfname',FILTER_SANITIZE_STRING));
	$lnam=trim(filter_input(INPUT_POST,'clname',FILTER_SANITIZE_STRING));
	$mail=trim(filter_input(INPUT_POST,'cemail',FILTER_SANITIZE_STRING));
	$pass=trim(filter_input(INPUT_POST,'cpass',FILTER_SANITIZE_STRING));

	$fname=ucfirst($fnam);
	$lname=ucfirst($lnam);
	$error=array();
	$err=0;
	$gall=new GetAll();

	if($gall->checkmail($mail))
	{
		$error[0]="Invalid Email<br/>";
		$err+=1;
	}
	if(!(preg_match('/^[a-z\d_\$\@]{3,50}$/i', $fname))  || !(preg_match('/^[a-z\d_\$\@]{3,50}$/i', $lname)) )
	{
		$error[1]="Invalid Name<br/>";
		$err++;
		}
	if(strlen($fname)<3 || strlen($lname)<3){
		$error[2]="Name Too Short<br/>";
		$err++;
	}

	if(strlen($pass)<6){
		$error[3]="Password Too Short";
		$err++;
	}
		
	if($err>0){
	$arr=urlencode(serialize($error));
	$url = './customersignup.php?err='.$arr;
	header('Location:'.$url);
		}
	else
	{
		$hpass=Bcrypt::hash($pass);
		$stmt=$dbc->prepare("insert into customer(firstname,lastname,email,pass) values(?,?,?,?)");
		//echo mysqli_error($dbc);
		$stmt->bind_param("ssss",$fname,$lname,$mail,$hpass);
		$stmt->execute();
		if(($stmt->affected_rows)>0)
			print_r("Registration Successfull. <br/>Click to <a href='./customerlogin.php'>Login</a>");
		else
		print_r("There was a Server Error.<br/><a href='./customerlogin.php'>Try Again</a>");
		$stmt->close();
	}
}
?>
