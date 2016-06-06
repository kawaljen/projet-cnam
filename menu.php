<!--Menu gauche + logo-->
	 <nav id="gauche">
        <a href="<?php echo $_SESSION['baseurl'];?>index.php" id="logo"><img src="<?php echo $_SESSION['baseurl'];?>images/logo.png" width="171" height="162"   alt="popup edition" /></a>
        
		<div id="nav">
			<ul>
				<li><a class="association" href="<?php echo $_SESSION['baseurl'];?>index.php" ><span><img src="<?php echo $_SESSION['baseurl'];?>images/association.png" alt="Association"/></span></a></li>
				<li><a class="auteurs" href="<?php echo $_SESSION['baseurl'];?>lesauteurs.php" ><span><img src="<?php echo $_SESSION['baseurl'];?>images/auteurs.png" alt="Auteurs"/></span></a></li>
				<li><a class="catalogue" href="<?php echo $_SESSION['baseurl'];?>catalogue.php" ><span><img src="<?php echo $_SESSION['baseurl'];?>images/catalogue.png" alt="Catalogue"/></span></a></li>
			</ul>
        </div>
	</nav>
<!--Menu top droite-->	
	<div id="haut">
			<div id="menutop">
				<ul>
					<li><a class="lk_esp_menb" href="<?php echo $_SESSION['baseurl'];?>espace_perso.php" ><span>Espace perso</span></a></li>
					<li><a class="lk_contact" href="<?php echo $_SESSION['baseurl'];?>lesauteurs.php" ><span>Contact</span></a></li>
					<li><a class="lk_facebook" href="#" target="_blank" ><span>Facebook</span></a></li>
				</ul>
			</div>
			<div id="panier"><a href="<?php echo $_SESSION['baseurl'];?>panier.php?action=ajout" target="_blank">
				<img src="<?php echo $_SESSION['baseurl'];?>images/panier_vide.png" width="75" height="50" alt="Panier" /></a>
			</div>
			<?php
				if(isset($_SESSION['username'])){
					echo '<div id="connecte"><p>Connecté(e) : '.$_SESSION['username'].'</p><a href="'.$_SESSION['baseurl'].'deconnexion.php"><img src="" alt="se deconnecter"/></a></div>';
					}

			?>
	 </div>

