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
<div id="container"  style="background-image:url('resort1.jpg');">
	 <div id="mainbar">
		<center><script src="http://h1.flashvortex.com/display.php?id=2_1375470086_62943_364_0_450_67_9_1_68" type="text/javascript"></center></script>
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
		</form><br><br><br><br><br>
		<table><tr><td><img src="http://gos3.ibcdn.com/gpmsqo5a354pffa4dn7qk6940042.jpg" width="200" height="200"></td> <td><img src="http://gos3.ibcdn.com/cdvu888l5t33dc15lsl8unt9002n.gif" width="200" height="200"></td> <td><img src="http://gos3.ibcdn.com/enjh67ot5p4s93i5too3lt5h001b.gif" width="200" height="200"></td> <td><img src="http://gos3.ibcdn.com/p34robmsu10a98510sdebl860055.gif" width="200" height="200"></td></tr>
	<tr><td><b>Hotels in Bangalore</b></td> <td><b>Hotels in Delhi</b></td> <td><b>Hotels in Kolkata</b></td> <td><b>Hotels in Mumbai</b></td></tr>
	<tr><td>Maple Whitefield-1200</td> <td>Hotel Southern-2200</td> <td>The Pride Hotel-3500</td> <td>The Orchid-9500</td></tr>
	<tr><td>Peridot Inn-1100</td> <td>Hotel Garden View-2300</td> <td>Hotel Diplomat-2900</td> <td>Milan International-5600</td></tr>
	<tr><td><a href ="http://www.goibibo.com/hotels/hotels-in-bangalore/">All Bangalore hotels</a></td> <td><a href ="http://www.goibibo.com/hotels/hotels-in-new-delhi/">All Delhi hotels</a></td> <td><a href="http://www.goibibo.com/hotels/hotels-in-kolkata/">All Kolkata hotels</td> <td><a href="http://www.goibibo.com/hotels/hotels-in-mumbai/">All Mumbai hotels</td></tr>
	</table><br>	
	<a href="https://www.facebook.com/">Follow us>>>></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="http://localhost/hotel/reservationpolicy.html">Reservation Policy>>>></a>
		</div>
		
	<div id="sidebar"><i><center>Advertisement</i></center>
	<script src="http://h1.flashvortex.com/display.php?id=2_1375469727_1798_507_0_215_74_9_1_68" type="text/javascript"></script><br><br><br>
	<marquee scrollamount="15" direction="up" behavior="alternate"><center><img src="http://www.animated-pictures.net/pictures/Vehicles/planefly.gif"></center></marquee></marquee>
	<a href="http://hotel.makemytrip.com/makemytrip/site/hotels/detail?city=BOM&country=IN&checkin=date_5&checkout=date_7&roomStayQualifier=1e0e&hotelId=200709141341578986&intid=336x280-HotelBAWAhtl_herohotel_16072013" target="_top" >
<img src="http://pagead2.googlesyndication.com/simgad/12246474011235377883" width="225" height="150" alt="null" border="0"></a><br><br><br>




	
	</div></div>



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

