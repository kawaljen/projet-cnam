<?php
session_start();
include("tools/connectbd.php");


$testid=false;
if(isset($_POST['action'])){
		
		$info=array();
		$testid=true;
		$info['nom']= htmlentities($_POST['nom'],ENT_QUOTES);
		$info['prenom']= htmlentities($_POST['prenom'],ENT_QUOTES);
		$info['adress']= htmlentities($_POST['adress']);
		if(isset($_POST['compl'])){$info['compl']= htmlentities($_POST['compl'],ENT_QUOTES);}else{$compl=null;}
		$info['codep']= htmlentities($_POST['codep'],ENT_QUOTES);
		$info['ville']= htmlentities($_POST['ville'],ENT_QUOTES);
		$info['email']= htmlentities($_POST['couriel'],ENT_QUOTES);
		if(isset($_POST['telfixe'])){$info['telfixe']= htmlentities($_POST['telfixe'],ENT_QUOTES);}else{$telfixe=null;}
		if(isset($_POST['telport'])){$info['telport']= htmlentities($_POST['telport'],ENT_QUOTES);}else{$telport=null;}
		if(isset($_POST['username'])){$info['username']=  htmlentities($_POST['username'],ENT_QUOTES);}
		if(isset($_POST['password'])){$info['pass'] =  htmlentities($_POST['password'],ENT_QUOTES);}//sha1($_POST['gu'.'password'])
		if(isset($_POST['password2'])){$info['pass2'] =  htmlentities($_POST['password2'],ENT_QUOTES);}//sha1($_POST['gu'.'password'])
		include('functions/function_inscription.php');
		$resultat=inscrire($db,$info);
		$urlsuivante="espace_perso.php";
		include ("functions/function_connexion.php");
		connexionCreate($db, $info['pass'],$info['username'], $urlsuivante);
		
	}


//fonction de protection des espaces membres
	include("functions/function_protection.php");	
	membre2($db);
//HTML head
	$titrepage="Espace perso";
	include('head.php');
?>
<body>

<div id="container">
<!--Menu gauche + logo + Menu top droite + message connection-->	
<?php include("menu.php");?>
	
<!--Diaporama-->	
	<div id="diaporama">
		<img src="images/micronauts.png" width="700" height="193"   alt="micronauts" />
	</div>

<!--espace perso-->	
	<div id="perso">
		
			
<?php
	$query = 'SELECT * FROM site_user LEFT OUTER JOIN commentaire ON site_user.id_user=commentaire.id_user LEFT OUTER JOIN article ON commentaire.id_art=article.id_art WHERE site_user.id_user =?';
	$prep = $db ->prepare($query);
	$prep -> bindValue(1, $_SESSION['id_user'], PDO::PARAM_INT);
	$prep -> execute();
		while ($donnees = $prep -> fetch()){	
			if (!isset($Vdoublon)){echo '<div id="titre">';
				if(isset($resultat)){echo $resultat;}
				echo'<h1>Bonjour '.$donnees['nom'].' '.$donnees['prenom'];echo '</h1></div><div id="contenu"><h2>Mes commentaires</h2>';}
			
			
				if(isset($donnees['commentaire'])){
					echo '<h4>Sur '.$donnees['titre'].' de '.$donnees['auteur'].', le '.$donnees['date_com'].'</h4>';
					echo '<p>'.$donnees['commentaire'].'</p>';
					}
				elseif(!isset($Vdoublon))
					{echo '<em>Vous n\'avez pas encore laissé de commentaire ni d\'avis.</em>';}
			$Vdoublon=true;	
			}
	$prep ->closeCursor();
?>		
			
			<h2>Mes commandes</h2>
<?php
			$query='SELECT * FROM ligne_cde NATURAL JOIN site_user NATURAL JOIN categorie2 JOIN article ON ligne_cde.id_art = article.id_art NATURAL JOIN facture ORDER BY facture.date_facture WHERE id_user =? ORDER BY order_id';
			$prep= $db -> prepare($query);
			$prep -> bindValue(1,$_SESSION['id_user'], PDO::PARAM_INT);
			$prep-> execute();
				if($prep -> rowCount() === 1) {
					while($donnees = $prep -> fetch()){
						if($donnees['order_id'] !== $V_orderid){
							echo '<tr><td COLSPAN =7>Commande n° '.$donnees['order_id'].'</td></tr>';
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
					}
				else
					echo '<em>Vous n\'avez pas encore passé de commande.</em>';
		echo '</div>	
		
	
	</div></div>';
	
	?>
<?php	
//<!--div footer-->
include("footer.php");?>
