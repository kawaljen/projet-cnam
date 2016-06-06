<?php
session_start();
include("tools/connectbd.php");
include("functions/fonction_panierbd.php");
include ("functions/function_message.php");

//AJOUT ARTICLE DANS LA VARIABLE SESSION PANIER
if(isset($_POST['detail']))		
		ajoutpanierGeneral($_POST['detail']);

//AJOUT COMMENTAIRE
if(isset($_POST['commentaire']))
		ajout_avis($db, $_POST['commentaire'], $_POST['detail']);
		
//HTML head
	$titrepage="Catalogue détail";
	$js=true;
	include('head.php');
?>
<body>
<div id="divajout" class="dispnone">
	<div><p>Vous venez d'ajout 1 article dans votre panier</p>
	</div>
</div>
<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("menu.php");?>
	

<!--diaporam_catalogue-->	
<?php
	$article= (isset($_POST['detail'])? $_POST['detail']:  (isset($_GET['detail'])? $_GET['detail']:null ));
	$article=htmlentities($article,ENT_QUOTES);
?>
	
<!--div detail-->
	<div id="detail">
<?php
	//print_r($_SESSION['panier']);
	$query = 'SELECT * FROM article NATURAL JOIN categorie WHERE article.id_art= ? AND sold_out =\'non\'';
	$db->query("SET NAMES 'utf8'");
	$prep = $db->prepare($query);
	$prep->bindValue(1, $article, PDO::PARAM_INT);	
	$prep->execute();
	if ($prep ->rowCount()<1) {
		header("location:catalogue.php");
		}
		while ($donnees = $prep ->fetch()){		
?>
					<div class="article">
						<div class="img_detail">
							<img src="img/article/id<?php echo $donnees['id_art']; ?>.jpg" alt="<?php echo $donnees['titre'].' '.$donnees['auteur'];?>" width="150" height="150"/>
							<img src="img/article/id<?php echo $donnees['id_art']; ?>.jpg" alt="<?php echo $donnees['titre'].' '.$donnees['auteur'];?>" width="150" height="150"/>
							<img src="img/article/id<?php echo $donnees['id_art']; ?>.jpg" alt="<?php echo $donnees['titre'].' '.$donnees['auteur'];?>" width="150" height="150"/>
						</div>
						<div class="topo">
								<h2><?php echo $donnees['titre']; ?></h2>
								<h3><span class="detail"><?php echo $donnees['auteur']; ?></span></h3>
								<p class="description"><?php echo $donnees['description']; ?></p>
								<form method="post" action="catalogue_detail.php">
									<input type="hidden" name="detail" value="<?php echo $article; ?>"/>
									<input type="image" src="img/icon/ajout_panier.png" alt="ajouter au panier" width="136" height="41"  align="middle"/>
								</form>
							</div>
					<div class="clr"></div>
					</div>				
<?php				
					if(isset($_SESSION['id_user']))
						{
							echo '<div class="commentaire"><h3>Laisser un avis</h3>';
							echo '<form method="post" action="catalogue_detail.php"/>';
							echo '<textarea name="commentaire" row="5" cols="90"></textarea>';
							echo '<input type="hidden" name="detail" value="'.$article.'"/>';
							echo '<input type="image" src="img/icon/bouton_ajoutcom.png" alt="ajouter un commentaire" width="136" height="41"  align="middle"/></div>';
						
						}
				

			}
	$prep->closeCursor();
	$prep = NULL; 
	
	//requete commentaires
	$compteur= 0;
	$query='SELECT commentaire, date_com, username FROM commentaire NATURAL JOIN site_user WHERE id_art=? AND valider=\'oui\' ';
	$prep =$db -> prepare($query);
	$prep -> bindValue(1, $article, PDO::PARAM_INT);
	$prep -> execute();
		while($donnees = $prep -> fetch()){
				if($compteur===0)
					{	
						echo "<div class=\"commentaire\">";
						echo "<h3>Commentaires</h3>";
					}
				echo "<p class=\"com\">".$donnees['commentaire']."<br/>";
				echo "<span class=\"username\">De ".$donnees['username']."</span><span class=\"date\"> -- ".$donnees['date_com']."</span></p>";
				$compteur++;
					if(isset($_SESSION['niveau'])){
						if($_SESSION['niveau']===3 || $_SESSION['niveau']===2)
							 echo '<a href="catalogue_detail.php?action=suppr&amp;>Supprimer</a>';
						}

		}
	echo '</div>';
	$prep ->closeCursor();
	$prep= null;


?>
	
	
	
	</div>
	<div class="clr"></div>
	
	
	
	
<!--div footer-->
 <?php include('footer.php');
