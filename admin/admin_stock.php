<?php
session_start();
include("../tools/connectbd.php");

//protection espace admin
	include ("../functions/function_admin.php");
	administrateur($db);
	
	
//Si le tableau des POST pour l'ajout d'article n'est pas vide = pas de tentative d'ajout ou de modification
	//Si les champs obligatoire sont remplis
		//si ils'agt d'un modif
				//update
		//si il s'agit d'un ajout
			//Si l'article n'existe pas déjà dans le type de categ2 demandé
				//recherche du nouvel id pour l'article
				//insertion dans la bd
				
if(!empty($_POST['Ajout'])) {
	if(count($_POST['Ajout'])===6){
		$titre=htmlentities($_POST['Ajout'][0],ENT_QUOTES);
		$auteur=htmlentities($_POST['Ajout'][1],ENT_QUOTES);
		$annee=htmlentities($_POST['Ajout'][2],ENT_QUOTES);
		$id_categ1=htmlentities($_POST['Ajout'][3],ENT_QUOTES);
		$prix=htmlentities($_POST['Ajout'][4],ENT_QUOTES);
		$quantite=htmlentities($_POST['Ajout'][5],ENT_QUOTES);
		$desc=htmlentities($_POST['Adescription'],ENT_QUOTES);
		$id_categ2=htmlentities($_POST['Aedition'],ENT_QUOTES);
		if(isset($_POST['suspendre'])){$sold_out='oui';}else{$sold_out='non';}
		if(isset($_POST['id_art'])){$id_art=htmlentities($_POST['id_art'],ENT_QUOTES);}
		if(isset($_POST['id_categ2'])){$id_categ2=htmlentities($_POST['id_categ2'],ENT_QUOTES);}
	
		if($_POST['choix']==='modifier')
			{
					
					$req= $db -> prepare('UPDATE categorie2 SET prix=:prix, quantite_produit=:quantite WHERE id_art=:id_art AND id_categ2=:id_categ2');
					$req->execute(array(
					'id_art' => $id_art,
					'id_categ2' => $id_categ2,
					'prix' => $prix,
					'quantite' => $quantite,
					));
					$req=null;	
						
					$req = $db -> prepare('UPDATE article SET titre=:titre, auteur=:auteur, annee=:annee, description=:description, id_categ=:id_categ, sold_out=:sold_out WHERE id_art=:id_art');
					$req->execute(array(
					'id_art' => $id_art,
					'titre' => $titre,
					'auteur' => $auteur,
					'annee' => $annee,
					'description' => $desc,
					'id_categ' => $id_categ1,
					'sold_out' => $sold_out
					));
					$req=null;
			 
					$mess2= '<p class="mess">L\'article a bien été modifié </p>';	
					$_POST['recherche']='id_art';
					$_POST['rechercheprime']=$id_art;
								
			}		
		
		
		
		
		else if($_POST['choix']==='ajout')
			{
				$query ='SELECT * FROM article JOIN categorie2 ON article.id_art= categorie2.id_art WHERE titre= :titre AND auteur= :auteur AND annee= :annee AND id_categ2=:id_categ2';
				$prep = $db -> prepare($query);
				$prep -> bindValue('titre', $titre);
				$prep -> bindValue('auteur', $auteur);
				$prep -> bindValue('annee', $annee);
				$prep -> bindValue('id_categ2', $id_categ2);
				$prep -> execute();
					if($prep -> rowCount() <1) {
							$prep ->  closeCursor();
							$prep = null;
						
							$prep = $db -> query ('SELECT MAX(id_art) AS max FROM article');
							$donnees= $prep -> fetch();
							$id_art=$donnees['max'];							
							$id_art++;
							
							$req= $db -> prepare('INSERT INTO categorie2 (id_art, id_categ2, categorie2, prix, quantite_produit)VALUES (:id_art, :id_cat2, :categorie2, :prix, :quantite_produit)');
							$req->execute(array(
							'id_art' => $id_art,
							'id_cat2' => $id_categ2,
							'categorie2' => $annee,
							'prix' => $prix,
							'quantite_produit' => $quantite,
							));
							$req=null;	
								
							$req = $db -> prepare('INSERT INTO article (id_art, titre, auteur, annee, description, id_categ, sold_out)VALUE(:id_art, :titre, :auteur, :annee, :description, :id_categ, :sold_out)');
							$req->execute(array(
							'id_art' => $id_art,
							'titre' => $titre,
							'auteur' => $auteur,
							'annee' => $annee,
							'description' => $desc,
							'id_categ' => $id_categ1,
							'sold_out' => $sold_out
							));
							$req=null;
					 
							$mess= '<p>L\'article a bien été ajouté ! Son id-article est '.$id_art.'.</p>';	
							$_POST['recherche']='id_art';
							$_POST['rechercheprime']=$id_art;
								
						}
					else {$mess='<p class="mess">Il semble que l\'article existe déjà dans la base de données (critère de vérification = titre, auteur, annee et type d\'édition), cette nouvelle entrée n\'a pas été enregistré.</p>';}
			}
		}
	else {$mess='<p class="mess">Vous n\'avez pas rempli les champs obligatoires, l\'article n\'a pas été enregistré.</p>'; }
	}	
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
	<h2>Stock</h2>
	<a href="admin_general.php" class="choixadmin">Général</a>
	<a href="admin_stock.php" class="choixadmin actif">Voir le Stock</a>
	<a href="admin_commande.php" class="choixadmin">Voir les commandes </a>
	<a href="admin_membre.php" class="choixadmin">Voir les info membres</a>

			
