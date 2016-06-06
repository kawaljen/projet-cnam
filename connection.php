<?php
session_start();

include ("functions/function_connexion.php");
include ("functions/function.php");
$ip=get_ip();


if(!empty($_POST['username']) && !empty($_POST['password'])) {
	include("tools/connectbd.php");
	$urlsuivante="espace_perso.php";
	if(connexionCreate($db, $_POST['password'],$_POST['username'], $urlsuivante)) {
		echo '<center>
		<br />
		Redirection en cours ...
		</center>';
		//$redirect=niveau($db, $_POST['username']);
		//header("location:".niveau($db, $_POST['username']));
		}
	else {
		$message_erreur="<p>Le couple identifiant-mot de passe n'est pas valide.</p>";
		}
}
//HTML head
	$titrepage="Connection";
	include('head.php');
?>
<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>
<!--espace connection-->

	<div class="identif_block">
		<div class="titre"><p> >  Déjà inscrit ? </p></div>
		<div class="contenu"><p> Veuillez vous connecter : </p>
			<?php if(isset($message_erreur)){echo $message_erreur;} ?>
			<form action="connection.php" method="post" id="form">
				<div id="block">
					<label for="username">Identifiant : </label><input type="text" name="username"/>
						<div class="clr"></div>
					<label for="password">Mot de passe :</label><input type="text" name="password"/>
						<div class="clr"></div>
				</div>
				<input type="image" src="img/icon/valider.png" width="136" height="41"  align="middle" value="se connecter"/>
					<div class="clr"></div>
				<small>Mot de passe oublié ? <a href="http://education-environnement-64.org/panier/reinit.php">cliquez ici</a></small>
			</form>
		</div>
	</div>
	<div class="identif_block">
		<div class="titre"><p> >  Nouveau client ? </p></div>
		<div class="contenu">
			<p> Créer un compte utilisateur :</p>
			<a href="inscription.php" id="sinscrire"><img src="img/icon/valider.png" alt="valider"/> </a>
		</div>
	</div>
	

	
	
	
<!--div footer-->
 <?php include('footer.php');
