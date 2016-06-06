<?php
session_start();
include("../tools/connectbd.php");


//fonction de protection des espaces membres
include("../functions/function_protection.php");
	membre($db);


if(isset($_SESSION['artid']['id'])){
	include_once("fonction_recap.php");
	ajoutNewpanier($db);
}



//HTML head
	$titrepage="Paiement";
	include('../head.php')
?>
<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("../menu.php");?>


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

			<h2>Paiement</h2>
			<div id="topo">

			<p>Pour la sécurité des paiements en ligne, nous utilisons Systempay, la solution de paiement par carte bancaire mise au point par notre banque, la Caisse d'épargne.<br/>
			Ainsi les numéros de carte ne transitent jamais en clair sur le réseau Internet : ils sont cryptés selon le procédé SSL (Secure Socket Layer). Ce procédé propose une sécurité maximale et est utilisé par l'ensemble des boutiques en ligne pour les transactions de ce type. En cliquant sur le lien "accéder à la plateforme de paiement" de notre panier, vous serez redirigés vers les pages de paiement Systempay Paiement (adresse sécurisée en https). Une fois vos coordonnées bancaires renseignées, elles seront envoyées par une connexion cryptée à la Caisse d'épargne. La Caisse d'épargne pourra alors effectuer les demandes d'autorisation relatives à tous paiements.<br/>
			La Caisse d'épargne est le seul destinataire des informations carte ; Nous ne sommes pas en mesure de les connaître. Vous pouvez ainsi effectuer votre paiement en ligne en toute sécurité.</p>

			</div>
			
			<h2>Votre commande</h2>
			<?php

			 // requette identification : nom prenom
				$query ='SELECT * FROM site_user WHERE id = ?';
				//$db->query("SET NAMES 'utf8'");
				$prep = $db->prepare($query);
				$prep->bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
				$prep->execute();
					while ($donnees = $prep->fetch())
						{

							$id=$donnees['id'];
							echo '<div id="recap"><p><br/>Vous êtes : <span class="hilight">'.$donnees['nom'].' '. $donnees['prenom'].'</span></p>';
							echo '<p>Adresse : <span class="hilight">'.$donnees['adress'].' '.$donnees['complement_add'].', '. $donnees['codep'].' '.$donnees['ville'].'</span></p>';
							echo '<p> Email : <span class="hilight">'.$donnees['email'].'</span></p></div>';

						}
					$prep->closeCursor();
					$prep = NULL;
					
				echo '<table>';
					//libelé tableau
					echo '<tr id="fondpan"><td>Libellé</td>';
					echo '<td>Quantité</td>';
					echo '<td>Type d\'édition</td>';
					echo '<td>Prix TTC</td></tr>';

			//requette details issus de inscription 
					$article=array();
					$query ='SELECT * FROM ligne_cde JOIN article ON ligne_cde.id_art=article.id_art JOIN categorie2 ON ligne_cde.id_categ2 = categorie2.id_categ2 WHERE id_user = ? AND etat=\'attente\'';
					$db->query("SET NAMES 'utf8'");
					$prep = $db->prepare($query);
					$prep->bindValue(1,$_SESSION['id_user'], PDO::PARAM_INT);
					$prep->execute();

								while ($donnees = $prep->fetch())
									{
										echo "<tr><td class=\"tdlibele\">".$donnees['titre'].' '.$donnees['auteur']."</td>";							
										$prix[]=$donnees['prix'];
										echo '<td class="qte">'.$donnees['quantite'].'</td>';
										echo '<td class="qte">'.$donnees['categorie2'].'</td>';
										echo '<td class="tdprix">'.$donnees['prix'].'  &#8364</td></tr>';
										$verifarticle=1;
										$article[]=$donnees['id_art'];
									}
					$prep->closeCursor();
					$prep = NULL;

				echo '</table>';

//calcul du montant
if(isset($verifarticle))		
	{	
	$montant=0;
		for($k=0; $k<count($prix); $k++)
			{	
				$montant+=$prix[$k];
			}

	if(isset($remise)){	echo "<p id=\"tdremise\">Remise 5% : <span>".round($remise,2)." &#8364 </span></p>";}
	echo "<div id=\"tdprixtotal\"><p> Total : <span>".round($montant,2)." &#8364 </span></p></div>";	
	}



//mail

$reponse = $db->query('SELECT MAX(order_id) as max FROM ligne_cde');
$donnees = $reponse->fetch();
$id_order= $donnees['max'];
$reponse->closeCursor();
$id_order++;


		echo '<form method="post" action="plateforme.php">
			<input type="hidden" name="id_user" value="'.$_SESSION['id_user'].'"/>';
		
		for($i=0; $i<count($article);$i++){
			echo '<input type="hidden" name="article[]" value="'.$article[$i].'"/>';
		}
		echo '<input type="hidden" name="total" value="'.round($montant,2).'"/>
			  <input type="hidden" name="id_order" value="'.$id_order.'"/>';
?>			
		<input type="submit" value="acceder à la plateforme de paiement"/>



		</div>

		<a href="coordonnees.php">Etape précedente</a>
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
