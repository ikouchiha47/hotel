<?php
require_once('StartSession.php');
require_once('GetAll.php');

require_once('connectpdo.php');
$dbh=createconn();

$gt=new GetAll();
$hotelname=$city=$country=$des=$amm="";
$rooms=$hid=0;
if(isset($_SESSION['mid']) && $_SESSION['mlogged_in']==1) {
	if(isset($_POST['save'])) {
		if(isset($_POST['managrid']) && $_POST['managrid']==$_SESSION['mid']){
			
			$mid=$_SESSION['mid'];
			$k=0;
			if(isset($_POST['hotelname'])){
				$hotelname=filter_input(INPUT_POST,'hotelname');
				$k++;
			}
			if(isset($_POST['hotelid'])){
				$hid=filter_input(INPUT_POST,'hotelid',FILTER_SANITIZE_NUMBER_INT);
				$k++;
			}
			if(isset($_POST['rooms'])) {
				$rooms=filter_input(INPUT_POST,'rooms',FILTER_SANITIZE_NUMBER_INT);
				$k++;
			}
			if(isset($_POST['city'])){
				$city=filter_input(INPUT_POST,'city');
				$k++;
			}
			if(isset($_POST['country'])){
				$country=$_POST['country'];
				$k++;
			}
			
			if(isset($_POST['tags']) && !empty($_POST['tags'])) {
				
				//$tags=filter_input(INPUT_POST,'ammenities');
				$k++;
			}
			
			if(isset($_POST['descript'])){
				$des=filter_input(INPUT_POST,'descript');
				$k++;
			}
			
			
				if(isset($_POST['pofac'])) {
					$pofac=filter_input(INPUT_POST,'pofac',FILTER_SANITIZE_NUMBER_INT);
					$k++;
				}

				if(isset($_POST['pofnonac'])) {
					$pofnonac=filter_input(INPUT_POST,'pofnonac',FILTER_SANITIZE_NUMBER_INT);
					$k++;
				}

				if(isset($_POST['pofacdlx'])){
					$pofacdlx=filter_input(INPUT_POST,'pofacdlx',FILTER_SANITIZE_NUMBER_INT);
					$k++;
				}
			
			if($k==10){
				$amm="";
				foreach($_POST['tags'] as $tag){
					$amm.=$tag.',';
				}
				if($gt->checkManagerHasHotel($mid,$hid)){
					if($sth=$dbh->prepare("update hotels set name=?, country=?, city=?, rooms=?, description=?, tags=? where hotelID=?"))
						$sth->execute(array($hotelname,$country,$city,$rooms,$des,$amm,$hid));
						
						$gt->setPriceperBed($pofnonac,$pofac,$pofacdlx,$hid);
						header('Location:./viewhotel.php?id='.$mid);
					}
				}
			else {
				print_r('Fields were Missing.<br/>Yo Need To Go <a href="./viewhotel.php?id='.$mid.'">Back</a>');
			}
			
		}
	}}
?>
			
