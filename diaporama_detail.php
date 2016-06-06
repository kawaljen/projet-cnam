	<div id="diap_catalogue">
	<div>
<?php	$article= (isset($_POST['detail'])? $_POST['detail']:  (isset($_GET['detail'])? $_GET['detail']:null ));
	$article=htmlentities($article,ENT_QUOTES);
	$categorie=' ';
	$query = 'SELECT * FROM article NATURAL JOIN categorie WHERE (id_art> ? AND id_art <= ?) AND sold_out =\'non\' ORDER BY id_categ';
	$prep = $db->prepare($query);
	$prep->bindValue(1, $article, PDO::PARAM_INT);
	$prep->bindValue(2, ($article +2), PDO::PARAM_INT);	
	$prep->execute();
		while ($donnees = $prep ->fetch()){		
				if ($donnees['categorie']!==$categorie){echo '</div><div class="categorie"><h2>'.$donnees['categorie'].'</h2>';}
					$categorie=$donnees['categorie'];
?>
					<div class="article">
						<img src="img/detail/id<?php echo $donnees['id_art']; ?>.jpg" alt="<?php echo $donnees['titre'].' '.$donnees['auteur'];?>" width="150" height="212"/>
							<div class="topo">
								<h3><?php echo $donnees['titre']; ?></h3>
								<p><span class="detail"><?php echo $donnees['auteur']; ?></span>
								</p>
							</div>
					</div>
<?php		}
	$prep->closeCursor();
	$prep = NULL; 
?>
	<!--ferme la dernière div class categorie-->
				</div>
	<!--ferme la div diap_categorie-->
	<div class="clr"></div>
	</div>
