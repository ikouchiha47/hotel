<?php
	if(isset($_SESSION['mlogged_in']) || isset($_SESSION['clogged_in'])) {
		
		if(isset($_SESSION['mlogged_in']) && $_SESSION['mlogged_in']==1){
			$mid=$_SESSION['mid'];
			
		?>
	<span id="textright"><a href="./logout.php?mid=<?php echo $mid; ?>">[Logout]</a> </span>
	<span id="textright"><a href="./settings.php?mid=<?php echo $mid; ?>">[Settings]</a> </span>
	<span id="textright"><a href="./transactions.php?id=<?php echo $mid;?>">[Transactions]</a></span>
	<span id="textright"><a href="./listings.php?id=<?php echo $mid;?>">[Bookings]</a></span>
	<span id="textright"><?php print_r($_SESSION['username']);?></span>
	<?php }
		elseif(isset($_SESSION['clogged_in']) && $_SESSION['clogged_in']==1) {
			$cid=$_SESSION['cid'];
			
			?>
		<span id="textright"><a href="./logout.php?cid=<?php echo $cid; ?>">[Logout]</a></span>
		<span id="textright"><a href="./settings.php?cid=<?php echo $cid; ?>">[Settings]</a></span>
		<span id="textright"><a href="./transactions.php?id=<?php echo $cid;?>">[Transactions]</a></span>
		<span id="textright"><a href="./viewbookings.php?id=<?php echo $cid?>">[ViewBookings]</a></span>
		<span id="textright"><?php print_r($_SESSION['cusername']);?></span>
		<?php
		}
	}
		else {?>
	<span id="textright"><a href="./managerlogin.php">Manager</a></span>
	<span id="textright"><a href="./customerlogin.php">My Account</a></span>
	<?php } 
	?>
