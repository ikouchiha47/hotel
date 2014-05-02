<?php
require_once('connect.php');
$dbc=mysqli_connect(db_host,db_user,db_pass,db_name);
if(isset($_GET['param'])){
	$parameter=filter_var($_GET['param'],FILTER_SANITIZE_STRING);
	if($parameter=="geonames")
	{
	
	$geonames=array(
	"AL" =>"Albania",
	"AM" =>"Armenia",
	"AR" =>"Argentina",
	"AT" =>"Austria",
	"AU" =>"Australia",
	"BA" =>"Bosnia and Herzegovina",
	"BB" =>"Barbados",
	"BD" =>"Bangladesh",
	"BE" =>"Belgium",
	"BM" =>"Bermuda",
	"BO" =>"Bolivia",
	"BR" =>"Brazil",
	"BS" =>"Bahamas",
	"BT" =>"Bhutan",
	"BW" =>"Botswana",
	"CH" =>"Switzerland",
	"CM" =>"Cameroon",
	"CN" =>"China",
	"CO" =>"Colombia",
	"CR" =>"Costa Rica",
	"DO" =>"Dominican Republic",
	"DZ" =>"Algeria",
	"EC" =>"Ecuador",
	"EE" =>"Estonia",
	"EG" =>"Egypt",
	"FR" =>"France",
	"GB"=>"United Kingdom",
	"HK" =>"Hong Kong",
	"ID" =>"Indonesia",
	"IE" =>"Ireland",
	"IL" =>"Israel",
	"IN" =>"India",
	"IT" =>"Italy",
	"JE" =>"Jersey",
	"JM" =>"Jamaica",
	"JP" =>"Japan",
	"LK" =>"Sri Lanka",
	"MV" =>"Maldives",
	"MX" =>"Mexico",
	"MY" =>"Malaysia",
	"NL" =>"Netherlands",
	"NO" =>"Norway",
	"NP" =>"Nepal",
	"NZ" =>"New Zealand",
	"PH" =>"Philippines",
	"PK" =>"Pakistan",
	"PL" =>"Poland",
	"PT" =>"Portugal",
	"SE" =>"Sweden",
	"SG" =>"Singapore",
	"US" =>"United States",
	"ZA" =>"South Africa",
	"ZM" =>"Zambia",
	"ZW" =>"Zimbabwe");
	$i=0;
	$stmt=$dbc->prepare("insert into geonames(country_name,country_code) values (?,?)");
	foreach($geonames as $key =>$value){
		$stmt->bind_param("ss",$value,$key);
		if($stmt->execute())
		$i++;
	}
	$stmt->close();
	print_r($i." values updated");
}

if($parameter=="tags"){
	$tags=array("Gym/Spa","Meeting Facilities","Internet Access","Parking Facilty","Swimming Pool","Restaurant/ Coffe Shop", "Travel Assistance","Laundry Service","Front Desk","Indoor Entertainment","Outdoor Activities");
	$i=0;
	$stmt=$dbc->prepare("insert into taglist (tagname) values(?)");
	foreach($tags as $tag){
		$stmt->bind_param("s",$tag);
		if($stmt->execute())
			$i++;
		}
		$stmt->close();
		print_r($i.' tags updated');
	}
		
}
	?>
