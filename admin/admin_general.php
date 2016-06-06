<?php
session_start();
include("../tools/connectbd.php");
include ("../functions/function_admin.php");

administrateur($db);	
	
if(!empty($_POST['valider'])){
		validercom($db, $_POST['valider']);
	}
//HTML head
	$titrepage="Admin Général";
	include('../head.php');
?>
<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->
<?php include("../menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="../images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>

<!--espace admin-->	
	<div id="esp_admin">
	<h1>Espace Admin</h1>
	<h2>Général</h2>
	<a href="admin_general.php" class="choixadmin actif">Général</a>
	<a href="admin_stock.php" class="choixadmin">Voir le Stock</a>
	<a href="admin_commande.php" class="choixadmin">Voir les commandes </a>
	<a href="admin_membre.php" class="choixadmin">Voir les info membres</a>
	
	
<?php	
			
//<!-- Stock -->
		$compteur=0;
		$query = $db->query('SELECT * FROM article NATURAL JOIN categorie2 WHERE quantite_produit <= 20 ORDER BY id_categ');					
			while ($donnees = $query ->fetch())
				{		
	
					if($compteur===0)
						{
							echo
								'<h2>Stock : articles dont les quantités sont inférieures à 20</h2>
								<table border=1>
									<tr>
										<td>id</td>
										<td>Auteur</td>
										<td>Titre</td>
										<td>Catégorie</td>
										<td>Edition limitée</td>
										<td>Prix</td>
										<td>Quantité produit</td>
										<td>Suspendre</td>
									</tr>';
						}
					$compteur++;								
					echo 
						'<tr>
						<td>'.$donnees['id_art'].'</td>
						<td>'.$donnees['auteur'].'</td>
						<td>'.$donnees['titre'].'</td>
						<td>'.$donnees['id_categ'].'</td>
						<td>'.$donnees['categorie2'].'</td>
						<td>'.$donnees['prix'].'</td>
						<td>'.$donnees['quantite_produit'].'</td>
						<td>'.$donnees['sold_out'].'</td>
					</tr>';
				}
		$query->closeCursor();
		$query = NULL; 
		if($compteur===0){echo '<h2>Stock</h2><p>Pas d\'alerte</p>';}
			else {echo '</table>';}
			
			
			
//<!-- Dernières commandes -->
		echo '<h2>Facture : 5 dernières commandes</h2>';

		$query = $db->query('SELECT * FROM ligne_cde NATURAL JOIN site_user NATURAL JOIN categorie2 JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture WHERE etat = \'attente\' ORDER BY facture.date_facture DESC LIMIT 0 , 5 ');
		$V_orderid=0;			
		echo '<table border=1>';
			while ($donnees = $query ->fetch())
				{		
					if($donnees['order_id'] !== $V_orderid){
						echo '<tr><td COLSPAN =7>FACTURE n° '.$donnees['order_id'].'</td></tr>';
						echo '<tr><td COLSPAN =7>'.$donnees['id_user'].' '.$donnees['nom'].' '.$donnees['date_facture'].'</td></tr>';
						echo '<tr><td COLSPAN =7><strong>TOTAL TTC = '.$donnees['total'].'&#8364</strong></td></tr>';
						}
					echo 
						'<tr>
							<td>'.$donnees['id_art'].'</td>
							<td>'.$donnees['auteur'].'</td>
							<td>'.$donnees['titre'].'</td>
							<td><i>'.$donnees['categorie2'].'<i></td>
							<td>'.$donnees['quantite'].'</td>
							<td>'.($donnees['quantite']*$donnees['prix']).'&#8364</td>
						</tr>';
						
					$V_orderid=$donnees['order_id'];
				}
		$query->closeCursor();
		$query = NULL; 
		echo '</table>';
			
			
			
//<!-- Commentaires non validés-->
		echo '<h2>Modérateur : commentaires non validés</h2>';
		$compteur=0;
		$query = $db->query('SELECT * FROM commentaire NATURAL JOIN site_user JOIN article ON commentaire.id_art = article.id_art WHERE valider=\'non\'');					
			while ($donnees = $query ->fetch())
				{		
	
					if($compteur===0)
						{
							echo
								'<table border=1>
								<form method="post" >
									<tr>
										<td>Membre</td>
										<td>Article (id + titre)</td>
										<td>Date</td>
										<td>Commentaire</td>
										<td>Valider ?</td>
									</tr>';
							}
					$compteur++;								
					echo 
						'<tr>
							<td>'.$donnees['id_user'].' = '.$donnees['nom'].' '.$donnees['prenom'].'</td>
							<td>'.$donnees['id_art'].' ('.$donnees['titre'].')</td>
							<td>'.$donnees['date_com'].'</td>
							<td>'.$donnees['commentaire'].'</td>
							<td><input type="checkbox" name="valider[]" value="'.$donnees['id_com'].'"/></td>
						</tr>';
				}
		$query->closeCursor();
		$query = NULL; 
		if($compteur===0){echo '<p>Pas de message en attente de validation</p>';}
			else {echo '</table>
						<input type="submit"/></form>';}	

		
	?>
	

	<div class="clr"></div>
	<!--info ferme la div categorie-->
	</div>

	
	
	
	
<!--div footer-->
<?php include("../footer.php");
