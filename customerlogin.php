<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<head> <style> body{ background-image:url('C:/wamp/www/hotel/Image/001.jpg'); } </style> 
<link rel="stylesheet" type="text/css" href="./main.css"/>
</head>
<body>
<div class="topbar">
<a href="./index.php"><span id="textleft">mybibo</span></a>
<div id="textright"><b style="color:red;">New User? </b><a href="customersignup.php">Register</a></div>
</div>
<div id="container" style="background-image:url('./dreamp1.jpg');background-size:100% 100%; background-repeat:no-repeat;">
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
	<form method="post" action="customerlog.php" autocomplete=off>
		<table cellpadding=4>
			<tr>
				<th colspan=2>
				Customer Login
				</th>
			</tr>
			<tr>
				<td>
					Email
				</td>
				<td>
					<input type="text" name="cemail" id="cemail" maxlength=50 placeholder="Email" required=required/>
				</td>
			</tr>
			<tr bgcolor=#ECDDEC>
				<td>
					Password
				</td>
				<td>
					<input type="password" name="cpass" id="cpass" maxlength=20 placeholder="********" required=required/>
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<input type="submit" name="login" id="login" value="Login"/>
				</td>
			</tr>
		</table>
	</form>
	<marquee scrollamount="5" behavior="alternate"><center><img src="http://www.animated-pictures.net/pictures/Characters/rocker.gif"></center></marquee></marquee>
	<br><br><center><script src="http://h1.flashvortex.com/display.php?id=2_1375467933_55535_437_0_728_90_9_1_68" type="text/javascript"></script></center>
	</div>
	<div id="sidebar">
	

</div>
</body>
</html>


