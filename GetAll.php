<?php
require_once('connectpdo.php');

$dbh=createconn();

class GetAll {

function checkmail($email) {
global $dbh;
if (filter_var($email,FILTER_VALIDATE_EMAIL))
{
	$sth=$dbh->prepare("select email from manager where email=?");
	$sth->bindParam(1,$email,PDO::PARAM_STR);
	$sth->execute();
	$res=$sth->fetch(PDO::FETCH_OBJ);
	if($res==NULL)
		return false;
	else
		return true;
		}
else
return true;
}

function checkPass($id,$name,$password){
	global $dbh;
	require_once('Bcrypt.php');
	$sth=$dbh->prepare("select pass from ".$name." where ".$name."ID =?");
	$sth->bindParam(1,$id,PDO::PARAM_INT);
	$sth->execute();
	$res=$sth->fetch(PDO::FETCH_OBJ);
	if(!$res==NULL) {
		if(Bcrypt::check($password,$res->pass))
			return true;
		else
			return false;
	}
	else
		return false;
}
	
function checkHotelofManager($managerid){
	global $dbh;	
		$sth=$dbh->prepare("select hotelID from hotels where managerID=?");
		$sth->bindParam(1,$managerid,PDO::PARAM_INT);
		$sth->execute();
		$res=$sth->fetch(PDO::FETCH_OBJ);
		if($res==NULL)
			return false;
		else
			return true;
     }

function checkManagerofHotel($hotelid){
	global $dbh;
		$sth=$dbh->prepare("select managerID from hotels where hotelID=?");
		$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
		$sth->execute();
		if($res=$sth->fetch(PDO::FETCH_OBJ))
			return true;
		else
			return false;
		}
function checkManagerHasHotel($managerid,$hotelid){
	global $dbh;
	$sth=$dbh->prepare("select hotelID from hotels where managerID=?");
		$sth->bindParam(1,$managerid,PDO::PARAM_INT);
		$sth->execute();
		if($res=$sth->fetch(PDO::FETCH_OBJ)){
			if(($res->hotelID)==$hotelid){
				return true;
			}
			else
				return false;
		}
		else return false;
	}
		
function getHotelfromManager($managerid){
	global $dbh;	
		$sth=$dbh->prepare("select hotelID from hotels where managerID=?");
		$sth->bindParam(1,$managerid,PDO::PARAM_INT);
		$sth->execute();
		if($res=$sth->fetch(PDO::FETCH_OBJ))
			return $res->hotelID;
		else
			return 0;
     }

function getManagerfromHotel($hotelid){
	global $dbh;
		$sth=$dbh->prepare("select managerID from hotels where hotelID=?");
		$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
		$sth->execute();
		if($res=$sth->fetch(PDO::FETCH_OBJ))
			return $res->managerID;
		else
			return 0;
		}
	
function getHotelNames($country="",$city=""){
	global $dbh;
	if($country!="" && $city==""){
		$sth=$dbh->prepare("select hotelID,managerID,name,description,rating from hotels where country=?");
		$sth->bindParam(1,$country,PDO::PARAM_STR);
	}
	elseif($city!="" && $country==""){
		$sth=$dbh->prepare("select hotelID,managerID,name,description,rating from hotels where city=?");
		$sth->bindParam(1,$city,PDO::PARAM_STR);
	}
	elseif($city!="" && $country!=""){
		$sth=$dbh->prepare("select hotelID,managerID,name,description,rating from hotels where country=? and city=?");
		$sth->bindParam(1,$country,PDO::PARAM_STR);
		$sth->bindParam(2,$city,PDO::PARAM_STR);
	}
	else return false;
	$sth->execute();
	$rows=array();
	while($result = $sth->fetch(PDO::FETCH_OBJ)){
		$rows[]=$result;
	}
	return json_encode($rows);
}
	
function getHotelDescr($hotelid) {
	global $dbh;
	$sth=$dbh->prepare("select managerID,name,description,rating from hotels where hotelID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ)){
		return $res;
	}
	else
		return null;
	}
function getNumberofBookings($hotelid){
	global $dbh;
	$count=0;
	$sth=$dbh->prepare("select bookID from bookings where hotelID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->execute();
	while($res=$sth->fetch(PDO::FETCH_OBJ))
		$count++;
	}
function getBookingId($cid){
	global $dbh;
	$sth=$dbh->prepare("select bookID from bookings where customerID=?");
	$sth->bindParam(1,$cid,PDO::PARAM_INT);
	$sth->execute();
	$result="";
	while($res=$sth->fetch(PDO::FETCH_OBJ)){
		$result=$res;
	}
	return $result;
}

function RoomsBookedatHotel($hotelid,$confirm=1){
	global $dbh;
	$nrooms=0;
	$sth=$dbh->prepare("select takenrooms from bookings where hotelID=? and confirm=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->bindParam(2,$confirm,PDO::PARAM_INT);
	$sth->execute();
	while($res=$sth->fetch(PDO::FETCH_OBJ))
		$nrooms+=$res->takenrooms;
	return $nrooms;
}	

function getHotelNamefromId($hotelid) {
	global $dbh;
	$sth=$dbh->prepare("select name from hotels where hotelID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return $res;
	else
		return NULL;
}
function getCustomerNamefromId($customerid){
	global $dbh;
	$name=array();
	$sth=$dbh->prepare("select firstname,lastname from customer where customerID=?");
	$sth->bindParam(1,$customerid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ)){
		$name[0]=$res->firstname;
		$name[1]=$res->lastname;
	}
	return $name;
}
		
function checkHotelBookedOnce($hid,$cid,$con=0){
	global $dbh;
	$sth=$dbh->prepare("select bookID from bookings where hotelID=? and customerID=? and confirm=?");
	$sth->bindParam(1,$hid,PDO::PARAM_INT);
	$sth->bindParam(2,$cid,PDO::PARAM_INT);
	$sth->bindParam(3,$con,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return false;
	else
		return true;

}
	
function getPriceperBed($hotelid){
	global $dbh;
	$sth=$dbh->prepare("select nonac,onac,acdelux from priceofbeds where hotelID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return $res;
	}
	
function setPriceperBed($nonac=0,$ac=0,$acdlx=0,$hotelid){
	global $dbh;
	$sth=$dbh->prepare("update priceofbeds set nonac=?,onac=?,acdelux=?  where hotelID=?");
	if($sth->execute(array($nonac,$ac,$acdlx,$hotelid)))
		return true;
	else
		return false;
	}
function getBookid($hotelid,$customerid){
	global $dbh;
	$sth=$dbh->prepare("select bookID from bookings where hotelID=? and customerID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->bindParam(2,$customerid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return $res->bookID;
	else
		return false;
}

function getAmountPayable($bookid,$stat=1){
	global $dbh;
	
	$sth=$dbh->prepare("select payable from payment where bookID=? and status=?");
	$sth->bindParam(1,$bookid,PDO::PARAM_INT);
	$sth->bindParam(2,$stat,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return $res->payable;
	else
		return false;
	}
function getBookDatefrimId($bookid){
	global $dbh;
	$sth=$dbh->prepare("select bookdate from bookings where bookID=?");
	$sth->bindParam(1,$bookid,PDO::PARAM_INT);
	$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ))
		return $res->bookdate;
	else
	return false;
}
function getManagerIdfromEmail($email){
	global $dbh;
	$sth=$dbh->prepare("select managerID from manager where email=?");
	$sth->bindParam(1,$email,PDO::PARAM_STR);
	$res=$sth->execute();
	if($res=$sth->fetch(PDO::FETCH_OBJ)){
		return $res->managerID;
	}
	else return false;
}
function getPriceofRooms($hotelid){
	global $dbh;
	
	$sth=$dbh->prepare("select nonac,onac,acdelux from priceofbeds where hotelID=?");
	$sth->bindParam(1,$hotelid,PDO::PARAM_INT);
	$sth->execute();
	$price=$sth->fetch(PDO::FETCH_NUM);
	if($price!==NULL)
		return $price;
	else
		return false;
}

}

?>
