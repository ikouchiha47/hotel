<?php
require_once('StartSession.php');
require_once('GetAll.php');
require_once('connectpdo.php');
require_once('getlatlong.php');
require_once('getlocation.php');
require('printing.php');
$dbh=createconn();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
<script type="text/javascript" src="./jquery10.min.js"></script>
<script type="text/javascript" src="./googlemap.js"></script>
<script type="text/javascript" src="./gmap3.min.js"></script>
</head>

<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="" >
<div class="topbar">

	
	<?php $mid=0; 
	if(isset($_SESSION['mid'])) {
		 $cmid=$mid=$_SESSION['mid'];
		 $url="./viewhotel.php?id=".$cmid; 
		 }
	elseif(isset($_SESSION['cid'])){
		$cmid=$cid=$_SESSION['cid'];
		$url="./index.php?id=".$cmid;
		}
		else
		$url="index.php";?>
	
	
<a href="<?php echo $url;?>"><span id="textleft">mybibo</span></a>
	
	<?php include('header.php');?>
	
</div>
<div id="container" style="background-image:url('./dreamp2.jpg');background-size:100% 100%; background-repeat:no-repeat;">
	<div id="mainbar">
	<!--<br><center><a href="index.php">Back to Home</a></center>-->
	<?php
	$gt=new GetAll();
	//print_r($_SESSION);
	  if(isset($_GET['err'])) {
			  $arr=filter_input(INPUT_GET,'err');
		  $obj=unserialize(urldecode($arr));
					foreach($obj as $ob){
						print_r(printr($ob)."<br/>");
					}
				}
		  
		  
	$is_manager=false;
	if(isset($_GET['id'])){

		$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
		if(isset($_SESSION['mid'])){
			if($id==$_SESSION['mid']){
			$mid=$_SESSION['mid'];
			$is_manager=true;
		}
			else {
				$mid=$gt->getManagerfromHotel($id);
				$is_manager=false;
			}
		}
	 else
			 {
				 if($gt->checkManagerofHotel($id))
					$mid=$gt->getManagerfromHotel($id);
				else
					print_r("Sorry!! This Hotel Doesnot Exist");
				}
			if(isset($_SESSION['mid']) && $_SESSION['mid'] >0){
			?>
			<form method="post" action="edithotel.php">
			<?php }
			elseif(isset($_SESSION['cid']) && $_SESSION['cid']>0){
			?>
			<form method="post" action="bookhotel.php">
			<?php }
			else
			?>
			<form method="post" action="">
			<?php
				$sth=$dbh->prepare("select hotelID,name,country,city,rooms,rating,description,tags from hotels where managerID=?");
				$sth->bindParam(1,$mid,PDO::PARAM_INT);
				$sth->execute();
				if($res=$sth->fetch(PDO::FETCH_OBJ)){
				
					?>
					<table cellpadding=4>
				<tr>
					<th colspan=4><span id="textleft">Hotel</span>
					<span id="textleft">
						
						<?php print_r(printr($res->name)); ?>
						    <input type="hidden" name="managerid" value="<?php print_r($mid);?>"/>
							<input type="hidden" name="hotelid" value="<?php print_r($res->hotelID); ?>"/>
							<input type="hidden" name="hname" value="<?php print_r(ucfirst(printr($res->name))); ?>"/>
						
						</span>
					<span id="textright">
						
						Rated<?php print_r(' '.printrint($res->rating))?>&#10030;
						</span>
					</th>
				</tr>			
				<tr>
					<td>
						Location
					</td>
					<td>
						<?php $country=ucfirst(printr($res->country)); 
							  $city=ucfirst(printr($res->city));
							if(!empty($country) && !empty($city)){
							  $location=$city.",".$country;
							  print_r('<span id="locationcell">'.printr($location).'</span>');
							  $cords=getlatlong($location);
							  if($cords===false)
								$cords=array("lat"=>0,"lon"=>0);
							}
							else
							$cords=array("lat"=>0,"lon"=>0);
							
							  foreach($cords as $key=>$value)
							  print_r('<input type="hidden" id="'.printr($key).'" value="'.printrint($value).'"/>');
							  ?>
						<a href="#" id="showmap" name="showmap" style="float:right;">Showmap</a>
						<input type="hidden" name="country" id="country" value="<?php print_r(ucfirst($country)); ?>"/>
						<input type="hidden" name="city" id="city" value="<?php print_r(ucfirst($city)); ?>"/>
						
					</td>
				</tr>
				
				<tr>
					<td>
						Rooms Available
					</td>
					<td>
						<?php $roomsbooked=$gt->RoomsBookedatHotel($res->hotelID);
							  $roomsleft=($res->rooms)-$roomsbooked;
							  if($roomsleft>0)
								print_r('<span id="roomscell">'.printrint($roomsleft).' of '.printrint($res->rooms).'</span>');
							else
								print_r('<span id="roomscell">None</span>');
							  ?>
						<input type="hidden" name="rooms" value="<?php print_r(printrint($res->rooms));?>"/>
					
					</td>
				</tr>
				<tr>
					<td>
						About Us
					</td>
					<td>
						<?php print_r(printr($res->description));?>
						<input type="hidden" name="descript" value="<?php print_r(printr($res->description));?>"/>
					</td>
				</tr>
				<tr>
					<td>
						Ammenities
					</td>
					<td>
					
							
						<?php
							$amm=$res->tags;
							$objs=preg_split('/[\,]/',$amm);
							$pth=$dbh->prepare("select tagid,tagname from taglist");
								$pth->execute();
								while($ress=$pth->fetch(PDO::FETCH_OBJ)){
									foreach($objs as $obj){
										
										if($obj==($ress->tagid)){
											?>
											<p id="tags" style="color:#1D3678;font-weight:bold;margin:3px;"><?php print_r($ress->tagname);?></p>
											<input type="hidden" name="ammenities[]" value="<?php print_r($ress->tagid);?>"/>
						<?php
					}
				}
			}
						?>
							

					</td>
				</tr>
				<?php
				if(isset($_SESSION['clogged_in']) && $_SESSION['clogged_in']==1){
					?>
				<tr>
					<td>Rooms</td>
					<td>
						<?php
							if($roomsleft>0)
							?>
							<select name="nofrooms" id="nofrooms">
							<option selected value=1>1</option>
							<option value=2>2</option>
							<option value=3>3</option>
							</select>
						<?php if($roomsleft==0) print_r('No vacancies'); ?>
								
					</td>
					
				</tr>
				
				<tr>
					<td><h3>Rooms</h3></td></tr>
				<tr>
					<td> Total Number of persons</td> <td><input type="text" name="num" placeholder="specify number of members"></td></tr>	
					<td> SingleBed AC</td>
					
					<td><input type="text" name="nofnonac" id="nofnonac" class="bperoom" placeholder="leave blank if not required" maxlength=1/>
					</td>
				</tr>
				<tr>
					<td>DoubleBed AC</td>
					
					<td><input type="text" name="nofac" id="nofac" class="bperoom" placeholder="leave blank if not required"  maxlength=1/></td>
				
				</tr>
				<tr>
					<td>ThreeBed AC</td>
					
					<td><input type="text" name="nofacdlx" id="nofacdlx" class="bperoom" placeholder="leave blank if not required"  maxlength=1/>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td>
						<h3>Room types</h3>
					</td>
				</tr>
				
					<?php 
						
						$bed=$gt->getPriceperBed($res->hotelID);
						
							$pofnonac=$bed->nonac;
							$pofac=$bed->onac;
							$pofacdlx=$bed->acdelux;
							 ?>
						<tr>
							<td>
								Single Bed AC
							</td>
							<td>
								<?php print_r($pofnonac);?>
								
							</td>
						</tr>
						<tr>
						 	<td>
								Double Bed Ac
							</td>
							<td>
								<?php print_r($pofac);?>
							
							</td>
						</tr>
	<tr>
						 	<td>
								Three Bed Ac
							</td>
							<td>
								<?php print_r($pofacdlx);?>
							
							</td>
						</tr>
						<tr><?php
							if(isset($_SESSION['mlogged_in']) && $is_manager){
							?>
				<input type="hidden" name="pofnonac" value="<?php print_r(printrint($pofnonac));?>"/>
				<input type="hidden" name="pofac" value="<?php print_r(printrint($pofnonac));?>"/>
				<input type="hidden" name="pofacdlx" value="<?php print_r(printrint($pofacdlx));?>"/>
						<?php	print_r('<td><input type="submit" name="edit" class="submit" id="edit" value="Edit"/></td>');
						}?>
						</tr>
						<tr>
						<?php
							if(isset($_SESSION['clogged_in']) && $_SESSION['clogged_in']==1){
						?>
						
							
								<input type="hidden" name="pofnonac" value="<?php print_r(printrint($pofnonac));?>"/>
							
								<input type="hidden" name="pofac" value="<?php print_r(printrint($pofnonac));?>"/>
						
								<input type="hidden" name="pofacdlx" value="<?php print_r(printrint($pofacdlx));?>"/>
							
						</tr>
				
				<tr>
					<td>
						 <?php print_r('<input type="hidden" name="customerid" value="'.$_SESSION['cid'].'"/>'); 
							print_r('<input type="submit" name="book" class="submit" id="book" value="Book"/>');
						
							?>
					</td>
				</tr>
				
				<?php }
				}
				else { ?>
				<tr>
					<td>
						<?php header('Location:./edithotel.php');?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</form>
	</div>
	<div id="sidebar">
		<div id="my_map"></div>

<table>
<tr>
<th>
<form method="post" action="showhotels.php">
Search Again</th>
</tr>
<tr>
<td>Select Country</td></tr>
<tr><td><select name="country" id="country">
	<option selected value="" >Select Country</option>
	<?php	$selected_country=getcountries(1); ?>
   </select> </td>
</tr>
<tr>
<td>Select City</td></tr>
<tr>
<td><select name="city" id="city">
	<option selected value="0">Select City</option>
	<?php getcities($selected_country); ?>
   </select> </td>
</tr>
<tr>
<td><input type="submit" name="showhotels" value="Show Hotels"/></td>
</form>
</table>

<div id="relatedhotels" style="margin-top:15px;">
<table>
<tr>
<th>Related Hotels</th></tr>
<?php
	$obj=$gt->getHotelNames($country,$city);
	if($obj!=false){
		$objson=json_decode($obj);
		$constants=get_defined_constants(true);
		switch(json_last_error()){
				case JSON_ERROR_NONE:
					foreach($objson as $ob){
						$hname=$ob->name; 
						$hid=$ob->hotelID;
?>
<tr>
<td
	<h3><a href="./viewhotel.php?id=<?php echo $hid;?>"><?php print_r(ucfirst(printr($hname)))?></a></h3></td></tr>
<?php }
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
	}
  }
?>
</div>
	</div>
</div>
<?php }
?> 

<script type="text/javascript">
window.history.forward();
function noBack() { window.history.forward(); }

$('#showmap').on('click',function(e){
	e.preventDefault();
	var lat=document.getElementById('lat').value;
	var lon=document.getElementById('lon').value;
	if(lat!=0 && lon!=0){
	$('#my_map').width("215px").height("300px").gmap3({
		 map:{
    options:{
     center:[lat,lon],
     zoom:2,
     mapTypeControl: true,
     navigationControl: true,
     scrollwheel: true,
     streetViewControl: true
     }
   }
 });
}
else
$('#my_map').html("Connection Problem");
});
function checkroom(){
	
	var nrooms=document.getElementById('nofrooms').value;
	var be1=document.getElementById('nofnonac').value;
	var be2=document.getElementById('nofac').value;
	var be3=document.getElementById('nofacdlx').value;
	var cbeds=be+","+be2+","+be3;print_r($cbeds);
	var len;
	/*nbeds=cbeds.split(",");
	for(i=0;i<nbeds.length;i++)
	{ if(parseInt(nbeds[i])>0)
		$len++;
		}*/
	b1=parseInt(be1); b2=parseInt(be2); b3=parseInt(be3);
	if(isNaN(b1))
	b1=parseInt("0");
	if(isNaN(b2))
	b2=parseInt("0");
	if(isNaN(b3))
	b3=parseInt("0");
	var beds=b1+b2+b3;
	//alert(beds+"="+nrooms);
	if(nrooms>0){
	
		var p=0;
		 if(beds!=""){
			 
			 
				 if(b1>3 || b2>3 || b3>3)
					p++;
				
				if(p>0)
					return "Max 3 beds/room";
				
			 if(beds==nrooms)
				return true;
			 else
				return "No of rooms mismatch";
			}
			else
			return "Specify Beds/Room";
		}
		else
		return "No rooms selected";
	}
$('#book').on('change',function(e){
		e.preventDefault();
		var ck=checkroom();
		if(ck!=true){
			$('.submit').attr('disabled','disabled');
			alert(ck);
		}
		else
			{
				$('.submit').removeAttr('disabled','disabled');
				
			}
	});
			 
	
</script>
</body>
</html>
