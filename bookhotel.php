<?php
require_once('StartSession.php');
require_once('GetAll.php');

require_once('connectpdo.php');
$dbh=createconn();

$gt=new GetAll();
$checkindate=$checkoutdate="";
$bperoom="";
$cid=$mid=$hid=0;
$k=0;
$err=array();
$errc=0;
if(isset($_SESSION['cid']) && $_SESSION['clogged_in']==1) {
	if(isset($_POST['book'])) {
		//print_r($_POST);
		//print_r($_SESSION);
		if(isset($_POST['hotelid'])){
			$hid=filter_input(INPUT_POST,'hotelid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
			}
		if(isset($_POST['managerid'])){
			$mid=filter_input(INPUT_POST,'managerid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
			}
		if(isset($_POST['customerid'])){
			$cid=filter_input(INPUT_POST,'customerid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
			}
		if(isset($_POST['nofrooms'])){
			$nrooms=filter_input(INPUT_POST,'nofrooms',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
		
		if(isset($_POST['nofnonac'])) {
			$pofnonac=filter_input(INPUT_POST,'nofnonac',FILTER_SANITIZE_NUMBER_INT);
			if(empty($_POST['nofnonac']))
				$pofnonac=0;
			$k++;
		}
		if(isset($_POST['nofac'])) {
			$pofac=filter_input(INPUT_POST,'nofac',FILTER_SANITIZE_NUMBER_INT);
			if(empty($_POST['nofac']))
				$pofac=0;
			$k++;
		}

		if(isset($_POST['nofacdlx'])){
			$pofacdlx=filter_input(INPUT_POST,'nofacdlx',FILTER_SANITIZE_NUMBER_INT);
			if(empty($_POST['nofacdlx']))
				$pofacdlx=0;
			$k++;
		}
		if(isset($_SESSION['checkindate']) && isset($_SESSION['checkoutdate'])){
			$checkindate=$_SESSION['checkindate'];
			$checkoutdate=$_SESSION['checkoutdate'];
			$k++;
		}
		//print_r($k);
		if($pofnonac>3 || $pofac>3 || $pofacdlx>3)
			{ $err[2]="Maximum 3 Beds per Room Allowed";
				$errc++;
				}
		if(($pofnonac+$pofac+$pofacdlx)!=$nrooms) 
		{ 
		$err[3]="rooms mismatched"; 
		$errc++; 
		} 
		if($k==8 && $errc==0) {
			
			
			$resp=$gt->checkHotelBookedOnce($hid,$cid,0);
			$beds=$pofnonac+$pofac+$pofacdlx;
			$bperoom=$pofnonac.','.$pofac.','.$pofacdlx;
			$bs=preg_split('/[\,]/',$bperoom);
			$l=count($bs);
			/*$countbs=$amount=0;
			for($i=0;$i<$l;$i++){
				if($bs[$i]>0)
				$countbs++;
				}
			print_r($bs);
			print_r("<br/>".$countbs.">>".$nrooms.">>".$resp);
			$price=$gt->getPriceofRooms($hid);
			print_r($price);
			for($j=0;$j<$l;$j++)
				$amount+=($bs[$j]*$price[$j]);
			print_r($amount);*/
			if($beds==$nrooms && $resp==1){
			$sth=$dbh->prepare("INSERT INTO `bookings` (`hotelID`, `customerID`, `managerID`, `takenrooms`, `takenbeds`, `checkin`, `checkout`,`bookdate`) VALUES(?,?,?,?,?,?,?,?)");
			if($sth->execute(array($hid,$cid,$mid,$nrooms,$bperoom,$checkindate,$checkoutdate,date('Y-m-d')))){
				$pth=$dbh->prepare("update hotels set rating=? where hotelID=?");
				$currentbooks=$gt->getNumberofBookings($hid);
				if(($currentbooks/5)<=0)
					$rating=1;
				if(($currentbooks/5)>0)
					$rating=$currentbooks/5;
				if($pth->execute(array($rating,$hid)))
					{
						$bid=$gt->getBookid($hid,$cid);
						$stat=1;
						$amount=0;
						$price=$gt->getPriceofRooms($hid);
						print_r($price);
						print_r("<br/>");
						print_r($bs);
						for($j=0;$j<$l;$j++)
							$amount+=($bs[$j]*$price[$j]);
						print_r($amount);
						$qth=$dbh->prepare("insert into payment(bookID,customerID,managerID,payable,status) values (?,?,?,?,?)");
						$qth->execute(array($bid,$cid,$mid,$amount,$stat));
						header('Location:./viewbookings.php?id='.$cid);
						
					}
				else print_r("Update error");
				
		}
		else print_r("Insert error");
	}
	else{
		$err[0]="A booking is already pending or Rooms Mismatch";
		$errc++;
		} 
	  }
    }
  }
  else
  {$err[1]='Please LogIn to Book Hotel';$errc++;}
  
  if($errc>0){
	  if(count($err)>0)
	  {
		  $arr=urlencode(serialize($err));
		  $url = './viewhotel.php?id='.$_POST['hotelid'].'&err='.$arr;
	  }
	  else
	  $url = './viewhotel.php?id='.$_POST['hotelid'];
	  
	  header('Location:'.$url);
  }

?>
	
	
