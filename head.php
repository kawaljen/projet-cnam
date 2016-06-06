<?php 
//enregistre la racine du site dans une variable de session
if(!isset($_SESSION['baseurl']))$_SESSION['baseurl']='http://déclics.eu/projet/';
?>
<!DOCTYPE HTML PUBLIC   "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<title><?php echo $titrepage;?></title>
	<link rel="stylesheet" href="<?php echo $_SESSION['baseurl'];?>css/template.css" type="text/css"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<?php if(isset($js))
		echo '<script language="Javascript" SRC="'.$_SESSION['baseurl'].'tools/functions.js"> </script>';?>
</head>
