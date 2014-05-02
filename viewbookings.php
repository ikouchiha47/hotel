<?php
require_once('StartSession.php');
require('printing.php');
require_once('GetAll.php');
$gt=new GetAll();

require_once('connectpdo.php');
$dbh=createconn();

$cid=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
<script type="text/javascript" src="./jquery10.min.js"></script>
</head>
<body>
<div class="topbar">
	<?php
	if(isset($_SESSION['cid']) && $_SESSION['clogged_in']==1){
		$cid=$_SESSION['cid'];
		$url="./index.php?id=".$cid;
		
	}
	
	else
		$url="./viewhotel.php?id=".filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
	?>
	<a href="<?php echo $url;?>"><span id="textleft">mybibo</span></a>
	<?php include('header.php');?>
</div>
<div id="container" style="background-image:url('./dreamp3.jpg');">
	
		<div id="bookingcell">
			<table>
			<tr>
				<th colspan=8>Booking History</th>
			<tr>
			<tr>
				<td>
					Hotel 
				</td>
				<td>
					Rooms
				</td>
				
				<td>
					Check-In
				</td>
				<td>
					Check-Out
				</td>
				<td>
					Status
				</td>
				<td>
					Amount
				</td>
				<td>
					Cancel Booking
				</td>
			</tr>
			<?php
			if(isset($_SESSION['clogged_in']) && isset($_GET['id'])){
				$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
				if($id==$_SESSION['clogged_in'])
					$cid=$id;
				$sth=$dbh->prepare("select bookID,hotelID,managerID,takenrooms,takenbeds,checkin,checkout,confirm from bookings where customerID=? order by bookdate desc");
				//echo $cid;
				$sth->bindParam(1,$cid,PDO::PARAM_INT);
				if($sth->execute()){
				while($res=$sth->fetch(PDO::FETCH_OBJ)){
					?>
					<tr>
						<td>
							<?php $hid=printrint($res->hotelID) ;?><a href="./viewhotel.php?id=<?php echo $hid ;?>">
							<?php $obj=$gt->getHotelNamefromId($hid); print_r("".$obj->name);?></a>
						</td>
						<td>
							<?php print_r(printrint($res->takenrooms)); ?>
						</td>
						
						<td>
							<?php print_r(printr($res->checkin)); ?>
						</td>
						<td>
							<?php print_r(printr($res->checkout)); ?>
						</td>
						<td>
							<?php
								$stat=printrint($res->confirm);
								if($stat==0) print_r("Waiting Confirmation");
								elseif($stat==1) print_r("Confirmed");
								else print_r("Disapproved");
							?>
						</td>
						<td>
							<?php print_r($gt->getAmountPayable($res->bookID));?>
						</td>
						<td>
							<form method="post" action="cancelbooking.php">
								<input type="hidden" name="bookid" value="<?php print_r($res->bookID);?>"/>
								<input type="hidden" name="custid" value="<?php print_r($cid);?>"/>
								<input type="submit" name="cancel" value="Cancel"/>
							</form>
						</td>
					</tr>
					<?php }} else print_r("Your Account has been Removed");}?>
				</table>
			</div>
		
	</div>
	<?php include('footer.php');?>
</body>
</html>
				
