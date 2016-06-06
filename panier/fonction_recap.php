<?php

function ajoutNewpanier($db)
{
$query ='DELETE FROM ligne_cde WHERE id_user = ? AND etat =\'attente\'';
$prep = $db->prepare($query);
$prep->bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
$prep->execute();							
$prep->closeCursor();
$prep = NULL;

$ajoutlignecde=0;//var pour definir où commencer ligne_cde
$query ='SELECT ligne_cde FROM ligne_cde WHERE id_user = ?';
$prep = $db->prepare($query);
$prep->bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
$prep->execute();							
while ($donnees = $prep->fetch())
	{ 
		$ajoutlignecde=$donnees['ligne_cde'];
	}
$prep->closeCursor();
$prep = NULL;

	//insere les entrées articles
	$tabenr=array();
	if(isset($_SESSION['artid']['id']))
		{ 
			for($j=0;$j<count($_SESSION['artid']['id']);$j++)
				{	
					$ajoutlignecde++; 
					$query ='INSERT INTO ligne_cde (id_user, id_art, ligne_cde, quantite, id_categ2) VALUES (:id_user, :id_article, :ligne_cde, :qte, :id_categ2)';
					$prep = $db->prepare($query);
					$prep->bindValue('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
					$prep->bindValue('id_article',$_SESSION['artid']['id'][$j],PDO::PARAM_INT);
					$prep->bindValue('ligne_cde', $ajoutlignecde, PDO::PARAM_INT);
					$prep->bindValue('qte',$_SESSION['artid']['qte'][$j],PDO::PARAM_INT);
					$prep->bindValue('id_categ2',$_SESSION['artid']['categ2'][$j],PDO::PARAM_INT);
					$prep->execute();

					$prep->closeCursor();
					$prep = NULL;

									
				
				}	
		$_SESSION['verrou']=true;
		}
/*unset($_SESSION['artid']);
unset($_SESSION['artid']['id']);
unset($_SESSION['artid']['qte']);
unset($_SESSION['artid']['categ2']);*/
	
}





















?>
