<?php
session_start();
include("../tools/connectbd.php");

//on verifie le couple identifiant/password si on est pas déjà connecté 
if(!isset($_SESSION['niveau'])&& !isset($_SESSION['ajoutUser']))
	{
		$query = 'SELECT * FROM site_user WHERE password= :password AND username= :username';
		$resultat = $db->prepare($query);
		$resultat -> bindValue('password', $_POST['password'], PDO::PARAM_STR);
		$resultat -> bindValue('username', $_POST['username'], PDO::PARAM_STR);
		$resultat -> execute();

			if($resultat -> rowCount() != 1) 
				{
					$Vlogin = false;
					$resultat->closeCursor();
					$resultat = NULL;
					$_SESSION['messidpwd']= '<p>Le couple identifiant/mot de passe est incorrect. <br />Veuillez recommencer.</p>';
					header("location:connexion.php");
				}
			else
				{
					$donnees = $resultat->fetch();
					$_SESSION['niveau']=$donnees['niveau'];
					$_SESSION['id_user']=$donnees['id_user'];
				}
	}


//les actions possibles de la page : modif user 
if(isset($_POST['action']))
	{
		if($_POST['action']==='modif')
			{$modifUser=1;}
	}
 

//nouvel utlisateur, ajout depuis panierform.php
// ou Modifier les entrées User
if(isset($_SESSION['ajoutUser'])||isset($modifUser)){  
	if(!empty($_POST['nom']) && !empty($_POST['prenom'])&& !empty($_POST['couriel']) && !empty($_POST['ville']) && !empty($_POST['adress'])&& !empty($_POST['codep'])) {

		$nom= htmlspecialchars($_POST['nom']);
		$prenom= htmlspecialchars($_POST['prenom']);
		$adress= htmlspecialchars($_POST['adress']);
		if(isset($_POST['compl'])){$compl= htmlspecialchars($_POST['compl']);}else{$compl=null;}
		$codep= htmlentities($_POST['codep'],ENT_QUOTES);
		$ville= htmlspecialchars($_POST['ville']);
		$couriel= htmlentities($_POST['couriel'],ENT_QUOTES);
		if(isset($_POST['telfixe'])){$telfixe= htmlentities($_POST['telfixe'],ENT_QUOTES);}else{$telfixe=null;}
		if(isset($_POST['telport'])){$telport= htmlentities($_POST['telport'],ENT_QUOTES);}else{$telport=null;}
		if(isset($_POST['username'])){$username =  htmlspecialchars($_POST['username']);}
		if(isset($_POST['password'])){$password =  htmlspecialchars($_POST['password']);}//sha1($_POST['gu'.'password'])
		
			
		//les inscriptions
		if(isset($_SESSION['ajoutUser']))
			{
				if (!empty($_POST['password2'])&& !empty($_POST['password'])&& !empty($_POST['username']))
					{if ($_POST['password']===$_POST['password2'])
						{
						//verifie si le username n'existe pas déjà
						$verifIdentifiant = 'SELECT * FROM site_user WHERE username= ?';
						$db->query("SET NAMES 'latin1'");
						$prep2 = $db->prepare($verifIdentifiant);
						$prep2->bindValue(1, $username, PDO::PARAM_STR);
						$prep2->execute();
							if($prep2 -> rowCount() != 1) 
								{ 
			
									$query = 'INSERT INTO site_user (username, password, email, nom, prenom, adress, complement_add, codep, ville, telfixe, telport) VALUES ( :username, :password, :email, :nom, :prenom, :adress, :complement_add,:codep, :ville, :telfixe, :telport)';
									$prep = $db->prepare($query);	
									$prep->bindValue('nom', $nom,PDO::PARAM_STR);
									$prep->bindValue('prenom',$prenom,PDO::PARAM_STR);
									$prep->bindValue('adress',$adress,PDO::PARAM_STR);
									$prep->bindValue('complement_add',$compl,PDO::PARAM_STR);
									$prep->bindValue('codep',$codep,PDO::PARAM_INT);
									$prep->bindValue('ville', $ville, PDO::PARAM_STR);
									$prep->bindValue('telfixe', $telfixe, PDO::PARAM_INT);
									$prep->bindValue('telport', $telport, PDO::PARAM_INT);
									$prep->bindValue('email',$couriel,PDO::PARAM_STR);
									$prep->bindValue('username',$username, PDO::PARAM_STR);
									$prep->bindValue('password',$password, PDO::PARAM_STR);
									$prep->execute();
				
									$prep->closeCursor();
									$prep = NULL;
									
									unset($_SESSION['ajoutUser']);
						
								}else { $_SESSION['message2']= '<p>Ce nom d\'utilisateur est déjà utilisé, <br />veuillez en choisir un autre et recommencer l\'inscription.</p>';
												header("location:inscription.php");}
												//faudrait mettre les message d'erruer ds un tableau????---------------------------------------------------------
						
						}else {$_SESSION['messpasword']='<p>Les mots de passe ne sont pas identiques, <br />veuillez recommencer l\'inscription.</p>';
							header("location:inscription.php");}	
					}else { $_SESSION['message']= '<p>Vous n\'avez pas rempli les champs obligatoires, <br />veuillez recommencer l\'inscription.</p>';
								header("location:inscription.php");}
			$urlsuivante="coordonnees.php";
			include ("../functions/function_connexion.php");
			connexionCreate($db, $password,$username, $urlsuivante);
			}

		//les updates		
		else if(isset($modifUser))
			{
			
					$query = 'UPDATE site_user SET nom = :nom, prenom = :prenom, adress = :adress, complement_add= :complement_add, codep = :codep, ville = :ville, telfixe = :telfixe, telport= :telport, email= :email WHERE id_user= :id';
					$prep = $db->prepare($query);	
					$prep->bindValue('nom', $nom,PDO::PARAM_STR);
					$prep->bindValue('prenom',$prenom,PDO::PARAM_STR);			
					$prep->bindValue('adress',$adress,PDO::PARAM_STR);
					$prep->bindValue('complement_add',$compl,PDO::PARAM_STR);
					$prep->bindValue('codep',$codep,PDO::PARAM_INT);
					$prep->bindValue('ville', $ville, PDO::PARAM_STR);
					$prep->bindValue('telfixe', $telfixe, PDO::PARAM_INT);
					$prep->bindValue('telport', $telport, PDO::PARAM_INT);
					$prep->bindValue('email',$couriel,PDO::PARAM_STR);
					$prep->bindValue('id',$_SESSION['id_user'], PDO::PARAM_INT);
					$prep->execute();
			
					$prep->closeCursor();
					$prep = NULL;
					
			}	
		}
	else {  if(isset($modifUser)){$message= '<p>Vous n\'avez pas remplis les champs obligatoires, <br />veuillez recommencer l\'inscription.</p>';
				header("location:inscription.php");}
			 else{$_SESSION['message']= '<p>Vous n\'avez pas rempli les champs obligatoires, <br />veuillez recommencer l\'inscription.</p>';
				header("location:inscription.php");}
		}
	}
	
