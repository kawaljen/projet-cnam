<?php
//ajout  message dans la bd

	function ajout_avis($db, $avis, $article) {
		//if(interdit($avis))
			//{	
				$article=htmlentities($article, ENT_QUOTES);
				$query = 'INSERT INTO commentaire (id_user, id_art, commentaire) VALUES (:id_user, :id_art, :commentaire)';
				$prep = $db -> prepare($query);
				$prep -> bindValue('id_user', $_SESSION['id_user'], PDO::PARAM_INT);
				$prep -> bindValue('id_art', $article, PDO::PARAM_INT);
				$prep -> bindValue('commentaire', $avis, PDO::PARAM_STR);
				$prep -> execute();
				$prep->closeCursor();
				$prep = NULL;;
			//}

	}
	// Verification que le message envoye ne contient pas de mots interdits
	// Mots interdits -> insultes et language sms
	// si le message ne contient pas de mots interdit 
	// 		retourne vrai
	// sinon
	//		retourne faux
	 function interdit($message) {//=NULL) {
	// Liste des 899 mots interdits dans l'espace membre
	// 		-> insultes
	// 		-> language SMS
	// Vous pouvez allonger cette liste en mettant ( | ) sans espace entre chaque mot interdit
		$motInterdit = "/\b(anus|baise|baisee|baisent|baiser|baises|bais�|bais�e|bais�es|bais�s|baiz|bande de t�ches|bander|barez-vous|barrez-vous-batard|batarde|batardes|batards|bite|bites|bitte|bittes|bondage|bondages|bonnasse|bonnasses|bordel|bordels|branle|branler|branles|branlette|branlettes|branl�|branl�s|b�tard|b�tarde|b�tardes|b�tards|b�z|c o n|c o*n|c o^n|c*o n|c*o*n|c*on|c^o n|c^o^n|caca|cacas|casse-toi|cassez-vous|chatte|chiasse|chie|chient|chier|chi�|chi�es|chi�s|clitau|clito|co n|co*n|cocu|cocus|con|con nard|con nards|conar|conard|conarde|conardes|conards|conasse|conasses|connar|connard|connarde|connardes|connards|connasse|connasses|conne|Connerie|Conneries|connes|cons|couille|couilles|couye|couyes|creve|cr�ve|cul|culs|cuni|cunilingus|de ta mer|de ta mere|de ta m�r|de ta m�re|debil|debile|debiles|d�bil|d�bile|d�biles|echangisme|emerde|emerdent|emerder|emerdeur|emerdeurs|emerdeuse|emerdeuses|emerd�|emerd�e|emerd�s|emmerde|emmerdent|emmerder|emmerdeur|emmerdeurs|emmerdeuse|emmerdeuses|emmerd�|emmerd�e|emmerd�s|en cul|en cule|en culer|en cules|encule|enculer|encules|encul�|encul�s|enfoir�|enfoir�e|enfoir�es|enfoir�s|et ta mere|et ta m�re|exta|f o ck|f o k|F U C K|f u ck|f.uck|f_u_c_k|faire mettre|fcuk|fcvk|fela tion|felation|fella tion|fellation|fI_Ick|fl_lck|fo ck|foc k|fock|foutoir|foutoire|foutre|foutrement|fu c k|fu ck|fu.ck|fuc|fuc.k|FUCK|fuk|fuque|fuuck|fuuuck|fuuuuck|fuuuuuck|fvck|f�la tion|f�la tions|f�lation|f�lations|gouine|gouines|gouinne|gouinnes|groniasse|groniasses|k o n|k o*n|k o^n|k o_n|k*o n|k*o*n|k*on|k^o n|k^o^n|k_o n|k_o_n|ko n|ko*n|kon|konasse|konasses|konnasse|konnasses|kons|Lesbien|Lesbiene|Lesbienes|lesbienne|Lesbiens|Lesbo|Lesbos|maso|masturbator|masturbe|masturber|masturb�|masturb�e|masturb�es|masturb�s|meeerdes|meeerdeux|meerdes|meerdeux|merdes|merdeux|morveuse|morveuses|morveux|nasi|nasis|nazi|nazis|negre|negres|negrillon|negrillons|negro|negros|nibard|nibards|nichon|nichons|nik|nike|nique|niquer|niqu�|niqu�e|niqu�es|niqu�s|negre|negres|negro|negros|negresse|n�gresse|n�gre|n�gres|n�grillon|n�grillons|n�gro|n�gros|ordure|ordures|p u t a i n|p u t a i n s|partouse|partouses|partouze|partouzes|pd|pdd|pddd|pdddd|pddddd|pdddddd|pddddddd|pds|pedale|pedales|pede|pederaste|pederastes|pedes|penis|pennis|petasse|petasses|phuck|pignouf|pignoufette|pi|noufettes|pignoufs|pisse|pissee|pissees|pisser|pisses|piss�|piss�e|piss�es|piss�s|plouc|ploucs|plouk|plouks|porno|pornos|pouffiass|pouffiasse|pouffiasses|poufiasse|pouf�fiass|pouf�fiasse|pouf�fiasses|Prostitue|Prostituee|Prostituees|Prostitues|Prostitu�|Prostitu�e|Prostitu�es|Prostitu�s|prout|put|put ain|put ains|put in|put ins|put1|putain|putains|pute|putes|putin|putins|putte|puttes|puttin|puttins|p�dale|p�dales|p�d�|p�d�raste|p�d�rastes|p�d�s|p�n�tration|p�tasse|p�tasses|s e x|s e x e|s e x*e|s e xe|s e*x|s ex|s ex e|s ex*e|s exe|sado|salau|salaud|salauds|salaus|salaut|salauts|sale arabe|sallo|sallop|sallopard|sallopards|sallope|sallopes|salloppard|salloppards|salloppe|salloppes|sallos|sallot|sallots|salo|salop|salopard|salopards|salope|salopes|saloppard|saloppards|saloppe|saloppes|salos|salot|salots|se x|se*x|sex|sex e|sex*e|sexe|shit|skinhead|sodomie|sodomise|sodomisee|sodomisees|sodomisent|sodomiser|sodomises|sodomis�|sodomis�e|sodomis�es|sodomis�s|sperm|sperme|spermes|suce|suck|tete de noeud|tetes de noeud|t�te de noeud|t�tes de noeud|va te faire|va te fer|va te fere|va te f�r|va te f�re|vagin|vagins|zizi|zizis|1e|1st|1dispo|1posibl|1dif�ren|1trec|1ternet|1vit|1mn|2min|2ri1|2l8|2labal|2m1|2mand|2van|2vanc|4me|5pa|6gar|6garet|6n�|6nema|6T|7adir|7ad|10ko|ab1to|akro|a2m1|af'r|afr|aJ|aG|�D|al�|AR|aPero|a+|apr�|apr�|aprem|apr�-mi10|apr�-mi10|areT|ariv|a12c4|asap|avan|avanC|ay�|abiT|azar|aniv|aK|aps|avc|avk|azar|AL1DI|ard|admin|ADMIN|ATK|arf|balaD|bavar|bavarD|bi1|bi1sur|bi1to|bizz|bap|bsr|boC|bl�m|B|b1|bc|Bdo|BG|bj|bocou|bogos|bye|c�|cad|c b1|c sa|c cho|c 2 labal|c mal1|CT|chanG|capou|chuis|chanm�|CriE|C|cam�|cam|came|Cdla|celib|celibatR|chi1|Clib|cok1|cokin|cokine|cok1e|colR|comen|dico|cc|colok|cond�|dak|danC|ds|D6D|DpenC|d�|dS100|DzSPr�|Dzol�|dsl|DtST|diskuT|douT|d1gue|daron|D|daronne|darone|deuspi|dico|die|DEF|�couT|empr1T|enfR|en+|�paT|�xagR|exClen|exQz�|exiG|�ziT|Er|E|enkor|entouK|entouka|epaT|ErE|ErEze|fRfet|fiR|meuf|fliP|franc�|FR|frR|fr8|foto|FM|FMloJ|F|fb|frero|foo|fliK�|flik|fone|fonetel|gan|Gen|Gnial|gr�|glnD|GraV|G la N|GPTl�plon|G|gova|gater6|gd|gde|Gnial|grav|gro|Gs�r�|GG|HT|H|hard|hl|IR|isTrik|ID|ImaJn|I|ie|irl|jalou|jam�|j'le sav|jen�mar|jSpR ktu va bi1|jtm|je t'M|j'tapLdkej'pe|jetel�Djadi|jT|jr|JuG|J|jaten|jme|jsai|jsui|jtem|jtaim|Kdo|keum|Kfar|Kf�|Kl1|Knon|Kc|klR|koQ|kEr|komanD|Kom|komencava|koncR|kontST|kruL|karaT|ke|kL|kLq1|kelkun|keske|keske C|kekina|kestion|ki|kil|koi|koa|kwa|koi29|K|KS|kisd�|kif|jtkif|k7|kan|Ksos|LcKc|lol|l1di|lakL|lekL|l8|lH|l'S tomB|LC|L|LVL|ll|mek|magaz1|m1tNan|mnt|m�|kaze|malad|mal1|manG|mat1|max|mm|m�naG|mR|m�|msg|mne|m jvb|MDR|moy1|muscQ|muscu|muzik|muzic|M|m'man|MP|msg|ml|NRV|n�CsR|nRvE|nc|no|nb|nombrE|nouvL|nouvo|NRJ|N|news|ns|ok1|oQne|Ojourd8|ojourd'8|ouf|orEr|otL|OQP|�|oZ|ouvR|O|oci|oreur|ou1j|ouinj|OMG|partut|partt|paC|p�y�|pRturB|pE|piG|poa|po1|poz|pr|pk|prtan|prtant|preC|pb|P|p'pa|ptdr|POULAGA|PANAM|PANAME|poto|pr|ppr|pti|ptite|plon|qoa|qd|quiT|Q|QG|reuch|remps|rapl|ra|rejo1|rdv|r�pt|rstp|rep|resto|retard|r�u|r�ucir|ri1|rafr|ras|ru|r|reuf|savapa|sniiif|snif|slt|slt cav ?|savoar|semN|stp|sk8|seur|spor|strC|S|sked|SKEUD|tR|tarD|tps|T�|ti2|tle +bo|tpa f�ch�|TT|tabitou|2day|tjr|tt|tr1|trankil|taf|tafer|tu vi1 2m1 ?|T|Tci|tsss|ts|utiliz�|U|vazi|Vlo|vR|vi1|vs|VoyaG|vrMen|V|VIP|W|WE|W.E|wesh|WTF|w�|wi|wy|X|X-trem|Xtrem|xpldr|Xcit�|Xcit|xd|xplorer|xploz�|xploz|xplor|yo|y|�|ye|y�|ya|y�|Z|zN|ziva|zonm�)\b/ui";
		$message = str_replace("'", "", $message);
		if(!empty($message)) {
			if(preg_match($motInterdit, $message)) {
				return false;
			}
			else {
				return true;
			}
		}
		else {
			return true;
		}
	}
