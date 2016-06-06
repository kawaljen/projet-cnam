<?php

function ajoutpanierGeneral($detail){
	if(!isset($_SESSION['panier'])){$_SESSION['panier']=array();}
	if(array_search($_POST['detail'], $_SESSION['panier'])===false)	{
		$_SESSION['panier'][]=$detail;
		}
		
}
function supprimerArticle($libelleProduit){
     // Nous allons passer par un panier temporaire
      $tmp=array();
      for($i = 0; $i < count($_SESSION['panier']); $i++) {
         if ($_SESSION['panier'][$i] !== $libelleProduit)
            $tmp[]=$_SESSION['panier'][$i];
      }
      //On remplace le panier en session par notre panier temporaire à jour
		$_SESSION['panier']=$tmp;
      //On efface notre panier temporaire
      unset($tmp);
}


?>

