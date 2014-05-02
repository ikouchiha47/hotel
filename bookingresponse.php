<?php
require_once('StartSession.php');
require_once('GetAll.php');
$gt=new GetAll();
require_once('connectpdo.php');
$dbh=createconn();

$k=0;
if(isset($_SESSION['mlogged_in']) && $_SESSION['mlogged_in']==1){
	if(isset($_POST['submit'])){
		if(isset($_POST['managerid'])){
			$mid=filter_input(INPUT_POST,'managerid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
		if(isset($_POST['bookid'])){
			$bookid=filter_input(INPUT_POST,'bookid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
		if(isset($_POST['resp'])){
			$resp=filter_input(INPUT_POST,'resp');
			$k++;
		}
		if(isset($_POST['hotelid'])){
			$hid=filter_input(INPUT_POST,'hotelid',FILTER_SANITIZE_NUMBER_INT);
			$k++;
		}
		
		if($k==4 && $mid==$_SESSION['mid']){
			
			$sth=$dbh->prepare("select rooms from hotels where hotelID=?");
			$pth=$dbh->prepare("update bookings set confirm=? where bookID=?");
				$sth->bindParam(1,$hid,PDO::PARAM_INT);
				$sth->execute();
				
				if($res=$sth->fetch(PDO::FETCH_OBJ)){
					echo $k;
					$rooms=$res->rooms;
					$roomsbooked=$gt->RoomsBookedatHotel($hid);
					if($rooms>=$bookedrooms){
						if($pth->execute(array($resp,$bookid))){
							$qth=$dbh->prepare("update payament set status=? where bookID=?");
							$qth->execute(array($resp,$bookid));
							header('Location:./listings.php?id='.$mid);
						}
						}
					else
					header('Location:./listings.php?id='.$mid.'&res=00');
					
				}
			}
		}
	}
?>
