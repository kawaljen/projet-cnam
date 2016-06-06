<?php
session_start();
include("../tools/connectbd.php");
//protection espace admin
	include ("../functions/function_admin.php");
	administrateur($db);
//HTML head
	$titrepage="Admin Général";
	include('../head.php');	
?>
<body>

<div id="container">

<!--Menu gauche + logo + Menu top droite-->	
<?php include("../menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="../images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>

<!--espace admin-->	
	<div id="esp_admin">
	<h1>Espace Admin</h1>
	<h2>-> Info membres</h2>
	<a href="admin_general.php" class="choixadmin">Général</a>
	<a href="admin_stock.php" class="choixadmin">Voir le Stock</a>
	<a href="admin_commande.php" class="choixadmin">Voir les commandes </a>
	<a href="admin_membre.php" class="choixadmin actif">Voir les info membres</a>
	
	
	
<!--Recherche commande-->
<h3>/// EN CONSTRUCTION ///</h3>
<!--CONSTRUCTION
					<a name="recherche"><h3>Affichez le profil d'un membre</h3></a>
					<div id="rech_art">
						<form method="post" action="admin_membre.php#recherche" name="1">
						<h5>Recherche par mot ou valeur</h5>
							<select name="recherche">
								<option value="0"></option>
								<option value="id_user">par identifiant</option>
								<option value="nom">par nom</option>							

							</select>
							<label for="rechercheprime"> Valeur : </label><input type="text" name="rechercheprime" />
							<input type="submit" value="chercher">
						</form>
					</div>

					<div class="construction">
					<h3>Affichez les avis</h3>
					<div id="rech_art">
						<form method="post" action="admin_membre.php#recherche" name="2">
						<h5>Recherche par mot ou valeur</h5>
							<select name="recherche2">
								<option value="0"></option>
								<option value="id_user">par identifiant membre</option>
								<option value="id_art">par id article</option>							

							</select>
							<label for="rechercheprime2"> Valeur : </label><input type="text" name="rechercheprime" size=7/>
							<input type="submit" value="chercher">
						</form>
					</div>
					</div>

-->
			
			
<!-- Profil membre -->

	<?php
	//si recherche dans le formulaire par mot/valeur
		//entre la variable prep suivant l'option de recherhce et la valeur donnée
			//vérifie présence d'au moins un résultat
		//si option inconnue recherche normale

	//sinon recherche normale
		if(!empty($_POST['recherche'])){
			if($_POST['recherche']==='id_user')	{
				$query='SELECT * FROM site_user JOIN ligne_cde ON site_user.id_user = ligne_cde.id_user JOIN article ON ligne_cde.id_art = article.id_art JOIN facture ON facture.id_user = site_user.id_user JOIN commentaire ON site_user.id_user=commentaire.id_user JOIN categorie2 ON ligne_cde.id_categ2 = categorie2.id_categ2 WHERE site_user.id_user =?';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_INT);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='La recherche n\'a donné aucun résultat';
					}
				}
			else if($_POST['recherche']==='nom')	{
				$query='SELECT * FROM site_user JOIN ligne_cde ON site_user.id_user = ligne_cde.id_user JOIN article ON ligne_cde.id_art = article.id_art JOIN facture ON facture.id_user = site_user.id_user JOIN commentaire ON site_user.id_user=commentaire.id_user JOIN categorie2 ON ligne_cde.id_categ2 = categorie2.id_categ2 WHERE nom= ?';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
					}
				}
			
			echo '<h2>choix de recherche : '.$_POST['recherche'].' : '.$_POST['rechercheprime'].'</h2>';
	
			if(isset($messRech)){echo $messRech;}
		

				$V_orderid=0;			
				while ($donnees = $prep ->fetch())
					{		
						if($donnees['order_id'] !== $V_orderid){
							
							echo '<p>Identifiant '.$donnees['id_user'].'</p><p> '.$donnees['nom'].' '.$donnees['prenom'].'<p></p> '.$donnees['email'].'</p>';
							echo '<p>'.$donnees['adress'].'</p>';
							echo '<h3>Avis </h3>';
							echo '<h4>'.$donnees['titre'].' ('.$donnees['id_art'].')</h4>';
							echo '<p><i>'.$donnees['date_com'].'</i></p>';
							echo '<p>'.$donnees['commentaire'].'</p>';
							
							echo '<h3>FACTURE n° '.$donnees['order_id'].'</h3>';
							echo '<p><strong>TOTAL TTC = '.$donnees['total'].'&#8364</strong></p>';
							echo '<p>Date facture : '.$donnees['date_facture'].'</p><table>';
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
			$prep->closeCursor();
			$prep = NULL; 
			echo '</table>';
		}	
			
			

	?>
	

	<div class="clr"></div>
	<!--info ferme la div categorie-->
	</div>

	
	
	
	
<!--div footer-->
<?php include("../footer.php");