<!-- Mofifier article-->
					<?php
					//vérifie la presence de variable GET modifier1
					$modifier1=(isset($_GET['modifier1'])? $_GET['modifier1']:null );
					
					if($modifier1!==null || isset($_POST['choix'])==='modifier'){
						if($_POST['choix']==='modifier'){
							$modifier1=htmlentities($modifier1, ENT_QUOTES);
							$modifier2=htmlentities($_GET['modifier2'], ENT_QUOTES);
							echo '<h3>Modifier un article</h3>';
							$query= 'SELECT * FROM article NATURAL JOIN categorie2 WHERE id_art = ? AND id_categ2= ?';
							$prep= $db ->prepare($query);
							$prep-> bindValue(1, $modifier1, PDO::PARAM_INT);
							$prep->bindValue(2, $modifier2, PDO::PARAM_INT);
							$prep->execute();
								while ($donnees = $prep -> fetch())
									{
										echo '<form method="POST" action="admin_stock.php#recherche"/>';
										echo '
												<div><input type="checkbox" name="effacer"/><label for="effacer">Effacer définitivement l\'article de la bd</label></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['titre'].'"/><label for="titre">Titre* : </label></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['auteur'].'"/><label for="auteur">Auteur* : </label></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['annee'].'"/><label for="annee">Année* : </label></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['id_categ'].'"/><label for="prix">Id genre*</label></div>
												<div><textarea name="Adescription"/>'.$donnees['description'].' </textarea></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['prix'].'" /><label for="prix">Prix*</label></div>
												<div><input type="text" name="Ajout[]" value="'.$donnees['quantite_produit'].'" /><label for="prix">Quantité*</label></div>
												<div><input type="checkbox" name="suspendre"/><label for="suspendre">Suspendre la vente</label></div>
												<input type="hidden" name="choix" value="modifier"/>
												<input type="hidden" name="id_art" value="'.$modifier1.'"/>
												<input type="hidden" name="id_categ2" value="'.$modifier2.'"/>
												<input type="hidden" name="AEdition" value="'.$donnees['id_categ2'].'"/>
												<input type="submit" value="envoyer"/>
										</form>';
									}
							}
						}
?>
<!--Recherche artcle-->
					<a name="recherche"><h3>Recherche articles</h3></a>
					<div id="rech_art">
						<form method="post" action="admin_stock.php#recherche" name="1">
						<h5>Recherche par mot ou valeur</h5>
							<select name="recherche">
								<option value="0"></option>
								<option value="id_art">par id article</option>
								<option value="titre">par titre</option>
								<option value="auteur">par auteur</option>
								<option value="annee">par annee de publication</option>
								<option value="quantite">dont la quantité est < à </option>
							</select>
							<label for="rechercheprime"> Valeur : </label><input type="text" name="rechercheprime"/>
							<input type="submit" value="chercher">
						</form>
						<form method="post" action="admin_stock.php#recherche" name="2">
						<h5>Recherche par catégorie</h5>
							<label for="recherche2">Type d'édition : </label>
							<select name="recherche2">
								<option value="0"></option>
								<option value="1">Edition normale</option>
								<option value="2">Edition limitée</option>
							</select>
							<input type="hidden" name="choix" value="ajout"/>
							<input type="submit" value="chercher">
						</form>
					</div>
					
					
