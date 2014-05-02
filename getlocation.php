<?php
require_once('connectpdo.php');
$dbh=createconn();
function getcountries($ret=null){
	global $dbh;
	$i=0;
	$selectedval="";
	$sth=$dbh->prepare("select country from hotels");
	$sth->execute();
	while($res=$sth->fetch(PDO::FETCH_OBJ)){
		$i++;
		if($i==1){
			print_r('<option selected value="'.$res->country.'">'.$res->country.'</option>');
			$selectedval=$res->country;
		}
		else
		print_r('<option value="'.$res->country.'">'.$res->country.'</option>');
	 }
	 if($ret!=null)
		return $selectedval;

}
function getcities($country){
	global $dbh;
	$i=0;
	if($country=="Select Country")
		print_r('<option value="">Select City</option>');
	else {
		
		$sth=$dbh->prepare("select distinct city from hotels where country=?");
		$sth->bindParam(1,$country,PDO::PARAM_STR);
		$sth->execute();
		while($res=$sth->fetch(PDO::FETCH_OBJ))
		{
			$i++;
			
			if($i==1) {
			print_r('<option selected value="'.$res->city.'">'.$res->city.'</option>');
			
			}
			else
			print_r('<option value="'.$res->city.'">'.$res->city.'</option>');
		}
	}
	return true;
}

if(isset($_GET['get_country'])){
	getcountries();
}
if(isset($_GET['get_cities'])){
	$countryname=filter_input(INPUT_GET,'get_cities');
	getcities($countryname);
}
?>
