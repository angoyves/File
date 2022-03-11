<?php
//***********************************************************************************************************************************
//Module de mail  - cwd_mailer - [mod_cwd_mailer]
//***********************************************************************************************************************************
class cwd_mailer{
	var $dest = "infos@cawad.com";
	var $sender = "almbert@solution-technology.net";
	var $content = "message d'un visiteur";
	var $title = "Titre du message visiteur";
	
	function cwd_mailer($dest, $title, $content, $sender){
		$content = nl2br($content);
		mail($dest, $title, $content, $sender);
	}
	
	//Interfaces
	function create_form($caption){
		$valRet = "";
		$valRet .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td>$this->caption</td></tr><td>";
		$valRet .= "<form name=\"frmPoll\" method=\"post\" action=\"../poll/sondage_xecute.php\">";
		$valRet .= "$lbl1<input type = \"text\" name = \"Titre de votre message \" value=\"0\" />";
		$valRet .= "$lbl2<input type = \"text\" name = \"Votre Email\" value=\"1\" /> $position";
		$valRet .= "$lbl3<input type = \"text\" name = \"T&eacute;l&eacute;phone\" value=\"2\" /> $position";
		$valRet .= "<$lbl4input type = \"text\" name = \"Pr&eacute;nom et Nom\" value=\"3\" /> $position $position";
		$valRet .= "<input type = \"submit\" name = \"btnSend\" value=\"$btnLabel\" />";
		$valRet .= "</form>";
		$valRet	.= "</td></tr></table>";
		return $valRet;
	}
	
}
//***** Fin Création RSS *********************************************************************************************************************










//***********************************************************************************************************************************
//Module de xxx  - YYY - [mod_cwd_yyy]
//***********************************************************************************************************************************

//***** Fin xxx *********************************************************************************************************************


?>