<?php
session_start();
include ("functions/function.php");
//HTML head
	$titrepage="Accueil";
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
<!--colone1 = contenu-->	
	<div id="colonne1">
		<h1>Historique</h1>
		<div id="introduction">Depuis notre naissance, Popup Ed édite livres et projets d'auteurs débutants ou confirmés.</div>
		<div><p>En aout 2005, debute l'aventure au Festival du livre avec la rencontre avec <a href="#">Ed</a> et <a href="#">Paul</a>. Notre passion pour la musique et le graphisme nous rassemble et nous créons le fanzine <em>Tchop-Tchop Magazine</em>. Puis nous sommes rejoints par <a href="#">AL</a> (Anna-Laurene Johns) et <strong>Olivier Piponneau</strong> et publions <em>Tchoptchop mix</em>, premier numéro d’une revue qui connue une reconnaissance croissante. Nous sortirons finalement 6 numéros durant la première année.</p>
			<p><img src="images/couvmix.jpg" border="0" alt="" title="TchopTchop mix" /></p>
			<p>En 2006, nous commençons à éditer nos premiers livres tout en continuant la publication du <em>mix</em></p>
			<p>Si nous étions spécialisé dans l'edition musicale, nous étendrons durant les années qui suivent à la science fiction, et ouvriront notre champ à des auteurs indépendants classables ou inclassables.</p>
			<p><img src="images/festival07.jpg" border="0" alt="" title="Popup Ed 2007" /></p>
			<p>Nous avons participé à plusieurs festivals.</p>
		</div>
	</div>
<!--colone2 = info2-->	
	<div id="colonne2" >
		<h2 class="fleche1">Presse</h2>
		<p>Vous pouvez télécharger notre <a href="#" target="_blank">dossier de presse</a> et visualiser les articles déjà parus.</p>
		
		<h2 class="fleche2">L'Equipe</h2>
		<p><strong>le comité éditorial</strong><br />Claire Baltour<br />Thomas Beaumont</p>
		<p><strong>le bureau</strong><br /> Cécile Pauline, présidente<br /> Thomas Beaumont, vice-président<br /> Sylvester Latour, trésorier</p>

		<h2 class="fleche2">Adhésion</h2>
		<p>L'adhésion peut se faire au siège de l'asso ou par mail.</p>
	</div>
	
	
	
	
	
	
<!--div footer-->
 <?php include('footer.php');
