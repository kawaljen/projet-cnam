<?php
session_start();
include("tools/connectbd.php");
//HTML head
	$titrepage="Catalogue";
	$js=true;
	include('head.php');
?>

<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="images/micronauts.png" width="700" height="193" alt="micronauts" />
	</div>

<!--catalogue-->	
	<div id="catalogue">
	<div id="titrecat">
		<h1>Catalogue</h1>
		<img src="images/catalogue2.png"  />
		<!--input recherche ajax-->
		<div id="divrecherche">	
			<input type="text" name="recherche" value="recherche rapide" onkeyup="recherche()" id="recherche" STYLE="width:200"/>
			<!--<input type="text" id="autocomplete"  disabled="disabled" />-->
			<div id="testeur"></div>	
		</div>
	</div>
	<!--petit fix pour la div class categorie-->
	<div class="categorie">
	<?php
	$categorie=' ';
	$query = $db->query('SELECT * FROM article NATURAL JOIN categorie WHERE sold_out =\'non\' ORDER BY id_categ');
		while ($donnees = $query ->fetch())
			{		
				if ($donnees['categorie']!==$categorie){echo '<div class="clr"></div></div><div class="categorie"><h2>'.$donnees['categorie'].'</h2>';}
					$categorie=$donnees['categorie'];
	?>
					<div class="article">
						<a href="catalogue_detail.php?detail=<?php echo $donnees['id_art']; ?>"><img src="img/detail/id<?php echo $donnees['id_art']; ?>.jpg" alt="<?php echo $donnees['titre'].' '.$donnees['auteur'];?>" width="150" height="150"/></a>
							<div class="topo">
								<a href="catalogue_detail.php?detail=<?php echo $donnees['id_art']; ?>"><h3><?php echo $donnees['titre']; ?></h3></a>
								<p><span class="detail"><?php echo $donnees['auteur']; ?></span>
								</p>
								<a href="catalogue_detail.php?detail=<?php echo $donnees['id_art']; ?>" class="lien_detail">-> Voir le descriptif</a>
							</div>
					</div>
<?php		}
	$query->closeCursor();
	$query = NULL; 
?>
	<!--ferme la dernière div class categorie-->
				<div class="clr"></div>
				</div>
	<!--ferme la div categorie-->
	<div class="clr"></div>
	</div>

	
	
	
	
<!--div footer-->
 <?php include('footer.php');