//fonction de protection des espaces membres
include("../functions/function_protection.php");
	membre($db);
//HTML head
	$titrepage="Coordonnees";
	include('../head.php')


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

		<div id="panier2">
			<?php
			
			//message d'erreur
			if(isset($message)){echo $message;}

			if(!isset($message))
				{
					// On récupère tout le contenu de la table site_user
					$query ='SELECT * FROM site_user WHERE id_user = ?';
					$prep = $db->prepare($query);
					$prep->bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
					$prep->execute();
						while ($donnees = $prep->fetch())
							{
			?>
								<h2>Les informations enregistrées : </h2>
								<form method="post" action="coordonnees.php" onsubmit="return valider()">
									<div>
										<label for="nom"><strong>Nom de famille* :</strong></label>
										<input type="text" name="nom" value="<?php echo $donnees['nom']; ?>"/>
									</div>
									<div>
										<label for="prenom"><strong>Prénom* :</strong></label>
										<input type="text" name="prenom" value="<?php echo $donnees['prenom']; ?>"/>
									</div>
									<div>
										<label for="adress"><strong>Adresse* :</strong></label>
										<input type="text" name="adress" value="<?php echo $donnees['adress']; ?>"/>
									</div>
									<div>
										<label for="adress"><strong>Complement :</strong></label>
										<input type="text" name="compl" value="<?php echo $donnees['complement_add']; ?>"/>
									</div>
									<div>
										<label for="codep"><strong>Code postal* :</strong></label>
										<input type="text" name="codep" value="<?php echo $donnees['codep']; ?>"/>
									</div>
									<div>
										<label for="ville"><strong>Ville* :</strong></label>
										<input type="text" name="ville" value="<?php echo $donnees['ville']; ?>"/>
									</div>
									<div>
										<label for="telfixe"><strong>Tel fixe* :</strong></label>
										<input type="text" name="telfixe" id="Vtelfix" value="<?php echo $donnees['telfixe']; ?>"/>
									</div>
									<div>
										<label for="telport"><strong>Tel portable :</strong></label>
										<input type="text" name="telport" value="<?php echo $donnees['telport']; ?>"/>
									</div>
									<div>
										<label for="couriel"><strong>E-mail :</strong></label>
										<input type="text" name="couriel" value="<?php echo $donnees['email']; ?>" />
									</div>

									
									<input type="hidden" name="action" value="modif">
									<input type="image" src="../img/icon/valider.png" width="136" height="41"  align="middle"/>
								</form>
<?php
							}
					
					$prep->closeCursor();
					$prep = NULL; // Termine le traitement de la requête
				}
