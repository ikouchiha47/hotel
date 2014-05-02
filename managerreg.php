<?php 
require_once('connect.php');
require_once('Bcrypt.php');
require_once('GetAll.php');
$gt=new GetAll();
$dbc=mysqli_connect(db_host,db_user,db_pass,db_name);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
</head>
<body>
<div class="topbar">
<a href="./index.php"><span id="textleft">mybibo</span></a>
</div>
<div id="container">
	 <div id="mainbar">
		 <?php
if(isset($_POST['signup'])) {
	$fnam=trim(filter_input(INPUT_POST,'mfname',FILTER_SANITIZE_STRING));
	$lnam=trim(filter_input(INPUT_POST,'mlname',FILTER_SANITIZE_STRING));
	$mail=trim(filter_input(INPUT_POST,'memail',FILTER_SANITIZE_STRING));
	$pass=trim(filter_input(INPUT_POST,'mpass',FILTER_SANITIZE_STRING));
	
	$fname=ucfirst($fnam);
	$lname=ucfirst($lnam);
	$errmsg=array();
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
	$url = './managersignup.php?id='.$arr;
	header('Location:'.$url);
		}
	else
	{
		$hpass=Bcrypt::hash($pass);
		$stmt=$dbc->prepare("insert into manager(firstname,lastname,email,pass) values(?,?,?,?)");
		//echo mysqli_error($dbc);
		$stmt->bind_param("ssss",$fname,$lname,$mail,$hpass);
		$stmt->execute();
		if(($stmt->affected_rows)>0)
			{
				$stmt->close();
				$mid=$gt->getManagerIdfromEmail($mail);
				$ptmt=$dbc->prepare("insert into hotels (managerID) values(?)");
				$ptmt->bind_param('d',$mid);
				if($ptmt->execute()){
					$ptmt->close();
					$hid=$gt->getHotelfromManager($mid);
					$rtmt=$dbc->prepare("insert into priceofbeds (hotelID) values(?)");
					$rtmt->bind_param('d',$hid);
					if($rtmt->execute())
						$rtmt->close();

				print_r("Registration Successfull. <br/>Click to <a href='./managerlogin.php'>Login</a>");
			}
			}
		else
		{print_r("There was a Server Error.<br/><a href='./managersignup.php'>Try Again</a>");
		$stmt->close();}
	}
}
?>
</div>
</div>
</body>
</html>
