<?php
//#####################################################################################################
//FONCTIONS DE PROTECTION DE L'ESPACE MEMBRE
	// protection de l'espace membre
	//entre la racine du site pour les rédirection
	// Verification que les parametres de sessions existent
	// $id => $_session['id']
	// $captcha => $_session['captcha']
	// $jeton=> $_session['jeton']
	// $niveau => $_session['niveau']
	// verification que le niveau n'est pas different de 1
	// Si il y a une erreur
	// 		redirection vers la page de deconnexion
	// Sinon
	//		Verification que le jeton de connexion appartient bien au membre connecte
	//		Si ce n'est pas le cas
	//			redirection vers la deconnexion
	// 		Sinon 
	//			Si le membre est banni
	//				Redirection vers la page d'information de bannissement
	//			Sinon
	//				Retourne Vrai
	//
	// membre fix = fix pour regler le probleme issu du fait qu'il y ait 2 pages ou se connecter..
function membre2($db) {
		if(empty($_SESSION['id_user']) OR empty($_SESSION['niveau']) OR empty($_SESSION['jeton'])) 
			header("location:".$_SESSION['baseurl']."connection.php");
		else
			membrefix($db);
		}
	
	
function membre($db) {
		if(empty($_SESSION['id_user']) OR empty($_SESSION['niveau']) OR empty($_SESSION['jeton'])) 
			header("location:".$_SESSION['baseurl']."panier/connexion.php");
		else
			membrefix($db);
		}
		
function membrefix($db) {
			if($_SESSION['niveau'] !== '1') {
				header("location:".$_SESSION['baseurl']."deconnexion.php");
			}
			$query = 'SELECT * FROM jeton WHERE id_user= :id_user AND jeton= :jeton';
			$prep= $db -> prepare($query);
			$prep -> bindValue('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
			$prep -> bindValue('jeton', $_SESSION['jeton'], PDO::PARAM_INT);
			$prep -> execute();
			if($prep -> rowCount() !== 1) {
				header("location:".$_SESSION['baseurl']."deconnexion.php");
			}
			else {
				return true;
			}
			$prep->closeCursor();
			$prep = NULL;
		
	}
	// protection de l'espace moderateur
	// Verification que les parametres de sessions existent
	// $id => $_session['id']
	// $captcha => $_session['captcha']
	// $jeton=> $_session['jeton']
	// $niveau => $_session['niveau']
	// verification que le niveau n'est pas different de 2
	// Si il y a une erreur
	// 		redirection vers la page de deconnexion
	// Sinon
	//		Verification que le jeton de connexion appartient bien au moderateur connecte
	//		Si ce n'est pas le cas
	//			redirection vers la deconnexion
	// 		Sinon 
	//			Si le membre est banni
	//				Redirection vers la page d'information de bannissement
	//			Sinon
	//				Retourne Vrai
	function moderateur() {
		if(empty($_SESSION['id_user']) OR empty($_SESSION['niveau'])){//OR empty($_SESSION['jeton'])) {
			$redirect='deconnexion.php';
		}
		else {
			if($_SESSION['niveau'] !== '2') {
				header("location:".$_SESSION['baseurl']."connexion.php");
			}
			$query ='SELECT * FROM JETON WHERE id_user= :id_user AND jeton= :jeton';
			$prep= $db -> prepare($query);
			$prep -> bindValue('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
			$prep -> bindValue('jeton', $_SESSION['jeton'], PDO::PARAM_INT);
			$prep -> execute();
			if($prep -> rowCount() !== 1) {
				header("location:".$_SESSION['baseurl']."deconnexion.php");
			}
			/*else {
				if(Membre::info($id, 'activation') === '5') {
					redirection(URLSITE.'/banni.php');
				}
				return true;
			}*/
			$prep->closeCursor();
			$prep = NULL;

		}
	}
	// protection de l'espace administrateur
	// Verification que les parametres de sessions existent
	// $id => $_session['id']
	// $captcha => $_session['captcha']
	// $jeton=> $_session['jeton']
	// $niveau => $_session['niveau']
	// verification que le niveau n'est pas different de 3
	// Si il y a une erreur
	// 		redirection vers la page de deconnexion
	// Sinon
	//		Verification que le jeton de connexion appartient bien a l'administrateur connecte
	//		Si ce n'est pas le cas
	//			redirection vers la deconnexion
	// 		Sinon 
	//			Si le membre est banni
	//				Redirection vers la page d'information de bannissement
	//			Sinon
	//				Retourne Vrai
	function administrateur($db) {
		if(empty($_SESSION['id_user']) || empty($_SESSION['niveau']) || empty($_SESSION['jeton'])) {
			header("location:".$_SESSION['baseurl']."deconnexion.php");
		}
		else {
			if($_SESSION['niveau'] !== 3) {
				header("location:".$_SESSION['baseurl']."deconnexion.php");
			}
			$query = 'SELECT * FROM JETON WHERE id_user= ? AND jeton= ?';
			$prep = $db -> prepare ($query);
			$prep -> bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
			$prep -> bindValue(2, $_SESSION['jeton'], PDO::PARAM_INT);
			$prep -> execute();
			if($prep -> rowCount() !== 1) {
				header("location:".$_SESSION['baseurl']."deconnexion.php");
			}
			else {
			$prep->closeCursor();
			$prep = NULL;

			return true;
			}
		}
	}
	// compte le nombre de jeton de connexion pour le membre
/*	public static function compteJeton($id) {
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.JETON.JETONMEMBRE);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		return '<a href="listeJeton.php">Il y a '.$resultat -> rowCount().' adresse(s) ip qui se connecte(nt) &agrave; votre espace membre.</a>';
	}
	// Liste des jeton de connexion du membre
	function listeJeton($id) {
		$liste = '';
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.JETON.JETONMEMBRE);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		while($jeton = $resultat -> fetch(PDO::FETCH_ASSOC)) {
			$liste .= '<tr>
					<td align="center">Le '.date('d/m/Y', $jeton['date']).' &agrave; '.date('H:i:s', $jeton['date']).'</td>
					<td align="center">'.$jeton['ip_connexion'].'</td>
					<td align="center">
					<form method="post" action="">
					<input type="hidden" value="'.$jeton['id'].'" name="id_jeton">
					<input type="submit" value="Supprimer" name="supprime_connexion" class="input" />
					</form>
					</td>
				</tr>';
		}
		return $liste;
	}
	// effacer un jeton de connexion
	public static function deleteJeton($id) {
		$resultat = Bdd::connectBdd()->prepare(DELETE.JETON.ID);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
	}*/
	
//}



?>
