<?php
include('connectbd.php');
$query ='SELECT * FROM article NATURAL JOIN categorie2 WHERE id_art = ? AND id_categ2= ?';		
$prep = $db->prepare($query);
$prep->bindValue(1, $_GET['id_art'], PDO::PARAM_INT);
$prep->bindValue(2, $_GET['valeur2'], PDO::PARAM_INT);
$prep->execute();
$donnees = $prep->fetch();
echo $donnees['prix']

 ?>
