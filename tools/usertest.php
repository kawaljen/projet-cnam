<?php
/*include("connectbd.php");
$query='SELECT username FROM site_user WHERE username = ?';
$prep = $db ->prepare($query);
$prep->bindValue(1, $_GET['login'], PDO::PARAM_STR);
$prep -> execute();
if($prep ->rowCount() > 1){
 echo 1 //le login est déjà utilisé
 exit;
 }
else { echo 0; }//le login est utilisé*/


echo 1;
 ?>