<!--Liste artcle-->

				<?php
				//si recherche dans le formulaire par mot/valeur
					//entre la variable prep suivant l'option de recherhce et la valeur donnée
						//vérifie présence d'au moins un résultat
				//si recherche par catégorie
					//entre la variable prep suivant l'option de recherhce 
				//sinon recherche normale
					if(isset($_POST['recherche'])){
						if($_POST['recherche']==='id_art')	{
							$query='SELECT * FROM article NATURAL JOIN categorie2 WHERE id_art =?';
							$prep = $db ->prepare($query);
							$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_INT);
							$prep -> execute();
							if($prep -> rowCount()===0) {
								$messRech='La recherche n\'a donné aucun résultat';
								}
							}
						else if($_POST['recherche']==='titre')	{
							$query='SELECT * FROM categorie2 NATURAL JOIN article WHERE titre LIKE ?';
							$prep = $db ->prepare($query);
							$prep ->bindValue(1, "%".$_POST['rechercheprime']."%", PDO::PARAM_STR);
							$prep -> execute();
							if($prep -> rowCount()===0) {
								$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
								}
							}
						else if($_POST['recherche']==='auteur')	{
							$query='SELECT * FROM article NATURAL JOIN categorie2 WHERE auteur LIKE ?';
							$prep = $db ->prepare($query);
							$prep ->bindValue(1, "%".$_POST['rechercheprime']."%", PDO::PARAM_STR);
							$prep -> execute();
							if($prep -> rowCount()===0) {
								$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
								}
							}
						else if($_POST['recherche']==='annee')	{
							$query='SELECT * FROM article NATURAL JOIN categorie2 WHERE annee =?';
							$prep = $db ->prepare($query);
							$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_STR);
							$prep -> execute();
							if($prep -> rowCount()===0) {
								$messRech='<p class="mess">La recherche n\'a donné aucun résultat</p>';
								}
							}
						else if($_POST['recherche']==='quantite')	{
							$query='SELECT * FROM article NATURAL JOIN categorie2 WHERE quantite_produit <?';
							$prep = $db ->prepare($query);
							$prep ->bindValue(1, $_POST['rechercheprime'], PDO::PARAM_INT);
							$prep -> execute();
							if($prep -> rowCount()===0) {
								$messRech='<p class="mess">Aucun article n\'a son stock inférieur à  '.$_POST['rechercheprime'].' article(s)</p>';
								}
							}
					
						}
					else if(isset($_POST['recherche2']) && $_POST['recherche2'] !== 0)	{
						$query='SELECT * FROM article NATURAL JOIN categorie2 WHERE id_categ2 =?';
						$prep = $db ->prepare($query);
						$prep ->bindValue(1, $_POST['recherche2'], PDO::PARAM_INT);
						$prep -> execute(); 
							}


					if(isset($mess2)){echo $mess2;}
					
					if(!empty($_POST['recherche']) || !empty($_POST['recherche2'])){
						echo '<h4>>> Choix de recherche : ';
						if(isset($_POST['recherche'])){ 
							echo $_POST['recherche'].' = '.$_POST['rechercheprime'].'</h4>';}
						else {echo $_POST['recherche2'].'</h4>';}
						if (!isset ($messRech)){
							echo '<table border=1>
									<tr>
										<td>id</td>
										<td>Auteur</td>
										<td>Titre</td>
										<td>Catégorie</td>
										<td>Edition limitée</td>
										<td>Prix</td>
										<td>Quantité produit</td>
										<td>Suspendre</td>
										<td>Modifer</td>
									</tr>';
							
						
								while ($donnees = $prep ->fetch())
									{		
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
											<td><a href="admin_stock.php?modifier1='.$donnees['id_art'].'&amp;modifier2='.$donnees['id_categ2'].'&amp;">XX</a></td>
										</tr>';
								}
								$prep->closeCursor();
								$prep = NULL; 
								echo '</table>';
							}
						else {echo $messRech;}
					}
				?>
					
<!--Ajout artcle-->
					<h3>Ajouter un article</h3>
					<?php if(isset($mess)){echo $mess;}?>
					<p>Les champs avec une asterisque sont obligatoires</p>
					<div id="ajout_stock">
						<form method="post" action="admin_stock.php">
							<div><input type="text" name="Ajout[]" /><label for="titre">Titre* : </label></div>
							<div><input type="text" name="Ajout[]" /><label for="auteur">Auteur* : </label></div>
							<div><input type="text" name="Ajout[]" /><label for="annee">Année* : </label></div>
							<div><input type="text" name="Ajout[]" /><label for="prix">Id genre*</label></div>
							<div><textarea name="Adescription"/>Description </textarea></div>
							<div><select name="Aedition">
								<option value="1">Edition normale</option>
								<option value="2">Edition limitée</option>
							</select></div>
							<div><input type="text" name="Ajout[]" /><label for="prix">Prix*</label></div>
							<div><input type="text" name="Ajout[]" /><label for="prix">Quantité*</label></div>
							<div><input type="checkbox" name="suspendre"/><label for="suspendre">Suspendre la vente</label></div>
							<input type="submit" value="envoyer"/>
						</form>
					</div>

	<div class="clr"></div>
	<!--info ferme la div categorie-->
	</div>

	
	
	
	
<!--div footer-->
<?php include("../footer.php");