/*
	// nombre de nouveau message du membre connecte
	public static function nouveauNb($id) {
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.MESSAGE.NBNEW);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		if($resultat -> rowCount() === 0) {
			return 'Vous n\'avez aucun nouveau message';
		}
		else {
			return 'Vous avez '.$resultat -> rowCount().' nouveau(x) message(s).';
		}
	}
	// liste des messages du membre
	// liste a vide
	// recherche des messages adresses au membre connecte et non efface par le membre
	// Dans une boucle 
	// 		Si le message est deja lu 
	//			image lu
	// 		Sinon
	//			image non lu
	//      **********************
	// 		affichage du ou des messages
	// Fin de la boucle
	//      **********************
	// si la liste n'est pas vide 
	//		retourne la liste des messages
	// Sinon
	// 		retourne vous n'avez aucun message
	public static function liste($id) {
		$liste = '';
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.MESSAGE.MESSAGELISTE);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		while($donnee = $resultat -> fetch(PDO::FETCH_ASSOC)) {
			if($donnee['lu'] === '1') {
				$image = '<img src="'.URLSITE.'/design/image/Lu.png" width="24" height="24" align="absmiddle">';
			}
			else {
				$image = '<img src="'.URLSITE.'/design/image/Non_Lu.png" width="24" height="24" align="absmiddle">';
			}
			$liste .= '<tr>
			<td>'.$image.'</td>
			<td align="center">Le '.date('d/m/Y', $donnee['timestamp']).' &agrave; '.date('H:i:s', $donnee['timestamp']).'</td>
			<td align="center"><a href="profil_membre.php?id='.$donnee['id_expediteur'].'">'.Membre::info($donnee['id_expediteur'], 'pseudo').'</a></td>
			<td align="center"><a href="message.php?id='.$donnee['id'].'">'.$donnee['titre'].'</a></td>
			</tr>';
		}
		if(!empty($liste)) {
			return $liste;
		}
		else {
			return '<tr><td align="center" colspan="4">Vous n\'avez aucun message</td></tr>';
		}
	}
	// Affiche le message recut
	public static function info($id, $info) {
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.MESSAGE.ID);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		$donnee = $resultat -> fetch(PDO::FETCH_ASSOC);
		return $donnee[$info];
	}
	// message lu
	public static function lu($id) {
		$resultat = Bdd::connectBdd()->prepare(UPDATE.MESSAGEZ.LU.ID);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
	}
	// efface message
	public static function efface($id) {
		$resultat = Bdd::connectBdd()->prepare(UPDATE.MESSAGEZ.EFFACE.ID);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
	}
	// envoie d'un message
	// Si le destinataire et ok
	//		Si le titre est ok
	//			Si le message est ok
	//				Si le message et le titre ne contiennent pas des mots interdits
	//					Nettoyage du message et du titre
	//					Enregistrement dans la bdd
	//					retourne Vrai
	//				Sinon
	//					retourne une erreur
	//			Sinon
	//				retourne une erreur
	//		Sinon
	//			retourne une erreur
	// Sinon
	//  	retourne une erreur
	public static function messageEnvoi($id_exp, $destinataire, $titre, $message) {
		if(!empty($destinataire)) {
			if(!empty($titre)) {
				if(!empty($message)) {
					if(Message::interdit($message)) {
						$message = nl2br(filter_var($message, FILTER_SANITIZE_STRING));
						$titre = filter_var($titre, FILTER_SANITIZE_STRING);
						$date = time();
						$resultat = Bdd::connectBdd()->prepare(INSERT.MESSAGEZ.MESSAGEINSERT);
						$resultat -> bindParam(':id_exp', $id_exp, PDO::PARAM_INT, 11);
						$resultat -> bindParam(':id_dest', $destinataire, PDO::PARAM_INT, 11);
						$resultat -> bindParam(':titre', $titre);
						$resultat -> bindParam(':date', $date);
						$resultat -> bindParam(':message', $message);
						$resultat -> execute();
						return 'Votre message est envoy&eacute;';
					}
					else {
						return 'Votre message ou votre titre contient du language SMS ou des mots interdits, veuillez recommencer.<br />'.$message;
					}
				}
				else {
					return 'Vous devez saisir un message.';
				}
			}
			else {
				return 'Vous devez saisir un titre au message.';
			}
		}
		else {
			return 'Vous devez choisir un destinataire.';
		}
	}
	// Message a tous les membres
	public static function messageAll($titre, $message) {
		if(!empty($titre)) {
			if(!empty($message)) {
				$id = '2';
				$all = Bdd::connectBdd()->prepare(SELECT.ALL.MEMBRE.NOID);
				$all -> bindParam(':id', $id, PDO::PARAM_INT, 11);
				$all -> execute();
				$message = nl2br(filter_var($message, FILTER_SANITIZE_STRING));
				$titre = filter_var($titre, FILTER_SANITIZE_STRING);
				$date = time();
				$id_exp = '2';
				while($tous = $all -> fetch(PDO::FETCH_ASSOC)) {
					$destinataire = $tous['id'];
					$resultat = Bdd::connectBdd()->prepare(INSERT.MESSAGEZ.MESSAGEINSERT);
					$resultat -> bindParam(':id_exp', $id_exp, PDO::PARAM_INT, 11);
					$resultat -> bindParam(':id_dest', $destinataire, PDO::PARAM_INT, 11);
					$resultat -> bindParam(':titre', $titre);
					$resultat -> bindParam(':date', $date);
					$resultat -> bindParam(':message', $message);
					$resultat -> execute();
				}
				return 'Votre message est envoy&eacute;';
			}
			else {
				return 'Vous devez saisir un message.';
			}
		}
		else {
			return 'Vous devez saisir un titre au message.';
		}
	}
	// liste des messages envoyes
	public static function listeEnvoi($id) {
		$liste = '';
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.MESSAGE.IDEXP);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		while($donnee = $resultat -> fetch(PDO::FETCH_ASSOC)) {
			if($donnee['lu']==1) {
				$image = '<img src="'.URLSITE.'/design/image/Lu.png" width="24" height="24" align="absmiddle">';
			}
			else {
				$image = '<img src="'.URLSITE.'/design/image/Non_Lu.png" width="24" height="24" align="absmiddle">';
			}
			if($donnee['effacer']==1) {
				$image = '<img src="'.URLSITE.'/design/image/faux.png" width="24" height="24" align="absmiddle">';
			}
			$liste .= '<tr>
					<td>'.$image.'</td>
					<td align="center">Le '.date('d/m/Y', $donnee['timestamp']).' &agrave; '.date('H:i:s', $donnee['timestamp']).'</td>
					<td align="center"><a href="profil_membre.php?id='.$donnee['id_destinataire'].'">'.Membre::info($donnee['id_destinataire'], 'pseudo').'</a></td>
					<td align="center">'.$donnee['titre'].'</td>
				</tr>';
		}
		if(!empty($liste)) {
			return $liste;
		}
		else {
			return '<tr><td align="center" colspan="4">Vous n\'avez pas envoy&eacute; de message</td></tr>';
		}
	}
	// liste des destinataires possible pour nouveau message
	public static function choixDestinataire($id) {
		$liste = '';
		$resultat = Bdd::connectBdd()->prepare(SELECT.ALL.MEMBRE.NOID);
		$resultat -> bindParam(':id', $id, PDO::PARAM_INT, 11);
		$resultat -> execute();
		while($donnee = $resultat -> fetch(PDO::FETCH_ASSOC)) {
			$liste .= '<option value="'.$donnee['id'].'">'.$donnee['pseudo'].'</option>';
		}
		return $liste;
	}
	
} // Fin de la classe message*/
?>