<?php
// Fonction d'inscription
	// Si l'identifiant, l'email le mot de passe un et le mot de passe deux sont poster
		// Si les deux mot de passe sont identiques
				// Si le pseudo n'existe pas dans la bdd
					// Si l'email est valide
						// Si l'email n'existe pas dans la bdd
							// creation du profil
							// creation de la protection des info du profil
							// envoie du message de bienvenue
							// Retourne Activation du profil
						// Sinon
								// Retourne email existe deja
					// Sinon
							// Retourne email non valide
				// Sinon
						// Retourne le pseudo existe
		// Sinon
				// Retourne les 2 mots de passe sont !=
	// Sinon
			// Retourne remplir tout les champs
function inscrire($db, $info) 
{
	if(!empty($info['username']) AND !empty($info['email']) AND !empty($info['pass']) AND !empty($info['pass2'])) {
		if($info['pass'] === $info['pass2']) {
			$verifIdentifiant = 'SELECT * FROM site_user WHERE username= ?';
			$prep = $db->prepare($verifIdentifiant);
			$prep->bindValue(1, $info['username'], PDO::PARAM_STR);
			$prep->execute();
				if($prep -> rowCount() != 1) {
					$prep->closeCursor();
					$prep = NULL;
					if(check_mail($info['email'])) {
							$verifMail = 'SELECT * FROM site_user WHERE email= ?';
							$prep2 = $db->prepare($verifMail);
							$prep2->bindValue(1, $info['email'], PDO::PARAM_STR);
							$prep2 -> execute();
								if($prep2 -> rowCount() !== 1) {
										$prep2->closeCursor();
										$prep2 = NULL;
										Inscription_profil($info, $db);
										if(activationMail($info))
											$resultat = 'Votre inscription est termin&eacute;e, un email de confirmation viens de vous &ecirc;tre envoy&eacute;,<br />pensez a v&eacute;rifier vos spams.';//Inscription::activer($identifiant);
										else 
											$resultat = 'Le mail n\'a pas etre envoyé';
									}
								else {
									$resultat = 'L\'adresse email '.$email.' existe d&eacute;j&agrave;,<br />veuillez en saisir une autre et recommencer l\'inscription..';
									}
						}
					else {
						$resultat = 'L\'adresse email saisi n\'est pas valide, <br />veuillez recommencer l\'inscription.';
						}
					}
				else {
					$resultat = 'L\'identifiant saisi existe d&eacute;j&agrave;,<br />veuillez en choisir un autre et recommencer l\'inscription.';
					}
			}
		else {
			$resultat = 'Le champ &quot;Saisir un Mot de Passe&quot; et le champ &quot;Resaisir un Mot de Passe&quot; doivent &ecirc;tre identiques, <br />veuillez recommencer l\'inscription.';
			}
		}
	else {
		$resultat = 'Vous devez remplir tout les champs, <br />veuillez recommencer l\'inscription.';
		}
return $resultat;
}


// creation du profil
function Inscription_profil($info, $db) {
//$pass = Cryptage::crypter($pass);
	$query = 'INSERT INTO site_user (username, password, email, nom, prenom, adress, complement_add, codep, ville, telfixe, telport) VALUES ( :username, :password, :email, :nom, :prenom, :adress, :complement_add,:codep, :ville, :telfixe, :telport)';
	$prep = $db->prepare($query);	
	$prep->bindValue('nom', $info['nom'],PDO::PARAM_STR);
	$prep->bindValue('prenom',$info['prenom'],PDO::PARAM_STR);
	$prep->bindValue('adress',$info['adress'],PDO::PARAM_STR);
	$prep->bindValue('complement_add',$info['compl'],PDO::PARAM_STR);
	$prep->bindValue('codep',$info['codep'],PDO::PARAM_INT);
	$prep->bindValue('ville', $info['ville'], PDO::PARAM_STR);
	$prep->bindValue('telfixe', $info['telfixe'], PDO::PARAM_INT);
	$prep->bindValue('telport', $info['telport'], PDO::PARAM_INT);
	$prep->bindValue('email',$info['email'],PDO::PARAM_STR);
	$prep->bindValue('username',$info['username'], PDO::PARAM_STR);
	$prep->bindValue('password',$info['pass'], PDO::PARAM_STR);
	$prep->execute();
}

//verification mail actif
function check_mail(){
	return true;

}
//envoie d'un mail de confirmation
function activationMail($info){
		//envoi du mail au client


		$mail_entete = "MIME-Version: 1.0\r\n";
		$mail_entete .= "From: Projet APErsilie "
					 ."<persiliealexandra@hotmail.fr>\r\n";
		$mail_entete .= "persiliealexandra@hotmail.fr>\r\n";
		$mail_entete .= 'Content-Type: text/plain; charset="UTF-8"';
		$mail_entete .= "\r\nContent-Transfer-Encoding: 8bit\r\n";
		$mail_entete .= 'X-Mailer:PHP/' . phpversion()."\r\n";

			
		// préparation du corps du mail
		$mail_corps = "Bonjour Mme, M ".$info['nom'];
		$mail_corps .="\n\n Vous venez d'effectuer une inscription sur notre site.\n";
		$mail_corps .="\n\n Votre identifiant est ".$info['username'].".\n";
		$mail_corps .="\n\n Cordialement.\n";
				

			// envoi du mail
			if (mail($info['email'],'inscription',$mail_corps,$mail_entete)) 
				return true;//Le mail est bien expédié
			 else 
				return false;//Le mail n'a pas été expédié
			
			
}
?>
