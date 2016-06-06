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
<!--Menu gauche + logo-->
	 <nav id="gauche">
        <a href="#" id="logo"><img src="../images/logo.png" width="171" height="162"   alt="popup edition" /></a>
        
		<div id="nav">
			<ul>
				<li><a class="association" href="../association.php" ><span><img src="../images/association.png" alt="Association"/></span></a></li>
				<li><a class="auteurs" href="../auteurs.php" ><span><img src="../images/auteurs.png" alt="Auteurs"/></span></a></li>
				<li><a class="catalogue" href="../catalogue.php" ><span><img src="../images/catalogue.png" alt="Catalogue"/></span></a></li>
			</ul>
        </div>
	</nav>
<!--Menu top droite-->	
	<div id="haut">
			<div id="menutop">
				<ul>
					<li><a class="lk_contact" href="../contact.php" ><span>Contact</span></a></li>
					<li><a class="lk_esp_menb" href="../connection.php" ><span>Espace perso</span></a></li>
					<li><a class="lk_facebook" href="#" target="_blank" ><span>Facebook</span></a></li>
				</ul>
			</div>
			<div id="panier"><a href="#" target="_blank">
				<img src="images/panier_vide.png" width="80" height="27" alt="Panier" /></a>
			</div>
	 </div>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="../images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>

<!--espace admin-->	
	<div id="esp_admin">
	<h1>Espace Admin</h1>
	<h2>-> Commandes</h2>
	<a href="admin_general.php" class="choixadmin">Général</a>
	<a href="admin_stock.php" class="choixadmin">Voir le Stock</a>
	<a href="admin_commande.php" class="choixadmin actif">Voir les commandes </a>
	<a href="admin_membre.php" class="choixadmin">Voir les info membres</a>
	
	
	
<!--Recherche commande-->
					<a name="recherche"><h3>Recherche Commandes</h3></a>
					<div id="rech_art">
						<form method="post" action="admin_commande.php#recherche" name="1">
						<h5>Recherche par mot ou valeur</h5>
							<select name="recherche">
								<option value="0"></option>
								<option value="orderid">par numéro de commande</option>
								<option value="annee">par annee de commande</option>							
								<option value="id_art">par id article</option>
								<option value="titre">par titre</option>
								<option value="auteur">par auteur</option>

							</select>
							<label for="rechercheprime"> Valeur : </label><input type="text" name="rechercheprime" size=7/>
							<input type="submit" value="chercher">
						</form>
					</div>
					


			
			
<!-- Liste commandes -->

	<?php
	//si recherche dans le formulaire par mot/valeur
		//entre la variable prep suivant l'option de recherhce et la valeur donnée
			//vérifie présence d'au moins un résultat
		//si option inconnue recherche normale

	//sinon recherche normale
		if(!empty($_POST['recherche'])){
			if($_POST['recherche']==='id_art')	{
				$query='SELECT * FROM ligne_cde NATURAL JOIN site_user JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture WHERE ligne_cde.id_art =?';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_INT);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='La recherche n\'a donné aucun résultat';
					}
				}
			else if($_POST['recherche']==='orderid')	{
				$query='SELECT * FROM ligne_cde NATURAL JOIN site_user JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture WHERE order_id= ?';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
					}
				}
			else if($_POST['recherche']==='titre')	{
				$query='SELECT * FROM ligne_cde NATURAL JOIN site_user JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture WHERE titre LIKE \'%?%\'';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
					}
				}
			else if($_POST['recherche']==='auteur')	{
				$query='SELECT * FROM ligne_cde NATURAL JOIN site_user JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture WHERE auteur LIKE \'%?%\'';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
					}
				}
			else if($_POST['recherche']==='annee')	{
				$query='SELECT * FROM ligne_cde NATURAL JOIN site_user JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture HAVING EXTRACT(YEAR FROM date_facture) = ?';
				$prep = $db ->prepare($query);
				$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
				$prep -> execute();
				if($prep -> rowCount()===0) {
					$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
					}
				}
		
			}


		else {
			$prep = $db-> query('SELECT * FROM ligne_cde NATURAL JOIN site_user NATURAL JOIN categorie2 JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture ORDER BY facture.date_facture LIMIT 0 , 10');					
			}
		if(!empty($_POST['recherche'])){
			echo '<h2>choix de recherche : '.$_POST['recherche'].' : '.$_POST['rechercheprime'].'</h2>';
			}
		else {echo '<h2>10 Dernières factures</h2>';}
	

		if(isset($mess2)){echo $mess2;}
		if(isset($messRech)){echo $messRech;}
	

			$V_orderid=0;			
			while ($donnees = $prep ->fetch())
				{		
					if($donnees['order_id'] !== $V_orderid){
						echo '<p>---------------------------------------------------------------------------------------------------------------------</p>';
						echo '<h3>FACTURE n° '.$donnees['order_id'].'</h3>';
						echo '<p>'.$donnees['id_user'].' '.$donnees['nom'].' '.$donnees['prenom'].' '.$donnees['email'].'</p>';
						echo '<p><strong>TOTAL TTC = '.$donnees['total'].'&#8364</strong></p>';
						echo '<p>Date facture : '.$donnees['date_facture'].'</p><table>';
						}
					echo 
						'<tr>
							<td>'.$donnees['id_art'].'</td>
							<td>'.$donnees['auteur'].'</td>
							<td>'.$donnees['titre'].'</td>
							<td><i>'.$donnees['categorie2'].'<i></td>
							<td>'.$donnees['quantite_produit'].'</td>
							<td>'.($donnees['quantite_produit']*$donnees['prix']).'&#8364</td>
						</tr>';
						
					$V_orderid=$donnees['order_id'];
				}
		$prep->closeCursor();
		$prep = NULL; 
		echo '</table>';
			
			
			

	?>
	

















	

	<div class="clr"></div>
	<!--info ferme la div categorie-->
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



</body>
</html>
