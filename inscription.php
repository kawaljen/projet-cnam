<?php
session_start();
$_SESSION['ajoutUser']=true;
//HTML head
	$titrepage="Inscription";
	$js=true;
	include('head.php');
?>
<body>

<div id="container">
<?php include("menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>

<!--Formulaire de connection-->
	<div id="form_ins">
<?php 

//messages d'erreur
		if(isset($_SESSION['message']))
			{	echo $_SESSION['message'];
				unset ($_SESSION['message']);
			}
		if(isset($_SESSION['messpasword']))
			{	echo $_SESSION['messpasword'];
				unset($_SESSION['messpasword']);
			}
		if(isset($_SESSION['message2']))
			{	echo $_SESSION['message2'];
				unset ($_SESSION['message2']);
			}
?>
		<h1>Vos coordonnées</h1>
		<form method="post" action="espace_perso.php" onsubmit="return valider()"><!-- onsubmit="return valider()">-->
			<div>
				<label for="nom"><strong>Nom de famille* :</strong></label>
				<input type="text" name="nom" id="Vnom"/>
			</div>
			<div>
				<label for="prenom"><strong>Prénom* :</strong></label>
				<input type="text" name="prenom" id="Vprenom"/>
			</div>
			<div>
				<label for="adress"><strong>Adresse* :</strong></label>
				<input type="text" name="adress" id="Vadress"/>
			</div>
			<div>
				<label for="adress"><strong>Complement :</strong></label>
				<input type="text" name="compl"/>
			</div>
			<div>
				<label for="codep"><strong>Code postal* :</strong></label>
				<input type="text" name="codep" id="Vcp"/>
			</div>
			<div>
				<label for="ville"><strong>Ville* :</strong></label>
				<input type="text" name="ville" id="Vville"/>
			</div>
			<div>
				<label for="telfix"><strong>Tel fixe :</strong></label>
				<input type="text" name="telfix"/>
			</div>
			<div>
				<label for="telport"><strong>Tel portable :</strong></label>
				<input type="text" name="telport"/>
			</div>
			<div>
				<label for="couriel"><strong>E-mail* :</strong></label>
				<input type="text" name="couriel" id="Vmail"/>
			</div>
			<div>
				<label for="username"><strong>Choisissez un identifiant* :</strong></label>
				<input type="text" name="username" id="Vid" onBlur="tester()"/>
				<div id="test"></div>
			</div>
			<div>
				<label for="password"><strong>Choisissez un mot de passe*</strong></label>
				<input type="password" name="password" id="Vmp"/>
			</div>
			<div>
				<label for="password"><strong>Retapez le mot de passe*:</strong></label>
				<input type="password" name="password2" id="Vmp2"/>
			</div>
			<div class="clr"></div>
			<input type="hidden" name="action" value="ajout_ins"/>
			<input type="image" src="img/icon/valider.png"  width="136" height="41"  align="middle" alt="Valider"/>

		</form>
	</div>
	

	
<!--div footer-->
 <?php include('footer.php');




