<?php
require_once('connectpdo.php');
require_once('Bcrypt.php');
require_once('GetAll.php');
$gt=new GetAll();

if(isset($_POST['updatcust'])) {
	$error=array();
	$err=0;
	$cid=filter_input(INPUT_POST,'cid',FILTER_SANITIZE_NUMBER_INT);
	
	if(!isset($_POST['cpass']) || empty($_POST['cpass'])) {
	$error[0]="Enter Your Password";
	$err++;
	$arr=urlencode(serialize($error));
	$url = './settings.php?cid='.$cid.'&err='.$arr;
	header('Location:'.$url);	
	}
	else{

		$fnam=trim(filter_input(INPUT_POST,'cfname',FILTER_SANITIZE_STRING));
		$lnam=trim(filter_input(INPUT_POST,'clname',FILTER_SANITIZE_STRING));
		$mail=trim(filter_input(INPUT_POST,'cemail',FILTER_SANITIZE_STRING));
		$pass=trim(filter_input(INPUT_POST,'cpass',FILTER_SANITIZE_STRING));
	
	
		$fname=ucfirst($fnam);
		$lname=ucfirst($lnam);

	if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
		$error[1]="Invalid Email";
		$err++;
	}
	if(strlen($fname)<3 || strlen($lname)<3){
		$error[2]="Name Too Short<br/>";
		$err++;
	}

	if(strlen($pass)<6){
		$error[3]="Password too Short";
		$err++;
	}
	if(!isset($_POST['cnpass']) || empty($_POST['cnpass'])) {
		$npass=$pass;
	}
	if(isset($_POST['cnpass']) && !empty($_POST['cnpass'])) {
		$npass=trim(filter_input(INPUT_POST,'cnpass',FILTER_SANITIZE_STRING));
		if(strlen($npass)<6){
			$error[4]="Password too Short";
			$err++;
		}
	}	
	if(!$gt->checkPass($cid,"customer",$pass)){
		$error[5]="Invalid Password";
		$err++;
	}
	if($err>0){
	$arr=urlencode(serialize($error));
	$url = './settings.php?cid='.$cid.'&err='.$arr;
	header('Location:'.$url);
	}
	
	if($err==0){
	$hpass=Bcrypt::hash($npass);
	$sth=$dbh->prepare("update customer set firstname=?,lastname=?,email=?,pass=? where customerID=?");
	$sth->execute(array($fname,$lname,$mail,$hpass,$cid));
	header('Location:index.php?id='.$cid);
}
}
}




if(isset($_POST['updatman'])) {
	$error=array();
	$err=0;
	$mid=filter_input(INPUT_POST,'mid',FILTER_SANITIZE_NUMBER_INT);
	if(!isset($_POST['mpass']) || empty($_POST['mpass'])) {
	$error[0]="Enter Your Password";
	$err++;
	$arr=urlencode(serialize($error));
	$url = './settings.php?mid='.$mid.'&err='.$arr;
	header('Location:'.$url);
	}
	else{

		$fnam=trim(filter_input(INPUT_POST,'mfname',FILTER_SANITIZE_STRING));
		$lnam=trim(filter_input(INPUT_POST,'mlname',FILTER_SANITIZE_STRING));
		$mail=trim(filter_input(INPUT_POST,'memail',FILTER_SANITIZE_STRING));
		$pass=trim(filter_input(INPUT_POST,'mpass',FILTER_SANITIZE_STRING));
	
	
		$fname=ucfirst($fnam);
		$lname=ucfirst($lnam);

	if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
		$error[1]="Invalid Email";
		$err++;
	}
	if(strlen($fname)<3 || strlen($lname)<3){
		$error[2]="Name Too Short<br/>";
		$err++;
	}

	if(strlen($pass)<6){
		$error[3]="Password too Short";
		$err++;
	}if(isset($_POST['pofac']))
				$pbed=filter_input(INPUT_POST,'pbed',FILTER_SANITIZE_NUMBER_INT);
	if(!isset($_POST['mnpass']) || empty($_POST['mnpass'])) {
		$npass=$pass;
	}
	if(isset($_POST['mnpass']) && !empty($_POST['mpass'])) {
		$npass=trim(filter_input(INPUT_POST,'mnpass',FILTER_SANITIZE_STRING));
		if(strlen($npass)<6){
			$error[4]="Password too Short";
			$err++;
		}
	}	
	if(!$gt->checkPass($mid,"manager",$pass)){
		$error[5]="Invalid Password";
		$err++;
	}

	if($err>0){
	$arr=urlencode(serialize($error));
	$url = './settings.php?mid='.$mid.'&err='.$arr;
	header('Location:'.$url);
		}
	if($err==0){
	$hpass=Bcrypt::hash($npass);
	$sth=$dbh->prepare("update manager set firstname=?,lastname=?,email=?,pass=? where managerID=?");
	$sth->execute(array($fname,$lname,$mail,$hpass,$cid));
	header('Location:viewhotel.php?id='.$mid);
}
}
}





?>
