<?php
require_once('StartSession.php');
require('printing.php');

require_once('GetAll.php');
$gt=new GetAll();

require_once('connectpdo.php');
$dbh=createconn();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
<script type="text/javascript" src="./jquery10.min.js"></script>
<meta http-equiv="refresh" content="30">
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


<div id="container">
	
		<div id="bookingcell">
			<table>
				<tr>
					<th colspan=6><span id="textleft">Transaction History</span></th>
				</tr>
				
					<?php 
						if(isset($_SESSION['mid']) && isset($_SESSION['mlogged_in'])){
							$mid=$_SESSION['mid'];
							
							$sth=$dbh->prepare("select bookID,customerID,payable,status from payment where managerID=?");
							$sth->bindParam(1,$mid,PDO::PARAM_INT);
							$sth->execute();
						while($res=$sth->fetch(PDO::FETCH_OBJ)){
							?>
						<tr>
							<td><?php
									$hid=$gt->getHotelfromManager($mid);
									$obj=$gt->getHotelNamefromId($hid);
									print_r(printr($obj->name));
								?>
							</td>
							<td>
								<?php print_r(printrint($res->payable)); ?>
							</td>
							<td>
								<?php
									$stat=printrint($res->status);
									if($stat==1)
										print_r("Paid in Full");
									if($stat==2)
										print_r("Money Paybacked");
								?>
							</td>
						</tr>
						<?php }} 
					
					if(isset($_SESSION['cid']) && isset($_SESSION['clogged_in'])){
							
							$sth=$dbh->prepare("select bookID,managerID,payable,status from payment where customerID=?");
							$sth->bindParam(1,$cid,PDO::PARAM_INT);
							$sth->execute();
						while($res=$sth->fetch(PDO::FETCH_OBJ)){
							?>
						<tr>
							<td><?php
									$hid=$gt->getHotelfromManager($res->managerID);
									$obj=$gt->getHotelNamefromId($hid);
									print_r(printr($obj->name));
								?>
							</td>
							<td>
								<?php print_r(printrint($res->payable)); ?>
							</td>
							<td>
								<?php
									$stat=printrint($res->status);
									if($stat==1)
										print_r("Paid in Full");
									if($stat==2)
										print_r("Money Paybacked");
								?>
							</td>
							<td>
								<?php print_r($gt->getBookDatefrimId($res->bookID));?>
							</td>
						</tr>
						<?php }}
						?>
				</table>
			</div>
		</div>
		<?php include('footer.php');?>
	</body>
</html>