?>

		</div>
		
		<a href="../panier.php">Etape précedente</a>
		<a href="paiement.php">Etape suivante</a>
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
<script>


function valider(){

if(document.getElementById('Vprenom').value.length <= 3) {
    alert("Merci de vérifier le prénom" );   
	return false;
	}
	
else if(document.getElementById('Vnom').value.length <= 3) {
    alert("Saisissez le nom");
    return false;
	}
	
else if(document.getElementById('Vadress').value.length <= 3) {
    alert("Saisissez l'adresse");
    return false;
	}
	
else if(document.getElementById('Vcp').value.length != 5) {
    alert("Saisissez le code postal");
    return false;
	}

else if(document.getElementById('Vville').value.length <= 3) {
    alert("Saisissez la ville");
    return false;
	}
else if(document.getElementById('Vtelfix').value.length < 10) {
    alert("Vous devez rentrer un numéro de téléphone");
    return false;
	}
else if(document.getElementById('Vid').value.length <= 6) {
    alert("L'identifant doit faire minimum 6 caractères");
    return false;
	}

else if(document.getElementById('Vmp').length <= 6) {
    alert("Le mot de passe doit minimum 6 caractères");
    return false;
	}

else if(document.getElementById('Vmp2').value.length <= 6) {
    alert("Saisissez le deuxieme mot de passe");
    return false;
	}

else if(document.getElementById('Vmp').value !== document.getElementById('Vmp2').value){
    alert("Les deux mots de passe ne sont pas identiques");
    return false;
	}	
else if(document.getElementById('Vmail').value.length <= 8) {
    alert("Saisissez un email valide");
    return false;
	}
else if ((document.getElementById('Vmail').value.length > 8))
		{ if(bonmail(document.getElementById('Vmail').value) != "ok")
			{	alert("Saisissez un email valide");
				return false; 
			}
		}
else { return true;}

	
}
	
	

function bonmail(mailteste)

{
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');

	if(reg.test(mailteste))
	{
		return("ok");
	}
	else
	{
		return(false);
	}
}

</script>
</body>
</html>
