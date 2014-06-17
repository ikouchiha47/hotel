<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<link rel="stylesheet" type="text/css" href="main.css"/>
<script type="text/javascript" src="./jquery10.min.js"></script>
</head>
<body>
<div class="topbar">
<span id="textleft">mybibo</span>

	<?php
	require_once('StartSession.php');
	require_once('connectpdo.php');
	$dbh=createconn();
	require_once('datepicker.php');
	require_once('getlocation.php');
	include('header.php');
	?>

</div>
<div id="container">
	 <div id="mainbar">
		<form method="post" action="showhotels.php">
		<table style="opacity:0.8;">
			<tr>
				<th colspan=2><span id="textleft">Book Hotels Online :-</span></th> 
			</tr><center>
			<tr>
				<td> Select Country</td>
				<td>
					<select name="country" id="country">
					<option selected value="" >Select Country</option>
					<?php		
								$selected_country=getcountries(1);
				    ?>
			      </select>
				</td>
			</tr>
			<tr>
				<td>Select City</td>
				<td>
					<select name="city" id="city">
						<option selected value="0">Select City</option>
						<?php
						getcities($selected_country);
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Check-In Date</td>
				<td><?php date_picker("checkin",date('Y'));?></td>
			</tr>
			<tr>
				<td>Check-Out Date</td>
				<td><?php date_picker("checkout",date('Y'),NULL,2);?></td>
			</tr>
			<tr>
			<td>Number of adults</td> <td><input type="text" name="c1" placeholder="specify the number only" required="required"></td>
			</tr>
			<tr>
			<td>Number of children</td> <td><input type="text" name="c2" placeholder="specify the number only"></td>
			</tr>
			<tr>
				<td><input type="submit" id="showhotels" name="showhotels" value="Show Hotels"/></td>
			</tr>
		</table>
		</form><br/>
			
	
		<a href="http://localhost/hotel/reservationpolicy.html">Reservation Policy>>>></a>
		</div>

   </div>
</div>
	
<?php include('footer.php');?>
<script type="text/javascript">
//$(window).ready(function(){});
$('#country').on('change',function(e){
	e.preventDefault();
	var cname=document.getElementById('country').value;
	if(cname=="")
		$('#city').html('<option value="">Select City</option>');
	else{
	$.get('getlocation.php',{get_cities:cname},function(res){
		$('#city').html(res);
		});
	}
});
</script>
</body>
</html>

