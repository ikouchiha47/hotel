<?php
function getlocation($addr){
	$geocode=@file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$addr.'&sensor=false');
        //print_r($geocode);
        if($geocode!==false){
			$output= json_decode($geocode);
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
			$cords=array("lat"=>$latitude,"lon"=>$longitude);
			//print_r("k");
			return $cords;
		}
		if($geocode===false)
		return false;
	}
 function getlatlong($address){ 
	 $coords=array();     
	 if(!empty($address) || $address!=null){
		 
        $prepAddr = str_replace(' ','+',$address);
        $ip="http://maps.google.com";
        exec("ping -n 3 $ip", $outcome, $status);
        
		if (1 == $status) {
			
        $coords=getlocation($prepAddr);
        
        if($coords !== false)
			return $coords;
		
		else{
			$locs=preg_split('/[\,]/',$prepAddr);
			foreach($locs as $loc){
				$coords=getlocation($loc);
				if($coords!== false)
					break;
			}
			return $coords;
			}
		}
		 else $coords=array("lat"=>49.8380,"lon"=>105.8203);
		
        return $coords;
	}
	else {
		$coords=array("lat"=>0,"lon"=>0);
		return $coords;
	}
}


if(isset($_GET['country'])){
	$country_name=filter_input(INPUT_GET,'country');
	$cords=getlatlong($country_name);
	//print_r($cords);
	if($cords===false){
		$cords=array("lat"=>0,"lon"=>0);
		foreach($cords as $key=>$value)
		//	print_r($key."=>".$value);
			print_r('<input type="hidden" id="'.$key.'" value="'.$value.'"/>');
		}
	if($cords!==false){
	foreach($cords as $key=>$value)
		//print_r($key."=>".$value);
		print_r('<input type="hidden" id="'.$key.'" value="'.$value.'"/>');
	}
}
	
?>
