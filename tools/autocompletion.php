<?php
include('connectbd.php');
echo '<form method="get" action="catalogue_detail.php">
	<select id="opt_autocomp" name="detail"  STYLE="width:150">';
			
$query='SELECT * FROM article WHERE titre LIKE ?';// OR auteur LIKE ?';
$prep2 = $db ->prepare($query);
$prep2->bindValue(1, "%".$_GET['valeur']."%", PDO::PARAM_STR);
//$prep->bindValue(2, "%".$_GET['valeur']."%", PDO::PARAM_STR);
$prep2 -> execute();
if ($prep2 ->rowCount()>0) {
	while ($donnees = $prep2 ->fetch()) {
		echo'<option value="'.$donnees['id_art'].'" >'.$donnees['titre'].'</option>';
		$test=true;
		}
	}

	$prep2 -> closeCursor();
	$query='SELECT * FROM article WHERE auteur LIKE ?';
	$prep2 = $db ->prepare($query);
	$prep2->bindValue(1, "%".$_GET['valeur']."%", PDO::PARAM_STR);
	$prep2 -> execute();
	if ($prep2 ->rowCount()>0) {
		while($donnees = $prep2 ->fetch()){
			echo'<option value="'.$donnees['id_art'].'" >'.$donnees['auteur'].'</option>';
			$test=true;
			}
	
	
}
echo 	'</select>';
if(isset($test)){echo '<input type="submit" value="detail"/>';}
echo '</form>';

 ?>
