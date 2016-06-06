<?php
session_start();
	include("../tools/connectbd.php");
$Verfpaiment=true;//variable supposée venir de la plateforme
if($Verfpaiment){
// update dans ligne_cde et création d'un ligne dans table facture
if(isset($_POST['id_user'])){
	$id_user=htmlentities($_POST['id_user'],ENT_QUOTES);
	$total=htmlentities($_POST['total'],ENT_QUOTES);
	$id_order=htmlentities($_POST['id_order'], ENT_QUOTES);
	
	$query='UPDATE ligne_cde SET etat =\'paye\', order_id = ? WHERE id_user =? AND etat=\'attente\'';
	$prep = $db -> prepare($query);
	$prep -> bindValue(1, $id_order, PDO::PARAM_INT);
	$prep -> bindValue(2, $id_user, PDO::PARAM_INT);
	$prep -> execute();
	$prep -> closeCursor();
	
	$query= 'INSERT INTO facture (id_order, id_user, total) VALUES(:id_order, :id_user, :total)';
	$prep = $db ->prepare($query);
	$prep -> bindValue('id_order', $id_order, PDO::PARAM_INT);
	$prep -> bindValue('id_user', $id_user, PDO::PARAM_INT);
	$prep -> bindValue('total', $total, PDO::PARAM_INT);
	$prep -> execute();
	$prep -> closeCursor();
	}
}


?>
<!DOCTYPE HTML PUBLIC   "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
	<title></title>Plateforme de paiement</title>
	<link rel="stylesheet" href="../css/template.css" type="text/css"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>

<!--Plateforme-->	
<h1>Platefome</h1>	 
<p style ="background-color:#fff;">Si paiement réussi -> ligne de commande mise à jour à payé et création d'une ligne dans facture</p>	

<?php
		echo "TABLE FACTURE";
					$query ='SELECT * FROM facture WHERE id_user = ?';
					$db->query("SET NAMES 'utf8'");
					$prep = $db->prepare($query);
					$prep->bindValue(1,$_SESSION['id_user'], PDO::PARAM_INT);
					$prep->execute();

								while ($donnees = $prep->fetch())
									{	
										echo "<p>ID_USER : ".$donnees['id_user']." ID_ORDER : ".$donnees['id_order']." DATE : ".$donnees['date_facture']." TOTAL : ".$donnees['total']."</p>";

									}
					$prep->closeCursor();
					$prep = NULL;

?>

</body>
</html>
