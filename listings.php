<?php
require_once('StartSession.php');
require('printing.php');
require_once('GetAll.php');
$gt=new GetAll();

require_once('connectpdo.php');
$dbh=createconn();

$mid=0;
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
	if(isset($_SESSION['mid']) && $_SESSION['mlogged_in']==1)
		$url="./index.php?id=".$_SESSION['mid'];
	else
		$url="./index.php";
	?>
	<a href="<?php echo $url;?>"><span id="textleft">mybibo</span></a>
	<?php include('header.php');?>
</div>
<div id="container">
	
		<div id="bookingcell">
			<table>
			<tr>
				<th colspan=7>Booking History
					<?php if(isset($_GET['res'])){
						$res=filter_input(INPUT_GET,'res',FILTER_SANITIZE_NUMBER_INT);
						?>
						<input type="hidden" id="waitedresp" value="<?php echo $res;?>"/>
						<?php }
						?>
				</th>
			</tr>
			<tr>
				<td>
					Customer Name 
				</td>
				<td>
					Rooms
				</td>
				<td>
					Room types
				</td>
				<td>
					Check-In
				</td>
				<td>
					Check-Out
				</td>
				<td>
					Response
				</td>
			</tr>
			<?php
			if(isset($_SESSION['mlogged_in']) && isset($_GET['id'])){
				$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
				if($id==$_SESSION['mlogged_in'])
					$mid=$id;
					$stat=0;
					
				$sth=$dbh->prepare("select bookID,hotelID,customerID,takenrooms,takenbeds,checkin,checkout from bookings where managerID=? and confirm=? order by bookdate desc");
				$sth->bindParam(1,$mid,PDO::PARAM_INT);
				$sth->bindParam(2,$stat,PDO::PARAM_INT);
				if($sth->execute()){
				while($res=$sth->fetch(PDO::FETCH_OBJ)){
					?>
					<tr>
						<td>
							<?php $cid=$res->customerID;
								$arr=$gt->getCustomerNamefromId($cid); print_r($arr[0]." ".$arr[1]);?></a>
						</td>
						<td>
							<?php print_r(printrint($res->takenrooms)); ?>
						</td>
						<td>
							<?php print_r(printrint($res->takenbeds)); ?>
						</td>
						<td>
							<?php print_r(printr($res->checkin)); ?>
						</td>
						<td>
							<?php print_r(printr($res->checkout)); ?>
						</td>
						<td>
							<form method="post" action="bookingresponse.php">
								<input type="hidden" name="bookid" value="<?php print_r($res->bookID);?>"/>
								<input type="hidden" name="managerid" value="<?php print_r($mid);?>"/>
								<input type="hidden" name="hotelid" value="<?php print_r($res->hotelID);?>"/>
								<input type="radio" name="resp" class="approve" value="1">Approve</input>
								<input type="radio" name="resp" value="2">Cancel</input>
								<input type="submit" name="submit" value="Go"/>
							</form>
						</td>
					</tr>
					<?php }} else print_r("Error in Accessing");}?>
				</table>
			</div>
		
	</div>
	<?php include('footer.php');?>
	<script type="text/javascript">
		$(window).on('load' ,function(e){
			e.preventDefault();
			var r=document.getElementById('waitedresp').value;
			if(r==00)
				{
					$('.approve').attr('disabled','disabled');
					alert("maximum customers approved");
				}
			else
				$('.approve').removAttr('disabled');
		});
			
	</script>
</body>
</html>
				
