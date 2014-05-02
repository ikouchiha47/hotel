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
	//require_once('GetAll.php');
	//$gt=new GetAll();
	require_once('connectpdo.php');
	$dbh=createconn();
	$resp=false;
	include('header.php');
	?>

</div>
<div id="container" style="background-image:url('./dreamp3.jpg');">
	 <div id="mainbar">
		 <?php
		  if(isset($_GET['err'])) {
			  
		  $arr=filter_input(INPUT_GET,'err');
		  $obj=unserialize(urldecode($arr));
					foreach($obj as $ob){
						print_r($ob."<br/>");
					}
		  }
		  ?>
		<form method="post" action="updatedetails.php">
		<table>
			<tr>
				<th colspan=3>
					Edit Your Account</th>
				</th>
			</tr>
		  <?php if(isset($_GET['cid'])){
				  $cid=filter_input(INPUT_GET,'cid',FILTER_SANITIZE_NUMBER_INT);
		  }
			if(isset($_SESSION['cid']) && isset($_SESSION['clogged_in'])){
				if($_SESSION['cid']==$cid)
					$resp=true;
			}
		  
		  if($resp==1) {
			  
				$sth=$dbh->prepare("select firstname,lastname,email from customer where customerID=?");
				$sth->bindParam(1,$cid,PDO::PARAM_INT);
				$sth->execute();
				$res=$sth->fetch(PDO::FETCH_OBJ);
				$cfname=$res->firstname;
				$clname=$res->lastname;
				$cemail=$res->email;
?>
				<tr>
				  <td>
				    FirstName</td>
				<td>
					<input type="text" name="cfname" value="<?php echo $cfname; ?>"/> </td>
				</tr>
				<tr>
				  <td>LastName</td>
				  <td><input type="text" name="clname" value="<?php echo $clname; ?>"/> </td>
				</tr>
 				<tr>
			         <td>Email</td>
				 <td><input type="text" name="cemail" value="<?php echo $cemail; ?>"/> </td>
				</tr>
				<tr>
				  <td>New Password</td>
				  <td><input type="password" name="cnpass" placeholder="Leave Empty for no change"/></td>
				</tr>
				<tr>
				  <td>Password</td>
				  <td><input type="password" name="cpass"/></td>
				</tr>
				<tr>
				  <td><input type="hidden" name="cid" value="<?php echo $cid; ?>"/></td>
				  <td><input type="submit" name="updatcust" value="Update"/></td>
				</tr>
 <?php
			}
			$resp=false;
			if(isset($_GET['mid'])){
				$mid=filter_input(INPUT_GET,'mid',FILTER_SANITIZE_NUMBER_INT);
		}
			if(isset($_SESSION['mid']) && isset($_SESSION['mlogged_in'])){
				if($_SESSION['mid']==$mid)
					$resp=true;
			}

			if($resp==1){
					$sth=$dbh->prepare("select firstname,lastname,email from manager where managerID=?");
				$sth->bindParam(1,$mid,PDO::PARAM_INT);
				$sth->execute();
				$res=$sth->fetch(PDO::FETCH_OBJ);
				$mfname=$res->firstname;
				$mlname=$res->lastname;
				$mmail=$res->email;


?>
					<tr>
				  <td>
				    FirstName</td>
				<td>
					<input type="text" name="mfname" value="<?php echo $mfname; ?>"/> </td>
				</tr>
				<tr>
				  <td>LastName</td>
				  <td><input type="text" name="mlname" value="<?php echo $mlname; ?>"/> </td>
				</tr>
 				<tr>
			         <td>Email</td>
				 <td><input type="text" name="mmail" value="<?php echo $mmail; ?>"/> </td>
				</tr>
				<tr>
				  <td>New Password</td>
				  <td><input type="password" name="mnpass" placeholder="Leave Empty for no change"/></td>
				</tr>
				<tr>
				  <td>Password</td>
				  <td><input type="password" name="mpass"/></td>
				</tr>
				<tr>
				  <td><input type="hidden" name="mid" value="<?php echo $mid; ?>"/></td>
				  <td><input type="submit" name="updatman" value="Update"/></td>
				</tr>
<?php
			}
?>
</form>
</table>
</div>
<div id="sidebar">
</div>
</div>
</body>
</html>
