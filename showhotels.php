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
</head>
<body>
<div class="topbar">
	<?php
	if(isset($_SESSION['cid']) && $_SESSION['clogged_in']==1)
		$url="./index.php?id=".$_SESSION['cid'];
	else
		$url="./index.php";
	?>
	<a href="<?php echo $url;?>"><span id="textleft">mybibo</span></a>
	<?php include('header.php');?>
</div>
<div id="container" style="background-image:url('./dreamp2.jpg');background-size:100% 100%; background-repeat:no-repeat;">
	<div id="mainbar">
		
		<div  id="hotelcell">
					<?php
				
			$country=$city="";
			
			if(isset($_POST['showhotels'])){
				if(isset($_POST['country']))
					$country=$_POST['country'];
				if(isset($_POST['city']))
					$city=$_POST['city'];
				if(isset($_POST['checkinyear']) && isset($_POST['checkinday']) && isset($_POST['checkinmonth'])){
					$date = new DateTime();
					$date->setDate($_POST['checkinyear'], $_POST['checkinmonth'], $_POST['checkinday']);
					$_SESSION['checkindate']= $date->format('Y m,d');
				}
				if(isset($_POST['checkoutyear']) && isset($_POST['checkoutday']) && isset($_POST['checkoutmonth'])){
					$date = new DateTime();
					$date->setDate($_POST['checkoutyear'], $_POST['checkoutmonth'], $_POST['checkoutday']);
					$_SESSION['checkoutdate']=$date->format('Y m,d');
				}?>
		<table>
			<tr>
				<th colspan=4>
					<span id="textleft">Hotels Found</span></th>
			</tr>
			<tr>
			<td><b>Hotel</b></td>
			<td><b>Location</b></td>
			<td><b>Room Category</b></td>
			<td><b>Rating</b></td>
			
			</tr>
			
		<?php
				
				$obj=$gt->getHotelNames($country,$city);
				if($obj!=false){
					$objson=json_decode($obj);
					$constants=get_defined_constants(true);
					switch(json_last_error()){
						case JSON_ERROR_NONE:
							//$_COOKIE['hnames']=$objson->name;
							//print_r($_COOKIE['hnames']);
					foreach($objson as $ob){
						$hname=$ob->name;
						$rate=$ob->rating; 
						$hid=$ob->hotelID;
						$pbed=($gt->getPriceperBed($hid));
						?>
						<tr>
							<td>
								<h3><a href="./viewhotel.php?id=<?php echo $hid;?>"><?php print_r(ucfirst(printr($hname)))?></a></h3>
							</td>
							<td><?php print_r(ucfirst(printr($country).",".printr($city)));?></td>
							<td><?php if(($pbed->nonac)>0)
									print_r("Single Bed AC: ".printrint($pbed->nonac));?>
								<br/><?php if(($pbed->onac)>0)
									 print_r("Double Bed AC: ".printrint($pbed->onac));?>
								<br/><?php if(($pbed->acdelux)>0)
									 print_r("Three Bed AC: ".printrint($pbed->acdelux));?>
							</td>

							<td><?php echo $rate." "?>&#10030;</td>
							
						</tr>
					<?php	
						}
						
					break;
					
					case JSON_ERROR_DEPTH:
					print_r("Oops!! There was an error");
					break;
					case JSON_ERROR_SYNTAX:
					print_r("Oops!! We Faced a Syntax Error");
					break;
					case JSON_ERROR_UTF8:
					print_r("Oops!! Recieved Malformed Charrecters");
					break;
					default:
					print_r("Oops!! There was an Unxpected Error");
					break;
				}}?>
				
				
		
		
		
	</table>
	</div>
	<br><br><br><br><br><br><script src="http://h1.flashvortex.com/display.php?id=2_1375469195_56655_260_0_577_85_6_1_68" type="text/javascript"></script></center>
	</div>
	<div id="sidebar">
		<font color="#6A5ACD"><p><h3>Refine Search</h3></p>
		<p><h4>Search By</h4></p>
		
		
			
			<p>Rating</p>
			<p>
				<select id="rated" name="rated">
					<option value="">Select Rating</option>
				<?php for($i=1;$i<=6;$i++)
						print_r('<option value="'.$i.'">'.$i.'</option>');
				?>
			</select>
			</p>
			<p>Amenities</p>
			<p>
				<?php $rth=$dbh->prepare("select tagid,tagname from taglist");
					  $rth->execute();
					  while($ress=$rth->fetch(PDO::FETCH_OBJ)){
							?>
					<div><input type="checkbox" name="tagg[]" value="<?php print_r($ress->tagid);?>"><?php print_r($ress->tagname);?></input></div>
							<?php
								}
							?>
			</p>
			<!--<p>Price/Bed</p>
			<input type="text" id="ppbed" name="ppbed"/>-->
			
			<input type="button" id="search" name="search" value="Search"/>
		</font>
	<?php
			}
			else
				header('Location:./index.php');
		?>
	</div>
</div>

<script type="text/javascript">
	var tags=rates=pbed="";
	$('input').on('change', function() {
    tags = $('input:checked').map(function() {
        return this.value;
    }).get();
});
	$('#rated').on('change',function(){
		 rates=$('#rated').val();
	});
	$('#ppbed').on('change',function(){
		 pbed=$('#ppbed').val();
	});
	
	$('#search').on('click',function(e){
		e.preventDefault();
		$.post('hotelsearch.php',{rate:rates,tag:tags,ppbed:pbed},function(res){
			$('#hotelcell').html(res);
		});
		
		
	});
	
	
</script>
</body>
</html>

