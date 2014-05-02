<?php
require_once('StartSession.php');
require_once('GetAll.php');
require_once('getlatlong.php');
require_once('connectpdo.php');
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
<body>
<div class="topbar">

	
	<?php
	 $mid=0; if(isset($_SESSION['mid'])) 
				$mid=$_SESSION['mid']; 
			else $mid=0;	
			?>
			<a href="./viewhotel.php?id=<?php echo $mid?>"><span id="textleft">mybibo</span></a>
	<?php include('header.php');
	?>
	
</div>
<div id="container">
	<div id="mainbar">
	<?php
	$gt=new GetAll();
	
	if(isset($_SESSION['mid'])&& $_SESSION['mlogged_in']){
		$mid=$_SESSION['mid'];
		
		if($gt->checkHotelofManager($mid)){
			$name=$country=$city=$desc=$amm="";
			$hid=$rate=$rooms=0;
			$pofac=$pofnonac=$pofacdlx=0;
			if(isset($_POST['edit'])){
				if(isset($_POST['hname']))
				$name=filter_input(INPUT_POST,'hname');
				if(isset($_POST['hotelid']))
				$hid=filter_input(INPUT_POST,'hotelid',FILTER_SANITIZE_NUMBER_INT);
				if(isset($_POST['country']))
				$country=filter_input(INPUT_POST,'country');
				if(isset($_POST['city']))
				$city=filter_input(INPUT_POST,'city');
				if(isset($_POST['rooms']))
				$rooms=filter_input(INPUT_POST,'rooms',FILTER_SANITIZE_NUMBER_INT);
				if(isset($_POST['descript']))
				$desc=filter_input(INPUT_POST,'descript');
				if(isset($_POST['ammenities']))
				{
					//print_r($_POST['ammenities']);
					foreach($_POST['ammenities'] as $objects)
						$amm.=$objects.',';
					}
				
				if(isset($_POST['pofac'])){
					$pofac=filter_input(INPUT_POST,'pofac',FILTER_SANITIZE_NUMBER_INT);
				}

				if(isset($_POST['pofnonac'])){
					$pofnonac=filter_input(INPUT_POST,'pofnonac',FILTER_SANITIZE_NUMBER_INT);
				}

				if(isset($_POST['pofacdlx'])){
					$pofacdlx=filter_input(INPUT_POST,'pofacdlx',FILTER_SANITIZE_NUMBER_INT);
				}
			}
			?>
			
			<form method="post" action="savehotel.php">
				<table colspan=4>
					<tr>
						<th colspan=4><span id="textleft">Edit Hotel Description</span></th>
					</tr>
					<tr>
						<td>
							Hotel Name
						</td>
						<td>
							<input type="text" name="hotelname" id="hotelname" value="<?php echo ucfirst($name); ?>"/> 
							<input type="hidden" name="hotelid" value="<?php echo $hid; ?>"/>
						</td>
					</tr>
					<tr>
						<td>
							Country
						</td>
						<td>
							
							<select name="country" id="country">
							<option selected value="<?php echo $country;?>"><?php echo $country;?></option>
							<?php
								$sth=$dbh->prepare("select country_name from geonames");
								$sth->execute();
								while($res=$sth->fetch(PDO::FETCH_OBJ)){
									print_r('<option value="'.$res->country_name.'">'.$res->country_name.'</option>');
								}?>
							</select>
						</td>
						<td>
							City
						</td>
						<td class="editable">
							<input type="text" name="city" value="<?php echo $city;?>"/><br/>
							<a href="#" id="showmap" name="showmap" style="margin-left:5px;">Showmap</a>
						</td>
					</tr>
					<tr>
						<td>
							Rooms
						</td>
						<td>
							<input type="text" name="rooms" value="<?php echo $rooms; ?>"/>
						</td>
					</tr>
					<tr>
						<td>
							Description
						</td>
						<td>
							<textarea name="descript" value="<?php echo $desc; ?>" style="width:95%;height:3em;resizeable:none;"><?php echo $desc; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							Add Ammenities
						</td>
						<td>
							<!--<input type="text" name="ammenities" value="<php echo $amm;>"/>-->
							<?php
								$tags=preg_split('/[\,]/',$amm);
								$pth=$dbh->prepare("select tagid,tagname from taglist");
								$pth->execute();
								//print_r($tags);
								while($ress=$pth->fetch(PDO::FETCH_OBJ)){
									$checked="";
									foreach($tags as $ob)
									{
										if($ob==($ress->tagid))
											//$print_r($ob);
											$checked='checked="checked"';
									}
									?>
									<div><input type="checkbox" name="tags[]" <?php print_r($checked); ?> value="<?php print_r($ress->tagid);?>"><?php print_r($ress->tagname);?></input></div>
							<?php
									}
							?>
						</td>
					</tr>
					
					<tr>	
						<td>
							<h3>Price per Bed</h3>
						</td>
					</tr>
					<tr>
						<td>
							Non-AC Room
						</td>
						<td>
							<input type="text" name="pofnonac" value="<?php echo $pofnonac;?>"/>
						</td>
					</tr>
	<tr>
						<td>
							AC Room
						</td>
						<td>
							<input type="text" name="pofac" value="<?php echo $pofac;?>"/>
						</td>
					</tr>
	<tr>
						<td>
							AC Delux Room
						</td>
						<td>
							<input type="text" name="pofacdlx" value="<?php echo $pofacdlx;?>"/>
						</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="managrid" value="<?php echo $mid;?>"/>
							<?php
							 $gt=new GetAll();
							 if($gt->checkManagerHasHotel($mid,$hid))?>
							<input type="submit" name="save" value="Save"/>
						</td>
					</tr>
				</table>
			</form>
		<?php
	}
}?>
</div>
<div id="params">
<input type="hidden" id="getcountry" value=""></input>
</div>
<div id="sidebar">
	<div id="my_map"></div>
</div>
</div>
<?php include('footer.php');?>
<script type="text/javascript">
//$(window).ready();
$('#country').on('change',function(e){
	e.preventDefault();
	var c=document.getElementById('country').value;
	$.get('getlatlong.php',{country:c},function(res){
			$('#params').html(res);
		});
	
});
$('#showmap').on('click',function(e){
	e.preventDefault();
	var lat=document.getElementById('lat').value;
	var lon=document.getElementById('lon').value;
	
	$('#my_map').width("300px").height("300px").gmap3({
		 map:{
    options:{
     center:[lat,lon],
     zoom:8,
     mapTypeControl: true,
     navigationControl: true,
     scrollwheel: true,
     streetViewControl: true
    }
 }
});
});
</script>

</body>
</html>
