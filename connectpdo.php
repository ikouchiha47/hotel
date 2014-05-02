<?php
function createconn() {
	$dbhost="localhost";
	$dbuser="root";
	$dbname="hotelbook";
	$dbpass="";
	
try {
    $dbh = new PDO("mysql:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpass);
    /*** echo a message saying we have connected ***/
    return $dbh;
    }
catch(PDOException $e)
    {
    return $e->getMessage();
    }
}
?>
