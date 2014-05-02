<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="./main.css"/>
</head>
<body>
<div class="topbar">
<a href="./index.php"><span id="textleft">mybibo</span></a>
<div id="textright"><b style="color:red;">New User?</b> <a href="managersignup.php">Register</a></div>
</div>
<div id="container" style="background-image:url('./dreamp1.jpg');background-size:100% 100%; background-repeat:no-repeat;">
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
	<form method="post" action="managerlog.php" autocomplete=off>
		<table cellpadding=4>
			<tr>
				<th colspan=2>
				Manager	Login
				</th>
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
					<input type="submit" name="login" id="login" value="Login"/>
				</td>
			</tr>
		</table>
	</form>
	<br><br><marquee scrollamount="5" behavior="alternate"><center><img src="http://www.animated-pictures.net/pictures/Animals/buttrfly.gif"></center></marquee></marquee>
	<marquee scrollamount="5" behavior="alternate"><center><img src="http://www.animated-pictures.net/pictures/Animals/buttrfly.gif"></center></marquee></marquee>
	</div>
	<div id="sidebar">
	
	
	</div>
</div>
<?php include('footer.php');?>
</body>
</html>


