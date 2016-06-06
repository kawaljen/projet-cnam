<?php
	// protection de l'espace administrateur
	// Verification que les parametres de sessions existent
	// => $_session['id']
	// => $_session['jeton']
	// => $_session['niveau']
	// verification que le niveau n'est pas different de 3
	// Si il y a une erreur
	// 		redirection vers la page de deconnexion
	// Sinon
	//		Verification que le jeton de connexion appartient bien a l'administrateur connecte
	//		Si ce n'est pas le cas
	//			redirection vers la deconnexion
	// 		Sinon 
	//			Retourne Vrai
	function administrateur($db) {
		if(empty($_SESSION['id_user']) || empty($_SESSION['niveau']) || empty($_SESSION['jeton'])) {
			header("location:../deconnexion.php");
		}
		else {
			if($_SESSION['niveau'] != 3) {
				header("location:../deconnexion.php?");
			}
			$query = 'SELECT * FROM jeton WHERE id_user= ? AND jeton= ?';
			$prep = $db -> prepare ($query);
			$prep -> bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
			$prep -> bindValue(2, $_SESSION['jeton'], PDO::PARAM_INT);
			$prep -> execute();
			if($prep -> rowCount() !== 1) {
				header("location:../deconnexion.php");
			}
			else {
				$prep->closeCursor();
				$prep = NULL;

				return true;
			}
		}
	}
	
//-----------------------------------------------------------------------------------------------------------------------------------------------	
//PAGE ADMIN GENERAL
//-----------------------------------------------------------------------------------------------------------------------------------------------	

//Valider les commentaires
function validercom($db,$valider){
	$query= 'UPDATE commentaire SET valider=\'oui\' WHERE id_com= ?';
		$prep = $db -> prepare($query);
		for($i=0; $i<count($valider);$i++) {
			$id_com= htmlentities($valider[$i], ENT_QUOTES);
			$prep -> bindValue(1 , $id_com, PDO::PARAM_INT); 
			$prep -> execute();
		}
		$prep->closeCursor;
	}



?>
