<?php
session_start();
include("../tools/connectbd.php");
if(isset($_SESSION['ajoutUser'])){ unset ($_SESSION['ajoutUser']);}

//Initiation des variables pour le panier
if(isset($_SESSION['panier'])){
	if(isset($_POST['ajout'])){
	  $_SESSION['artid']=array();;
      $_SESSION['artid']['id']=array();
      $_SESSION['artid']['qte'] = array();
      $_SESSION['artid']['categ2'] = array();
		for($i=0; $i<count($_SESSION['panier']); $i++){
			$_SESSION['artid']['id'][$i]=$_SESSION['panier'][$i];
			$_SESSION['artid']['qte'][$i]=$_POST['qte'.$i];
			$_SESSION['artid']['categ2'][$i]=$_POST['souscateg'.$i];	
			//$_SESSION['artid']['verrou'] = false;	
			}
		}
	}

//connexion membre
if(!empty($_POST['username']) && !empty($_POST['password'])) {
	include ("../functions/function_connexion.php");
	if(connexionCreate($db, $_POST['password'],$_POST['username'], $ip)) {
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

//si la personne est déjà connectée
if(isset($_SESSION['niveau'])&&isset($_SESSION['jeton']))
		header('Location:coordonnees.php');  

//HTML head
	$titrepage="Connextion";
	include('../head.php');

?>
<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("../menu.php");?>

<!--Panier-->		 
	<div id="block_panier">
		<div id="menu">
			<ul >
				<li><a href="panier.php" ><span id="gdeli1"></span>Votre panier</a></li>
				<li><span id="gdeli2bck"></span>Connexion</li>
				<li><span id="gdeli3bck"></span>Identification</li>
				<li><span id="gdeli4bck"></span>Récapitulatif</li>
				<li><span id="gdeli5bck"></span>Paiement</li>
			</ul>
			<div class="clr"></div>
		</div>	

		<?php	if(isset($_SESSION['messidpwd'])){echo $_SESSION['messidpwd']; unset($_SESSION['messidpwd']);} 	
		
		
		
		?>
		<div id="identif_blocks">	
			<div class="identif_block">
				<div class="titre"><p> >  Déjà inscrit ? </p></div>
				<div class="contenu"><p> Veuillez vous connecter : </p>
					<form action="connexion.php" method="post" id="form">
						<div id="block">
							<label for="username">Identifiant : </label><input type"text" name="username"/>
								<div class="clr"></div>
							<label for="password">Mot de passe :</label><input type="password" name="password"/>
								<div class="clr"></div>
						</div>
						<input type="image" class="marge" src="<?php echo $_SESSION['baseurl'];?>img/icon/valider.png" width="136" height="41"  align="middle" value="se connecter"/>
						<div class="clr"></div>
						<small>Mot de passe oublié ? <a href="http://education-environnement-64.org/panier/reinit.php">cliquez ici</a></small>
					</form>
				</div>
			</div>
		
			<div class="identif_block">
				<div class="titre"><p> >  Nouveau client ? </p></div>
				<div class="contenu">
					<p> Créer un compte utilisateur :</p>
					<a href="inscription.php" id="sinscrire"><img src="<?php echo $_SESSION['baseurl'];?>img/icon/valider.png" alt="valider"/></a>
				</div>
			</div>
		</div>
		<a href="../panier.php">Etape précedente</a>		
	</div>
	
<!--div footer-->
 <?php include('../footer.php');
