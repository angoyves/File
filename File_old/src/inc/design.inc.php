<?php
/* S C R I P T S    I N H E R E N T S    AUX    D E S I G N    ( G R A P H I Q U E )    E T    I N T E R F A C A G E */
/*Date de création : 29 Octobre 2005 à 02h45min Yaoundé*/

/*[:: menu de gauche]*/
function left_side_mnu($sub, $subtitle){
	//Affiche les menus gauches contextuels
	return $mnu = "<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"4\">
			<tr>
			  <td colspan=\"2\">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=\"2\" class=\"title\">$subtitle</td>
			</tr>
			<tr>
			  <td width=\"14%\">&nbsp;</td>
			  <td width=\"86%\" class=\"leftSide\"><a href=\"$sub".".php"."\" class=\"leftSide\">Sommaire</a></td>
			</tr>
			<tr>
			  <td width=\"14%\">&nbsp;</td>
			  <td width=\"86%\" class=\"leftSide\"><a href=\"$sub"."_nouveau.php"."\" class=\"leftSide\">Nouveau</a></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><a href=\"$sub"."_afficher.php"."\" class=\"leftSide\">Afficher</a></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><a href=\"$sub"."_maj.php"."\" class=\"leftSide\">Mettre &agrave; jour </a></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><a href=\"$sub"."_rechercher.php"."\" class=\"leftSide\">Rechercher</a></td>
			</tr>
		  </table>";
	/*Ex: print left_side_mnu("texte", "Texte r&agrave;glementaire");  **** Nous affiche le sous-menu contextuel correspondant à 'texte règlementaire'*/
}
	
?>