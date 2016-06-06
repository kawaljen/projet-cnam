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
		$motInterdit = "/\b(anus|baise|baisee|baisent|baiser|baises|baisé|baisée|baisées|baisés|baiz|bande de tâches|bander|barez-vous|barrez-vous-batard|batarde|batardes|batards|bite|bites|bitte|bittes|bondage|bondages|bonnasse|bonnasses|bordel|bordels|branle|branler|branles|branlette|branlettes|branlé|branlés|bâtard|bâtarde|bâtardes|bâtards|bèz|c o n|c o*n|c o^n|c*o n|c*o*n|c*on|c^o n|c^o^n|caca|cacas|casse-toi|cassez-vous|chatte|chiasse|chie|chient|chier|chié|chiées|chiés|clitau|clito|co n|co*n|cocu|cocus|con|con nard|con nards|conar|conard|conarde|conardes|conards|conasse|conasses|connar|connard|connarde|connardes|connards|connasse|connasses|conne|Connerie|Conneries|connes|cons|couille|couilles|couye|couyes|creve|crève|cul|culs|cuni|cunilingus|de ta mer|de ta mere|de ta mèr|de ta mère|debil|debile|debiles|débil|débile|débiles|echangisme|emerde|emerdent|emerder|emerdeur|emerdeurs|emerdeuse|emerdeuses|emerdé|emerdée|emerdés|emmerde|emmerdent|emmerder|emmerdeur|emmerdeurs|emmerdeuse|emmerdeuses|emmerdé|emmerdée|emmerdés|en cul|en cule|en culer|en cules|encule|enculer|encules|enculé|enculés|enfoiré|enfoirée|enfoirées|enfoirés|et ta mere|et ta mère|exta|f o ck|f o k|F U C K|f u ck|f.uck|f_u_c_k|faire mettre|fcuk|fcvk|fela tion|felation|fella tion|fellation|fI_Ick|fl_lck|fo ck|foc k|fock|foutoir|foutoire|foutre|foutrement|fu c k|fu ck|fu.ck|fuc|fuc.k|FUCK|fuk|fuque|fuuck|fuuuck|fuuuuck|fuuuuuck|fvck|féla tion|féla tions|félation|félations|gouine|gouines|gouinne|gouinnes|groniasse|groniasses|k o n|k o*n|k o^n|k o_n|k*o n|k*o*n|k*on|k^o n|k^o^n|k_o n|k_o_n|ko n|ko*n|kon|konasse|konasses|konnasse|konnasses|kons|Lesbien|Lesbiene|Lesbienes|lesbienne|Lesbiens|Lesbo|Lesbos|maso|masturbator|masturbe|masturber|masturbé|masturbée|masturbées|masturbés|meeerdes|meeerdeux|meerdes|meerdeux|merdes|merdeux|morveuse|morveuses|morveux|nasi|nasis|nazi|nazis|negre|negres|negrillon|negrillons|negro|negros|nibard|nibards|nichon|nichons|nik|nike|nique|niquer|niqué|niquée|niquées|niqués|negre|negres|negro|negros|negresse|négresse|nègre|nègres|négrillon|négrillons|négro|négros|ordure|ordures|p u t a i n|p u t a i n s|partouse|partouses|partouze|partouzes|pd|pdd|pddd|pdddd|pddddd|pdddddd|pddddddd|pds|pedale|pedales|pede|pederaste|pederastes|pedes|penis|pennis|petasse|petasses|phuck|pignouf|pignoufette|pi|noufettes|pignoufs|pisse|pissee|pissees|pisser|pisses|pissé|pissée|pissées|pissés|plouc|ploucs|plouk|plouks|porno|pornos|pouffiass|pouffiasse|pouffiasses|poufiasse|pouf­fiass|pouf­fiasse|pouf­fiasses|Prostitue|Prostituee|Prostituees|Prostitues|Prostitué|Prostituée|Prostituées|Prostitués|prout|put|put ain|put ains|put in|put ins|put1|putain|putains|pute|putes|putin|putins|putte|puttes|puttin|puttins|pédale|pédales|pédé|pédéraste|pédérastes|pédés|pénétration|pétasse|pétasses|s e x|s e x e|s e x*e|s e xe|s e*x|s ex|s ex e|s ex*e|s exe|sado|salau|salaud|salauds|salaus|salaut|salauts|sale arabe|sallo|sallop|sallopard|sallopards|sallope|sallopes|salloppard|salloppards|salloppe|salloppes|sallos|sallot|sallots|salo|salop|salopard|salopards|salope|salopes|saloppard|saloppards|saloppe|saloppes|salos|salot|salots|se x|se*x|sex|sex e|sex*e|sexe|shit|skinhead|sodomie|sodomise|sodomisee|sodomisees|sodomisent|sodomiser|sodomises|sodomisé|sodomisée|sodomisées|sodomisés|sperm|sperme|spermes|suce|suck|tete de noeud|tetes de noeud|tête de noeud|têtes de noeud|va te faire|va te fer|va te fere|va te fèr|va te fère|vagin|vagins|zizi|zizis|1e|1st|1dispo|1posibl|1diféren|1trec|1ternet|1vit|1mn|2min|2ri1|2l8|2labal|2m1|2mand|2van|2vanc|4me|5pa|6gar|6garet|6né|6nema|6T|7adir|7ad|10ko|ab1to|akro|a2m1|af'r|afr|aJ|aG|éD|alé|AR|aPero|a+|apré|aprè|aprem|aprè-mi10|apré-mi10|areT|ariv|a12c4|asap|avan|avanC|ayé|abiT|azar|aniv|aK|aps|avc|avk|azar|AL1DI|ard|admin|ADMIN|ATK|arf|balaD|bavar|bavarD|bi1|bi1sur|bi1to|bizz|bap|bsr|boC|blèm|B|b1|bc|Bdo|BG|bj|bocou|bogos|bye|cé|cad|c b1|c sa|c cho|c 2 labal|c mal1|CT|chanG|capou|chuis|chanmé|CriE|C|camé|cam|came|Cdla|celib|celibatR|chi1|Clib|cok1|cokin|cokine|cok1e|colR|comen|dico|cc|colok|condé|dak|danC|ds|D6D|DpenC|dê|dS100|DzSPré|Dzolé|dsl|DtST|diskuT|douT|d1gue|daron|D|daronne|darone|deuspi|dico|die|DEF|écouT|empr1T|enfR|en+|épaT|éxagR|exClen|exQzé|exiG|éziT|Er|E|enkor|entouK|entouka|epaT|ErE|ErEze|fRfet|fiR|meuf|fliP|francè|FR|frR|fr8|foto|FM|FMloJ|F|fb|frero|foo|fliKé|flik|fone|fonetel|gan|Gen|Gnial|gré|glnD|GraV|G la N|GPTléplon|G|gova|gater6|gd|gde|Gnial|grav|gro|Gséré|GG|HT|H|hard|hl|IR|isTrik|ID|ImaJn|I|ie|irl|jalou|jamé|j'le sav|jenémar|jSpR ktu va bi1|jtm|je t'M|j'tapLdkej'pe|jeteléDjadi|jT|jr|JuG|J|jaten|jme|jsai|jsui|jtem|jtaim|Kdo|keum|Kfar|Kfé|Kl1|Knon|Kc|klR|koQ|kEr|komanD|Kom|komencava|koncR|kontST|kruL|karaT|ke|kL|kLq1|kelkun|keske|keske C|kekina|kestion|ki|kil|koi|koa|kwa|koi29|K|KS|kisdé|kif|jtkif|k7|kan|Ksos|LcKc|lol|l1di|lakL|lekL|l8|lH|l'S tomB|LC|L|LVL|ll|mek|magaz1|m1tNan|mnt|mè|kaze|malad|mal1|manG|mat1|max|mm|ménaG|mR|mê|msg|mne|m jvb|MDR|moy1|muscQ|muscu|muzik|muzic|M|m'man|MP|msg|ml|NRV|néCsR|nRvE|nc|no|nb|nombrE|nouvL|nouvo|NRJ|N|news|ns|ok1|oQne|Ojourd8|ojourd'8|ouf|orEr|otL|OQP|Ô|oZ|ouvR|O|oci|oreur|ou1j|ouinj|OMG|partut|partt|paC|péyé|pRturB|pE|piG|poa|po1|poz|pr|pk|prtan|prtant|preC|pb|P|p'pa|ptdr|POULAGA|PANAM|PANAME|poto|pr|ppr|pti|ptite|plon|qoa|qd|quiT|Q|QG|reuch|remps|rapl|ra|rejo1|rdv|répt|rstp|rep|resto|retard|réu|réucir|ri1|rafr|ras|ru|r|reuf|savapa|sniiif|snif|slt|slt cav ?|savoar|semN|stp|sk8|seur|spor|strC|S|sked|SKEUD|tR|tarD|tps|Tê|ti2|tle +bo|tpa fâché|TT|tabitou|2day|tjr|tt|tr1|trankil|taf|tafer|tu vi1 2m1 ?|T|Tci|tsss|ts|utilizé|U|vazi|Vlo|vR|vi1|vs|VoyaG|vrMen|V|VIP|W|WE|W.E|wesh|WTF|wé|wi|wy|X|X-trem|Xtrem|xpldr|Xcité|Xcit|xd|xplorer|xplozé|xploz|xplor|yo|y|é|ye|yè|ya|yâ|Z|zN|ziva|zonmé)\b/ui";
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