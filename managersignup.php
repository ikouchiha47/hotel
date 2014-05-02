<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
</head>
<body>
<div class="topbar">
<a href="./index.php"><span id="textleft">mybibo</span></a>
<div id="textright">	<b style="color:green;">Already registered?</b> <a href="./managerlogin.php">Login</a></div>
</div>
<div id="container" style="background-image:url('./resort2.jpg');background-size:100% 100%; background-repeat:no-repeat;">
	 <div id="mainbar">
		 <?php
		  if(isset($_GET['id'])) {
			  
		  $arr=filter_input(INPUT_GET,'id');
		  $obj=unserialize(urldecode($arr));
					foreach($obj as $ob){
						print_r($ob."<br/>");
					}
		  }
		  ?>
	<b><marquee scrolldelay="400"><font color="black"> **** All fields mandatory **** </marquee></b><br><br><br></font>
		<table cellpadding=4>
			<form method="post" action="managerreg.php" autocomplete=off>
			<tr>
				<th colspan=2>
				Manager	Signup
				</th>
			</tr>
			<tr>
				<td>
					FirstName
				</td>
				<td>
					<input type="text" name="mfname" id="mfname" maxlength=20 placeholder="Firstname" required=required/>
				</td>
			</tr>
			<tr bgcolor=#ECDDEC>
				<td>
					LastName
				</td>
				<td>
					<input type="text" name="mlname" id="mlname" maxlength=20 placeholder="Lastname" required=required/>
				</td>
			</tr>
			<tr>
				<td>
					Email
				</td>
				<td>
					<input type="text" name="memail" id="memail" maxlength=50 placeholder="Email" required=required/>
				</td>
			</tr>
			<tr bgcolor=#ECDDEC>
				<td>
					Password
				</td>
				<td>
					<input type="password" name="mpass" id="mpass" maxlength=20 placeholder="********" required=required/>
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<input type="submit" name="signup" id="signup" value="SignUp"/>
				</td>
			</tr>
			</form>
		</table>
<br><br><b><marquee scrolldelay="400"><font color="black"> Please use valid information.. </marquee></b></font>
 	</div>
	
	<div id="sidebar">

	</div>
</div>
<?php include('footer.php');?>
</body>
</html>

