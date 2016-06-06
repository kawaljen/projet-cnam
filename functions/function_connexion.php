<?php
//!!connection vs connexion!!!!!!!!
//************************************************************************************************************************************************************
//CONNEXION MEMBRE
// fonction de connexion des membres
// 		Si login existe 
//			Si mot de passe est ok 
//				Creation de la session
//				Enregistrement du jeton de connexion
//				Redirection vers page au choix
//					-> membre, moderateur, administrateur
//			Si mot de passe faux => retourne faux
// 		Si login existe pas => retourne faux

function get_ip() 
{
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
			{	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
		elseif(isset($_SERVER['HTTP_CLIENT_IP'])) 
			{	$ip = $_SERVER['HTTP_CLIENT_IP'];}
		else 
			{	$ip = $_SERVER['REMOTE_ADDR'];}
			
	return $ip;
} 

	function connexionCreate($db, $pass, $username, $urlsuivante) {
		if(verifLogin($db, $username)) {
			if(verifPass($db, $pass, $username)) {
				$_SESSION['jeton'] = jeton($db);
				niveau($db, $username, $urlsuivante);
				return true;
			}
			else {
				//$redirect="probleme identfiant";
				return false;
			}
		}
		else {
			//$redirect="couple identifiant mot de passe invalide";
			return false;
		}

	}
	// Fonction de verification que l'identifiant existe dans la bdd
	function verifLogin($db, $username) {
			$verifuserN = 'SELECT * FROM site_user WHERE username= ?';
			$prep = $db->prepare($verifuserN);
			$prep->bindValue(1, $username, PDO::PARAM_STR);
			$prep -> execute();
			if($prep -> rowCount() === 1) {
				$prep->closeCursor();
				$prep = NULL;
				return true;
			}
			else {
				return false;
			}
	}
	// Function de verification du mot de passe
	function verifPass($db, $pass, $username) {
		$verifpass = 'SELECT * FROM site_user WHERE username= ?';
		$prep = $db->prepare($verifpass);
		$prep->bindValue(1, $username, PDO::PARAM_STR);
		$prep -> execute();
		$donnees = $prep->fetch();
			if($pass === $donnees['password']) {//manque le crypatge!!!!
				$_SESSION['id_user']=$donnees['id_user'];
				$_SESSION['username']=$donnees['username'];
				$prep->closeCursor();
				$prep = NULL;
				return true;
				}
			else {
				return false;
				}

	}
	// La fonction de gestion des jetons de connexion lors de la connexion d'un membre
	// Si il existe un jeton de connexion appertenant au membre qui se connecte avec la meme adresse ip
	// 	-> mise a jour de la date de connexion dans la table des jetons de connexion
	//  -> retourne le jeton
	// Si il n'existe pas 
	// 	-> creation d'un jeton de connexion
	// 	-> enregistrement du jeton
	//  -> retourne le jeton
	function jeton($db) {
		//$ip=get_ip();
		$date ='2';//= time();
		$jeton = rand(1,1000000);
		$query = 'SELECT * FROM jeton WHERE id_user = ?';
		$prep = $db->prepare($query);
		$prep->bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);		
		$prep -> execute();
		if($prep -> rowCount() > 0) {
			$prep -> closeCursor();
			$insert = 'UPDATE jeton SET jeton= :jeton WHERE id_user= :id';
			$prep2 =$db ->prepare($insert);
			$prep2->bindValue('jeton',$jeton);
			$prep2->bindValue('id', $_SESSION['id_user']);

			$prep2 -> execute();
			
			return $jeton;
			}
		else {
			//$jeton = Cryptage::crypter(Cryptage::chaine(10));!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

			$insert = 'INSERT INTO jeton (id_user, ip, jeton) VALUES (:id, :ip, :jeton)';
			$prep2 =$db ->prepare($insert);
			$prep2->bindValue('id', $_SESSION['id_user'], PDO::PARAM_INT);
			//$prep2->bindValue('date', $date);
			$prep2->bindValue('ip', $ip);
			$prep2->bindValue('jeton',$jeton);
			$prep2 -> execute();
			
			return $jeton;
		}
	}
	// Fonction de recuperation du niveau du membre
	// 	3 possibilite -> Membre, moderateur, administrateur
	function niveau($db, $username, $urlsuivante) {
		$verifNiv = 'SELECT niveau FROM site_user WHERE username= ?';
		$prep = $db->prepare($verifNiv);
		$prep->bindValue(1, $username, PDO::PARAM_STR);
		$prep -> execute();
			while ($donnees = $prep->fetch())
				{
					switch($donnees['niveau']) {
						case 1 :
						$_SESSION['niveau'] = '1'; 
						//$redirect = 'espace_perso.php';
						header("location:".$_SESSION['baseurl'].$urlsuivante);
						break;
				
					case 2 :
						$_SESSION['niveau'] = '2';
						//$redirect = '/moderateur.php';
						break;
				
					case 3 :
						$_SESSION['niveau'] = '3';
						header("location:admin/admin_general.php");
						//$redirect='espace_admin.php';
						break;
					default :
						$redirect='connection.php';
				
					}
				}

		//return $redirect;
	}


	
	// fonction de deconnexion
	// destruction des session id_user jeton niveau
	// 		Si une page de redirection est choisi
	//			redirection vers la page
	function deconnexion(){//$redirection) {
		$_SESSION = array();
		session_destroy();
		/*if(!empty($redirection)) {
			header($redirection);
		}*/
	}
	
	// mot de passe oublié
	// Si l'email est valide
	// 		Si l'email existe dans la bdd
	// 			creation d'un nouveau mot de passe
	// 			enregistrement du nouveau mot de passe
	// 			Si l'envoie de l'email avec nouveau mot de passe est ok
	//				retourne message d'information
	//			Sinon
	//				retourne erreur de l'envoie
	//		Sinon
	//			retourne email existe pas dans la bdd
	// Sinon
	// Retourne email nn valide
	 function passOubli($db, $email, $newPass) {
		//if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$verifMail = 'SELECT * FROM site_user WHERE email= ?';
			$prep = $db->prepare($verifMail);
			$prep->bindValue(1, $email, PDO::PARAM_STR);
			$prep -> execute();
			if($prep -> rowCount() === 1) {
				$donnees= $prep ->fetch();		
				$headers ='From: "'.$donnees['nom'].' '.$donnees['prenom'].'"'.$email.''."\n";
				$headers .='Reply-To: declics@gmail.com'."\n";
				$headers .='Content-Type: text/plain; charset="UTF8"'."\n";
				$headers .='Content-Transfer-Encoding: 8bit'; 
				$sujet = "Nouveau mot de passe pour déclics.eu";
				$message = 'Bonjour '.$donnees['nom'].','."\n\n";
				$message .= "Voici votre nouveau mot de passe : ".$newPass."\n\n";
				$message .= 'Cordialement,'."\n";
				$message .= 'déclics.eu.'."\n";
					if(mail($email, $sujet, $message, $headers)) {
						return 'Un nouveau mot de passe viens de vous &ecirc;tre envoy&eacute;,<br />pensez &agrave; v&eacute;rifiez vos spams.';
						}
					else {
						return 'Erreur lors de l\'envoie de votre mot de passe.';
					}
					
				$prep->closeCursor();
				$prep = NULL; // Termine le traitement de la requête
				$query = 'UPDATE site_user SET password= :password WHERE email= :email';
				$prep = $db->prepare($query);	
				$prep->bindValue('password', $newPass,PDO::PARAM_STR);
				$prep->bindValue('email',$email,PDO::PARAM_STR);
				$prep->execute();
		
				$prep->closeCursor();
				$prep = NULL;
			}

			else {
				return 'L\'adresse email '.$email.' n\'existe pas dans nos base de données,<br />merci de rééssayer.';
			}
		//}
		//else {
		//	return 'L\'adresse email saisi n\'est pas valide.';
		//}
	}

?>
