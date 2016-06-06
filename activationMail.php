<?php
session_start();
include ("function.php");
//HTML head
	$titrepage="Actitivation";
	include('head.php');
?>
<body>

<div id="container">
<?php include("menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>
<?php
		//deconnexion($redirection = "");
		echo '<div id="header"> 
		<div id="logo"></div>
		<div id="menu">
		Vous devez activer votre compte.
		<br /><br />
		Vous devez avoir re&ccedil;u un mail expliquant comment faire.
		<br />
		Pensez &agrave; regarder dans vos spams.
		</div>
		</div>';
		?>
	</div>
<!--div footer-->
	<div class="clr"></div>
	<div id="footer">
		<ul>
			<li><a href="#">Mentions légales</a></li>
			<li><a href="#">Plan du site</a></li>
		</ul>
	</div>
	<div class="clr"></div>
<!--fin div container-->		
</div>
</body>
</html>
