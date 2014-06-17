<?php
require_once('connectpdo.php');
$dbh=createconn();

require_once('GetAll.php');
$gt=new GetAll();

require('printing.php');

if(isset($_POST['rate'])){
$rates=$_POST['rate'];
}
if(isset($_POST['tag'])){
$tags=$_POST['tag'];

}
if(isset($_POST['ppbed'])){
$pbed=filter_input(INPUT_POST,'ppbed',FILTER_SANITIZE_NUMBER_INT);
}

if($rates=='')
$rates=0;

if($pbed=='')
$pbed=10000;
$html='<table>
			<tr>
				<th colspan=4>
					<span id="textleft">Hotels Found</span></th>
			</tr>
			<tr>
			<td><b>Hotel</b></td>
			<td><b>Location</b></td>
			<td><b>Price/Bed</b></td>
			<td><b>Rating</b></td>
			
			</tr>';

print_r($html);			
if($tags==''){
	$html="";
	$sth=$dbh->prepare("select hotelID,name,country,city,rating,pricebed from hotels where rating=? or pricebed<=? order by rating desc");
	$sth->bindParam(1,$rates,PDO::PARAM_INT);
	$sth->bindParam(2,$pbed,PDO::PARAM_INT);
	$sth->execute();
	while($res=$sth->fetch(PDO::FETCH_OBJ)){
		print_r('<td><h3><a href="./viewhotel.php?id='.$res->hotelID.'">'.ucfirst(printr($res->name)).'</a></h3></td>');
		print_r('<td>'.ucfirst(printr($res->country)).','.ucfirst(printr($res->city)).'</td>');
		print_r('<td>'.print_r($res->pricebed).'</td>');
		print_r('<td>'.$res->rating.'&nbsp;&#10030;</td></tr>');
	
	}
	}
	
if($tags!=''){
	$html="";
	$amm=array();
	$i=0;
	foreach($tags as $tag)
		$amm[++$i]=$tag;
	$sth=$dbh->prepare("select hotelID,name,country,city,rating,pricebed,tags from hotels where rating=? or pricebed<=? order by pricebed desc");
	$sth->bindParam(1,$rates,PDO::PARAM_INT);
	$sth->bindParam(2,$pbed,PDO::PARAM_INT);
	$sth->execute();
	while($res=$sth->fetch(PDO::FETCH_OBJ)){
		$temp=$res->tags;
		$j=0;$ch=0;
		$alltags=preg_split('/[\,]/',$temp);
		foreach($alltags as $ob){
			for($j=0;$j<$i;$j++)
				$ch++;
			}
		if($ch>0){
			print_r('<td><h3><a href="./viewhotel.php?id='.$res->hotelID.'">'.ucfirst(printr($res->name)).'</a></h3></td>');
			print_r('<td>'.ucfirst(printr($res->country)).','.ucfirst(printr($res->city)).'</td>');
			print_r('<td>'.print_r($res->pricebed).'</td>');
			print_r('<td>'.$res->rating.'&nbsp;&#10030;</td></tr>');
			}
		}
	}
	
print_r('</table>');
	?>
