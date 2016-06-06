<?php
session_start();
$db = new PDO('mysql:host=eduvenv64.sql-pro.online.net;dbname=eduvenv64', 'eduvenv64', 'pyrenees64');

if(isset($_POST['action']))
	{
		if($_POST['action']==='envoye')
			{	$mail=htmlentities($_POST['email'],ENT_QUOTES);
				$query = 'SELECT * FROM site_user WHERE email =?';
				$prep = $db->prepare($query);
				$prep->bindValue(1, $mail, PDO::PARAM_STR);
				$prep->execute();
					while ($donnees = $prep->fetch())
						{
							$nom=$donnees['nom'];
							$username=$donnees['username'];
							$password=$donnees['password'];					
						}			
				$prep->closeCursor();
				$prep = NULL;			
			
			
			
				define('MAIL_DESTINATAIRE',$_POST['email']); 
				define('MAIL_SUJET','Education Environnement 64 inscription');

				$mail_entete = "MIME-Version: 1.0\r\n";
				$mail_entete .= "From: Education Environnement 64 "
								."<education.environnement.64@wanadoo.fr>\r\n";
				$mail_entete .= "Reply-To: education.environnement.64@wanadoo.fr\r\n";
				$mail_entete .= 'Content-Type: text/plain; charset="UTF-8"';
				$mail_entete .= "\r\nContent-Transfer-Encoding: 8bit\r\n";
				$mail_entete .= 'X-Mailer:PHP/' . phpversion()."\r\n";


				// préparation du corps du mail
				$mail_corps = "Bonjour Mme, M ".$nom;
				$mail_corps .="\n\nVoici vos identifiants pour notre site : \n\n";
				$mail_corps .= "Identifiant : ".$username;
				$mail_corps .= "\n  Mot de passe: ".$password;


				// envoi du mail
				if (mail(MAIL_DESTINATAIRE,MAIL_SUJET,$mail_corps,$mail_entete)) {
				//Le mail est bien expédié
				echo $msg_ok;
				} else {
				//Le mail n'a pas été expédié
				echo "Une erreur est survenue lors de l'envoi du formulaire par email"; 
				}
			
			
			
			
			
			
			
			
			
			
			}
	}



?>
<!DOCTYPE html >
<head>
	<title>Réinitialisation</title>
	<link rel="stylesheet" href="../templates/educ_env_2/css/templatepanier.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
<div id="cadre_exterieur">
	<div id="cadre2">
	<div id="haut">
		<div id="logo"><a href="http://education-environnement-64.org/index.php"></a></div>
		<?php include("menuens.php"); ?>
	</div>
	<div id="cadre3">
	
	<?php include("menus.php"); ?>
	<div id="panier">
	<?php if(isset($_SESSION['pageprec'])){echo '<a href="'.$_SESSION['pageprec'].'">Retour au site</a>';} 

	
	?>
	<div id="identif_blocks">	
	<div class="identif_block">
		<div class="titre"><p> > Mot de passe oublié </p></div>
		<div class="contenu"><p> Recevoir mes identifiants par email : </p>
	
<?php
	$view = '<form action="http://education-environnement-64.org/panier/reinit.php" method="post" id="form">'."\n";
	$view .= '<div id="block">';
	$view .= '<label for="email">Adresse mail : </label><input type"text" name="email"/>';
	$view .= '</div>';
	$view .= '<input type="hidden" name="action" value="envoye"/>';
	$view .= '<input type="image" src="../templates/educ_env_2/images/panier_valider.png" width="136" height="41"  align="middle" value="valider"/>';
	$view .= '</form>';
		 
	echo $view;
?>
	</div>
	</div>
	</div>
	<div class="espace"></div>
<h2><a href="http://education-environnement-64.org/panier/P_identif.php" class="preced"> Etape précedente</a></h2>
</div></div></div>
<?php include("footerens.php"); ?></div>
</body>
</html>
