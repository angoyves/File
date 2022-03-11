<?php
/**************************
*  Contrôle des sessions  *
***************************/
$sess_login = $_session['sess_login'];
$sess_password = $_session['sess_password']; 
$sess_level_id = $_session['sess_level_id']; 
function session_checker(){
	//$var = $session_login;
	print "<link rel=\"stylesheet\" href=\"../../srcfiles/css/st.css\" type=\"text/css\">";
	if(!session_is_registered("sess_login")){
		print "<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><table align=\"center\" width=\"400\" class=\"nugget\"><tr><td><link rel= stylesheet href=\"../../../srcfiles/css/wublog1.css\">"; // || (!session_is_registered("SID")));
		print "<br><center><a href = '../../login.php'>Vous devez vous connecter pour avoir acc&egrave;s &agrave; cette page<br>\n";
		print "<br><img src=\"../..images/img/dzine/ico/login.gif\" border=\"0\" /><br />cliquez-ici pour vous connecter</a></center></td></tr></table>";
		exit();
	}
	else{
		global $logout;
		$logout = "<a title=\"D&eacute;connexion\" class=\"nochanges_xy\" href = \"../../fr_logout.php\"><img alt=\"D&eacute;connexion\" src=\"../..images/img/dzine/ico/logout.gif\" align=\"left\" hspace=\"3\" border=\"0\" />Logout</a>";
		return true;
	}
}
// ************* Fin contrôle des sessions *******************	
/*  Couleurs de background du menu utilisateurs */
$colOut = "#e9e9e9";
$colOn = "#ffffff";
?>