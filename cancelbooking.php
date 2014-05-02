<?php
require_once('StartSession.php');
require_once('connectpdo.php');
$dbh=createconn();

$k=0;
if(isset($_SESSION['clogged_in']) && $_SESSION['clogged_in']==1){
	if(isset($_POST['cancel'])){
		if(isset($_POST['custid'])){
			$custid=filter_input(INPUT_POST,'custid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
		if(isset($_POST['bookid'])){
			$bookid=filter_input(INPUT_POST,'bookid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
				
		if($k==2 && $custid==$_SESSION['cid']){
			echo $bookid;
			$sth=$dbh->prepare("delete from bookings where bookID=?");
			
			$sth->bindParam(1,$bookid,PDO::PARAM_INT);
			if($sth->execute()){
				$pth=$dbh->prepare("delete from payament where bookID=?");	
				$pth->bindParam(1,$bookid,PDO::PARAM_INT);
				$pth->execute();
				header('Location:./viewbookings.php?id='.$custid);
			}
			}
		}
	}
?>
