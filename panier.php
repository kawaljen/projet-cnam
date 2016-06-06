<?php 
session_start();
	include("tools/connectbd.php");
include_once("functions/fonction_panierbd.php");

$erreur = false;
//les renvoies à fonction_panier
$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null ));
if(!in_array($action,array('suppression')))
   {$erreur=true;}
if (!$erreur){
	include("tools/connectbd.php");
   switch($action){
		Case "suppression":
			$lgncde= (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
			supprimerArticle($lgncde, $db);
         break;

      Default:
         break;
   }
    
}
//HTML head
	$js=true;
	$titrepage="Panier";
	include('head.php');
?>

<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("menu.php");?>
<!--Panier-->		 
		<div id="block_panier">
			<div id="menu">
					<ul >
						<li><a href="panier.php" ><span id="gdeli1"></span>Votre panier</a></li>
						<li><span id="gdeli2bck"></span>Connexion</li>
						<li><span id="gdeli3bck"></span>Identification</li>
						<li><span id="gdeli4bck"></span>Récapitulatif</li>
						<li><span id="gdeli5bck"></span>Paiement</li>
					</ul>
					<div class="clr"></div>
			</div>	
			<div id="panier2">
				<?php if(isset($_SESSION['pageprec'])){echo '<a href="'.$_SESSION['pageprec'].'">Retour au site</a>';} ?>
				<form method="post" action="panier/connexion.php">
					<table>
						<tr>
							<td id="titrepan" colspan="4"><h2>Votre panier</h2></td>
						</tr>
	
						<tr id="fondpan">
							<td>Libellé</td>
							<td>Quantité</td>
							<td>Type d'édition</td>
							<td>Prix/article</td>
							<td>Total/article</td>
							<td>Supprimer</td>
						</tr>
<?php	
						if(isset($_SESSION['panier'])){
							$tabVdouble=array();
							$nbArticles=count($_SESSION['panier']);
							if ($nbArticles > 0){	
								for($j=0;$j<$nbArticles;$j++){
									$vdouble = array_search($_SESSION['panier'][$j], $tabVdouble);
									if ($vdouble === false){ 	
											//variable pour verifier les doublons
											$tabVdouble[]=$_SESSION['panier'][$j];
											//variables pour les options possibles pour l'articles -> categorie2
											$categ2=array();
											$categ2nom=array();
											$query='SELECT *, COUNT(id_categ2) AS "nbcateg2" FROM article NATURAL JOIN categorie2 WHERE id_art = ?';
											$prep=$db ->prepare($query);
											$prep->bindValue(1, $_SESSION['panier'][$j], PDO::PARAM_INT);
											$prep->execute();
												$donnees= $prep ->fetch();
													
												//petit fix rapide pour gérer la categ2
												if($donnees['nbcateg2']>1){
													$categ2[0]=1;
													$categ2[1]=2;
													$categ2nom[0]='Normale';
													$categ2nom[1]='Edition limitée';
													}
												else{
													$categ2[]=$donnees['id_categ2'];
													$categ2nom[]=$donnees['categorie2'];}
												//on enregistre la variable lgncde pour la fonction suppression
												$lgncde=$donnees['id_art'];
												echo '<tr>';
												echo "<td class=\"tdlibele\"><span >".$donnees['auteur'].$donnees['titre']." </span></td>";	
												echo "<td><input type=\"text\" size=\"4\" id=\"qte".$j."\" name=\"qte".$j."\" value=\"1\"  onkeyup=\"calcultotal(".$nbArticles.")\"/></td>";										
												
												if(count($categ2)>1){
													echo '<td><select name="souscateg'.$j.'" id="souscateg'.$j.'" onchange="panier_udpdate('.$donnees['id_art'].','.$nbArticles.','.$j.')">';
													for ($i=0; $i<count($categ2); $i++){
														if(isset($_SESSION['artid']['categ2'][$j])){
															if ($_SESSION['artid']['categ2'][$j]===$categ2[$i])
																	echo '<option value="'.$categ2[$i].'" selected="selected">'.$categ2nom[$i].'</option>';
																else
																	echo '<option value="'.$categ2[$i].'" >'.$categ2nom[$i].'</option>';
															}
														else
															echo '<option value="'.$categ2[$i].'" >'.$categ2nom[$i].'</option>';
														}
													echo '</select></td>';
													}
												else
													{echo '<td>'.$categ2nom[0].'</td>
															<input type="hidden" name="souscateg'.$j.'" value="'.$categ2[0].'"/>';
													
													}

												echo '<td class=\"tdprix\"><span id="sp_prix'.$j.'">'.$donnees['prix'].'</span> &#8364</td>';
												echo '<td class=\"tdprix\"><span id="sp_prixtotal'.$j.'">'.$donnees['prix'].'</span> &#8364</td>';
												echo "<td><a href=\"".htmlspecialchars("panier.php?action=suppression&l=".rawurlencode($lgncde))."\"><img src=\"../images/banners/bin.png\"alt=X /></a></td></tr>";

												
											$prep->closeCursor();
											$prep=null;

										}
									else
										unset($_SESSION['panier'][$j]);
									}
								}
							}
							else	
								echo "<tr><td>Votre panier est vide</td></tr></table>";	
echo '<tr><td id="tdprixtotal" COLSPAN=6 class="floatright">Total : <span id="sp_total"></span>&#8364 </td></tr>'; 	

echo "</table>";
if(isset($lgncde))echo'<input type="hidden" name="ajout" value="ajout"/><input type="submit" class="floatright" value="page suivante"/></form>	';
?>
<div class="espace"></div>
</div></div>

<!--div footer-->
 <?php include('footer.php');
