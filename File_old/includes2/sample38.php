<?php 
	  require_once('Connections/MyFileConnect.php'); 
?>
<?php
	  require_once('includes/db.php');
	  require("src/inc/design.inc.php");
	  require("src/inc/biblio.inc.php");
	  require("src/inc/mysql_biblio.inc.php");
	  require("src/inc/db.php");
	  require('includes/MyFonction.php');
?>
<?php

if (isset($_REQUEST['mID']))
$txt_Month = $_REQUEST['mID'];

if (isset($_REQUEST['aID']))
$txt_Year = $_REQUEST['aID'];

if (isset($_REQUEST['comID']))
$commission_id = $_REQUEST['comID'];

if (isset($_REQUEST['lID']))
$localite_id = $_REQUEST['lID'];

//echo $commission_id.'  '. $txt_Month.'   '. $txt_Year;
$linkSession = "sample23.php?comID=".$commission_id."&menuID=4&action=new&lID=".$localite_id."&valid=mb";


if (isset($txt_Month) && $txt_Month != 0) {
$etat_validate = (MinmapDB::getInstance()->afficher_etat_valide($commission_id, $txt_Month, $txt_Year));
$etat_controlate = (MinmapDB::getInstance()->afficher_etat_control($commission_id, $txt_Month, $txt_Year));
} else {
$etat_validate = (MinmapDB::getInstance()->afficher_etat_valide($commission_id, $txt_Month, $txt_Year));
$etat_controlate = (MinmapDB::getInstance()->afficher_etat_control($commission_id, $txt_Month, $txt_Year));
}


$anneeIsEmpty = false;
$moisIsEmpty = false;
$showGoToPersonnes1 = "upd_rib.php?recordID=". $row_rsAffichePerson['personne_id'];

$link = "print_sessions.php?aID=" . $txt_Year . "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=4";
$linkage = "print_sessions.php?aID=" . $txt_Year . "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=4";
$link11 = "sample42.php?aID=" . $txt_Year . "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID'];
$link12 = "etat_financier_recap_pers.php?aID=" . $txt_Year . "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID'];
if (isset($txt_Month) && $txt_Month != 0) {
$link2 = "sample26.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'] . "&lID=" . $localite_id;
} else {
$link2 = "sample26.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'] . "&lID=" . $localite_id;
}
$link3 = "sample26.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&menuID=" . $_GET['menuID']. "&lID=" . $localite_id;
$link4 = "sample26.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'];
$link5 = "delete_sessions.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID']."&pID=";
$link6 = "valid_representant.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'];
$link7 = "search_sessions.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'];
$link8 = "del_membre.php";
$link9 = "add_membre.php";
$link10 = "sample23.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'];
$link13 = "print_sessions.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=1";
$link14 = "print_sessions.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=3";
$link15 = "sample34.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=4";
$link16 = "sample36.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&menuID=" . $_GET['menuID']. "&lID=" . $localite_id;
$link17 = "sample42.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID'];
$link18 = "sample44.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID'];
$link19 = "sample54.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id. "&menuID=" . $_GET['menuID']."&tab=4";
if (isset($txt_Month) && $txt_Month != 0) {
$link20 = "sample63.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'] . "&pID=" . $_GET['menuID'];
} else {
$link20 = "sample63.php?aID=" . $txt_Year. "&mID=" . $txt_Month . "&comID=" . $commission_id . "&menuID=" . $_GET['menuID'] . "&pID=" . $_GET['menuID'];
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsMois = "SELECT * FROM mois ORDER BY mois_id ASC";
$rsMois = mysql_query($query_rsMois, $MyFileConnect) or die(mysql_error());
$row_rsMois = mysql_fetch_assoc($rsMois);
$totalRows_rsMois = mysql_num_rows($rsMois);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsSelYear = "SELECT * FROM annee ORDER BY lib_annee";
$rsSelYear = mysql_query($query_rsSelYear, $MyFileConnect) or die(mysql_error());
$row_rsSelYear = mysql_fetch_assoc($rsSelYear);
$totalRows_rsSelYear = mysql_num_rows($rsSelYear);


mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($txt_Month) && $txt_Month != 0 ){
$query_rsJourMois = sprintf("SELECT * FROM mois WHERE mois_id = %s", GetSQLValueString($txt_Month, "text"));
} else {
$query_rsJourMois = sprintf("SELECT * FROM mois WHERE mois_id = %s", GetSQLValueString($txt_Month, "text"));
}
$rsJourMois = mysql_query($query_rsJourMois, $MyFileConnect) or die(mysql_error());
$row_rsJourMois = mysql_fetch_assoc($rsJourMois);
$totalRows_rsJourMois = mysql_num_rows($rsJourMois);


mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsCommissions = sprintf("SELECT commission_id, commission_lib, lib_nature, type_commission_lib, localite_lib FROM commissions, natures, type_commissions, localites WHERE commissions.nature_id = natures.nature_id    AND commissions.type_commission_id = type_commissions.type_commission_id   AND commissions.localite_id = localites.localite_id   AND commission_id = %s ORDER BY localite_lib ASC ", GetSQLValueString($commission_id, "int"));
$rsCommissions = mysql_query($query_rsCommissions, $MyFileConnect) or die(mysql_error());
$row_rsCommissions = mysql_fetch_assoc($rsCommissions);
$totalRows_rsCommissions = mysql_num_rows($rsCommissions);


mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($txt_Year) && $txt_Year != 0 ){
$query_rsSousCommission = sprintf("SELECT distinct(commission_id), montant_cumul, nombre_offre FROM commissions, sessions WHERE sessions.membres_commissions_commission_id = commissions.commission_id  AND commission_parent = %s AND mois = %s AND annee = %s", GetSQLValueString($commission_id, "int"),GetSQLValueString($txt_Month, "int"),GetSQLValueString($txt_Year, "int"));
} else {
$query_rsSousCommission = sprintf("SELECT distinct(commission_id), montant_cumul, nombre_offre FROM commissions, sessions WHERE sessions.membres_commissions_commission_id = commissions.commission_id  AND commission_parent = %s AND mois = %s AND annee = %s", GetSQLValueString($commission_id, "int"),GetSQLValueString($txt_Month, "int"),GetSQLValueString($txt_Year, "int"));
}
$rsSousCommission = mysql_query($query_rsSousCommission, $MyFileConnect) or die(mysql_error());
$row_rsSousCommission = mysql_fetch_assoc($rsSousCommission);
$totalRows_rsSousCommission = mysql_num_rows($rsSousCommission);


mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($txt_Year) && $txt_Year != 0 ){
$query_rsSessions = sprintf("SELECT commission_id, personnes.personne_id, personne_nom, fonctions.fonction_id, fonction_lib, nombre_jour, jour, mois, annee, montant, (nombre_jour * montant) as total, sessions.user_id
FROM commissions, membres, personnes,  fonctions, sessions
WHERE membres.commissions_commission_id = commissions.commission_id
AND membres.personnes_personne_id = personnes.personne_id
AND membres.fonctions_fonction_id = fonctions.fonction_id
AND sessions.membres_commissions_commission_id = membres.commissions_commission_id
AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
AND (membres.fonctions_fonction_id BETWEEN 1 AND 3 OR membres.fonctions_fonction_id = 41)
AND membres_commissions_commission_id = %s 
AND mois = %s 
AND annee = %s 
ORDER BY fonctions.fonction_id", GetSQLValueString($commission_id, "int"),GetSQLValueString($txt_Month, "text"),GetSQLValueString($txt_Year, "text"));
} else {
$query_rsSessions = sprintf("SELECT commission_id, personnes.personne_id, personne_nom, fonctions.fonction_id, fonction_lib, nombre_jour, jour, mois, annee, montant, (nombre_jour * montant) as total
FROM commissions, membres, personnes,  fonctions, sessions
WHERE membres.commissions_commission_id = commissions.commission_id
AND membres.personnes_personne_id = personnes.personne_id
AND membres.fonctions_fonction_id = fonctions.fonction_id
AND sessions.membres_commissions_commission_id = membres.commissions_commission_id
AND sessions.membres_personnes_personne_id = membres.personnes_personne_id
AND (membres.fonctions_fonction_id BETWEEN 1 AND 3 OR membres.fonctions_fonction_id = 41)
AND membres_commissions_commission_id = %s 
AND mois = %s 
AND annee = %s 
ORDER BY fonctions.fonction_id", GetSQLValueString($commission_id, "int"),GetSQLValueString($txt_Month, "text"),GetSQLValueString($txt_Year, "text"));	
}
$rsSessions = mysql_query($query_rsSessions, $MyFileConnect) or die(mysql_error());
$row_rsSessions = mysql_fetch_assoc($rsSessions);
$totalRows_rsSessions = mysql_num_rows($rsSessions);

$colname_rsSessionRepresentant = "-1";
if (isset($_POST['txt_Com'])) {
  $colname_rsSessionRepresentant = $_POST['txt_Com'];
}
$colname1_rsSessionRepresentant = "-1";
if (isset($_POST['txt_Year'])) {
  $colname1_rsSessionRepresentant = $_POST['txt_Year'];
}
$colname2_rsSessionRepresentant = "-1";
if (isset($txt_Month)) {
  $colname2_rsSessionRepresentant = $txt_Month;
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($txt_Year) && $txt_Year != 0 ){
$query_rsSessionRepresentant = sprintf("SELECT commission_id, personne_id, personne_nom, fonctions.fonction_id, fonction_lib, structures.structure_id, code_structure, nombre_jour, jour, mois, annee, montant, (nombre_jour * montant) as total FROM commissions, membres, personnes,  fonctions, sessions, structures WHERE membres.commissions_commission_id = commissions.commission_id  AND membres.personnes_personne_id = personnes.personne_id  AND personnes.structure_id = structures.structure_id AND membres.fonctions_fonction_id = fonctions.fonction_id AND sessions.membres_commissions_commission_id = membres.commissions_commission_id AND sessions.membres_personnes_personne_id = membres.personnes_personne_id AND membres.fonctions_fonction_id = 40 AND membres_commissions_commission_id = %s AND mois = %s  AND annee = %s ORDER BY personne_nom, annee, mois ASC", GetSQLValueString($commission_id, "int"),GetSQLValueString($txt_Month, "int"),GetSQLValueString($txt_Year, "int"));
} else {
$query_rsSessionRepresentant = sprintf("SELECT commission_id, personne_id, personne_nom, fonctions.fonction_id, fonction_lib, structures.structure_id, code_structure, nombre_jour, jour, mois, annee, montant, (nombre_jour * montant) as total FROM commissions, membres, personnes,  fonctions, sessions, structures WHERE membres.commissions_commission_id = commissions.commission_id  AND membres.personnes_personne_id = personnes.personne_id  AND personnes.structure_id = structures.structure_id AND membres.fonctions_fonction_id = fonctions.fonction_id AND sessions.membres_commissions_commission_id = membres.commissions_commission_id AND sessions.membres_personnes_personne_id = membres.personnes_personne_id AND membres.fonctions_fonction_id = 40 AND membres_commissions_commission_id = %s AND mois = %s  AND annee = %s ORDER BY personne_nom, annee, mois ASC", GetSQLValueString($colname_rsSessionRepresentant, "int"),GetSQLValueString($colname2_rsSessionRepresentant, "int"),GetSQLValueString($colname1_rsSessionRepresentant, "int"));
}
$rsSessionRepresentant = mysql_query($query_rsSessionRepresentant, $MyFileConnect) or die(mysql_error());
$row_rsSessionRepresentant = mysql_fetch_assoc($rsSessionRepresentant);
$totalRows_rsSessionRepresentant = mysql_num_rows($rsSessionRepresentant);


mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($txt_Year) && $txt_Year != 0 ){
$query_rsDossiers_traites = sprintf("SELECT * FROM dossier_traites WHERE dossiers_commission_id = %s AND mois = %s AND annee = %s", GetSQLValueString($commission_id, "int"), GetSQLValueString($txt_Month, "text"),GetSQLValueString($txt_Year, "text"));
} else {
$query_rsDossiers_traites = sprintf("SELECT * FROM dossier_traites WHERE dossiers_commission_id = %s AND mois = %s AND annee = %s", GetSQLValueString($commission_id, "int"), GetSQLValueString($txt_Month, "text"),GetSQLValueString($txt_Year, "text"));
}
$rsDossiers_traites = mysql_query($query_rsDossiers_traites, $MyFileConnect) or die(mysql_error());
$row_rsDossiers_traites = mysql_fetch_assoc($rsDossiers_traites);
$totalRows_rsDossiers_traites = mysql_num_rows($rsDossiers_traites);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><!-- InstanceBegin template="/Templates/FilesTemplates.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

$MM_authorizedUsers = "0,1,2,3,4,5,6,7,8";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "connexions.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  MinmapDB::getInstance()->update_users_connected('0', $_SESSION['MM_UserID']);
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['MM_UserID'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['MM_taux'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['MM_UserID']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_taux']);

	
  $logoutGoTo = "connexions.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

$colname_rsMenus = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_rsMenus = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
//$query_rsMenus = sprintf("SELECT * FROM menus WHERE user_groupe_id = %s OR  user_groupe_id = 0 AND display_agescom = 1 ORDER BY menu_id ASC", GetSQLValueString($colname_rsMenus, "int"));
$query_rsMenus = sprintf("SELECT * FROM menus WHERE application = 'agescom' AND display = 1 ORDER BY menu_id ASC", GetSQLValueString($colname_rsMenus, "int"));
$rsMenus = mysql_query($query_rsMenus, $MyFileConnect) or die(mysql_error());
$row_rsMenus = mysql_fetch_assoc($rsMenus);
$totalRows_rsMenus = mysql_num_rows($rsMenus);

$colname_rsSousMenu = "-1";
if (isset($_GET['menuID'])) {
  $colname_rsSousMenu = $_GET['menuID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsSousMenu = sprintf("SELECT * FROM sous_menus WHERE menu_id = %s AND display = '1' ORDER BY position ASC", GetSQLValueString($colname_rsSousMenu, "int"));
$rsSousMenu = mysql_query($query_rsSousMenu, $MyFileConnect) or die(mysql_error());
$row_rsSousMenu = mysql_fetch_assoc($rsSousMenu);
$totalRows_rsSousMenu = mysql_num_rows($rsSousMenu);

$UserGroupe = (MinmapDB::getInstance()->get_user_groupe_by_user_login($_SESSION['MM_Username']));

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>

<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
<link href="../../css/file.css" rel="stylesheet" type="text/css">
<!-- InstanceBeginEditable name="head" -->
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<!-- InstanceEndEditable -->
<head>
<meta name="google-site-verification" content="UTnSYJLBKJIOsm6MUJcJBkF7fv-Cm7koeofeyBHwBRA" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- InstanceBeginEditable name="doctitle" -->
<title>AGESCOM :  Accueil</title>
<!-- InstanceEndEditable -->
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<meta name="description" content="Le ministère des Marches Publics du Cameroun">
<meta name="keywords" content="Abba SADOU, ministre, Marches, Ministère des Marches Publics, ">
<link type="text/css" rel="stylesheet" href="../../css/v2.css">
<!--[if IE 6]>
		<link type="text/css" rel="stylesheet" href="/css/patch-ie6.css">
	<![endif]-->
<!--[if IE]>
		<link type="text/css" rel="stylesheet" href="/css/patch-ie.css">
	<![endif]-->
<link href="../../css/mktree.css" rel="stylesheet" type="text/css">
<link href="../../css/mktree2.css" rel="stylesheet" type="text/css">
<script src="../../js/tools.js" language="JavaScript" type="text/javascript"></script>
<script language="javascript" type='text/javascript'>
    function session(){
        window.location="<?php echo $logoutInactiv ?>"; //page de déconnexion
    }
	function window_onbeforeunload()
    {
       window.navigate('<?php echo $logoutInactiv ?>'); 
       //ne pas oublier de préciser le chemin si vous mettez la page dans un autre répertoire
    }
    setTimeout("session()",1800000); //Pour 30min
	//setTimeout("session()",10000);
	window.onbeforeunload="<?php echo $logoutInactiv ?>";
</script>
</head>
<body class="home">
<a name="haut"></a>
<!--b001n-->
<div class="hiden">
  <h3>Menu accessibilit&eacute;</h3>
  <p><a href="../../index.htm" target="_top" accesskey="A">Aller &agrave; l'accueil</a><br>
    <a href="#menu" accesskey="M">Aller au menu</a><br>
    <a href="#work_h" accesskey="C">Aller au contenu</a><br>
    <a href="#">Aller &agrave; la page d'aide</a><br>
    <a href="#" target="_top" accesskey="P">Plan du site</a></p>
</div>
<!--/b001n-->
<div id="outter">
  <div id="inner">
    <!--b002n1-->
    <div id="header">
      <div id="logo"><img src="../../images/img/v2/amoirie.gif" alt="armoirie" width="78" height="52"><a href="#" target="_top"><img src="../../images/img/v2/flag.gif" alt="Ministère des Marchés Publics" width="89" border="0" height="52" hspace="2"></a>
               <h2>Application de GEStion des COMmissions au MINMAP</h2>
      </div>
      <!-- /#logo -->
      <div class="menu">
        <ul>
        <?php do { ?>
        
          <li id="accueil"><a href="<?php echo htmlentities($row_rsMenus['lien']); ?>"><?php echo htmlentities($row_rsMenus['menu_lib']); ?></a></li>
        <?php } while ($row_rsMenus = mysql_fetch_assoc($rsMenus)); ?>
        </ul>
      </div>
      <!--/.menu-->
    </div>
    <!--/#header-->
    <!--/b002n1-->
    <div class="col_droite">
	<div class="bloc lois_recentes">
        <h4>Session ouverte</h4>
        <ul class="tous_les">

    	<table width="200" border="0">
    	  <tr>
    	    <td width="54" align="center"><ul class="tous_les">
    	      <img src="../../images/Icones/user.jpg" width="30" height="30">
    	      </ul></td>
    	    <td width="136" valign="middle"><ul class="tous_les">
    	      <strong><?php //echo $_SESSION['MM_Username'] ?><?php echo MinmapDB::getInstance()->get_user_name($_SESSION['MM_UserID']); ?></strong>
    	    </ul></td>
    	    </tr>
    	  <tr>
    	    <td width="54" align="center"><ul class="tous_les">
    	      <img src="../../images/Icones/user_group_100832.jpg" width="40" height="40">
  	      </ul></td>
    	    <td valign="middle"><?php echo $_SESSION['MM_UserGroupName']; ?></td>
  	    </tr>
    	  <tr>
    	    <td><ul class="tous_les">
    	      <a href="<?php echo $logoutAction ?>"><img src="../../images/Icones/naviguer-8.png" width="50" height="32"></a>
    	      </ul></td>
    	    <td><a href="<?php echo $logoutAction ?>"><strong>Se déconnecter</strong></a></td>
  	    </tr>
  	  </table></BR>
        </ul>
      </div>
    <?php if ($totalRows_rsSousMenu > 0) { // Show if recordset not empty ?>
  <div class="bloc lois_recentes">
    <h4>Sous Menu <?php echo $row_rsMenus['menu_id']?></h4>
    <ul class="tous_les">
      <?php do { ?>
        <a href="<?php echo $row_rsSousMenu['sous_menu_lien']; ?>?menuID=<?php echo $_GET['menuID']; ?>&&action=<?php echo $row_rsSousMenu['action']; ?>"><img src="../../images/img/		<?php echo $row_rsSousMenu['image']; ?>" width="16" height="16" align="middle" /><?php echo htmlentities($row_rsSousMenu['sous_menu_lib']); ?></a>&nbsp;</BR>
        <?php } while ($row_rsSousMenu = mysql_fetch_assoc($rsSousMenu)); ?>
    </ul>
  </div>
  <?php } // Show if recordset not empty ?>
      <div class="logos">
        <div class="bloc lois_recentes">
          <h4>Profil</h4>
          <ul class="tous_les">
            <a href="sample65.php?uID=<?php echo $_SESSION['MM_UserID']; ?>">Modifier mon mot de passe? </a></BR></BR>
          </ul>
        </div>
        <div class="bloc express">
          <h4><strong>Statistiques</strong></h4>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </div>
        <p>&nbsp;</p>
        <div class="bloc lois_recentes">
          <h4>Notifications</h4>
          <ul class="tous_les">
            <p>Vous avez  :<strong> 
			<?php echo MinmapDB::getInstance()->get_nbre_commentaire_non_lu($_SESSION['MM_UserID']); ?></strong>
          <?php           
			$showGoTo = "sample50.php?userID=".$_SESSION['MM_UserID'];
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
          <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"><img src="../../images/img/message.png" width="28" height="18" align="middle"> Messages non lus</a></p>
            <p><a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"><img src="../../images/Icones/envoyer-icone.png" width="25" height="25" border="0" align="middle"></a>  
              <?php           
			$showGoTo = "sample49.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
              <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>">Envoyer un commentaire</a></p>
            <p>
              <?php           
			$showGoTo = "sample67.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
              <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"><img src="../../images/Icones/ico_forum.png" width="30" height="31" border="0" align="left">Afficher historique des conversations</a></p>
            <p><a href="../../messenger/edit_infos.php">editer mes informations</a></p>
          </ul>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div>
	 
	  <!--/#tag_cloud-->

    </div>
    <!-- InstanceBeginEditable name="EditBoby" -->
<h1>Afficher une session</h1>
<form id="form1" name="form1" method="post" action="">
  <table width="80%" border="0" align="center">
    <tr>
      <td><table width="75%" border="1" align="left" class="std2">
        <tr valign="baseline">
          <td colspan="5" nowrap="nowrap">Selectionner  une autre commission
            <?php           
	$showGoTo = "search_commissions4.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $showGoTo .= (strpos($showGoToPersonne, '?')) ? "&" : "?";
    $showGoTo .= $_SERVER['QUERY_STRING'];
  }
?>
            <a href="#" onclick="<?php popup($showGoTo, "610", "300"); ?>"><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle" /></a><br/>
            <strong>
              <?php if (isset($commission_id)) { ?>
                  <?php } ?>
              </strong>
            <input name="comID" type="hidden" id="comID" value="<?php echo $row_rsCommissions['commission_id']; ?>" />
            <?php
             /** Display error messages if the "commission" field is empty */
            if ($commissionIsEmpty || !isset($commission_id)) { ?>
            <div class="control"><img src="images/img/s_attention.png" alt="" width="16" height="16" align="absmiddle" />Choose commission, please</div>
            <?php }
            ?>
            <input type="hidden" name="comID" value="<?php echo $row_rsCommissions['commission_id']; ?>" size="32" /></td>
        </tr>
        <tr>
          <th>ID</th>
          <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 ) { ?>
          <th>&nbsp;</th>
          <?php } ?>
          <th>Type</th>
          <th>Nature </th>
          <th>Localite</th>
        </tr>
        <tr><?php echo $row_rsSousMenu['']; ?>
          <td nowrap="nowrap"><img src="images/img/b_views.png" alt="" width="16" height="16" /></td>
          <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 ) { ?>
          <td nowrap="nowrap"><a href="#" onClick="return confirm('Etes vous sur de vouloir supprimer cette commission, ses membres et toutes ses sessions ?');"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/></a>&nbsp;</td>
          <?php } ?>
          <td nowrap="nowrap"><?php echo $row_rsCommissions['type_commission_lib']; ?>&nbsp;</td>
          <td nowrap="nowrap"><?php echo $row_rsCommissions['lib_nature']; ?>&nbsp;</td>
          <td nowrap="nowrap"><?php echo $row_rsCommissions['localite_lib']; ?>&nbsp;</td>
        </tr>
        <tr valign="baseline">
        <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == '1' ) { ?>
          <td colspan="5" align="right" nowrap="nowrap"><input type="hidden" name="MM_insert" value="form1" /></td>
        <?php } else { ?>
          <td colspan="4" align="right" nowrap="nowrap"><input type="hidden" name="MM_insert" value="form1" /></td>
        <?php } ?>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><?php if ($totalRows_rsCommissions > 0) { // Show if recordset not empty ?>
        <table align="left" class="std2">
          <tr valign="baseline">
            <th nowrap="nowrap" align="right">Mois:</th>
            <td><select name="mID" id="mID">
              <option value="" <?php if (!(strcmp("", $txt_Month))) {echo "selected=\"selected\"";} ?>>:: Select...</option>
              <?php do {  ?>
              <?php if (isset($txt_Month) && $txt_Month != 0 ) { ?>
              <option value="<?php echo $row_rsMois['mois_id']?>"<?php if (!(strcmp($row_rsMois['mois_id'], $txt_Month))) {echo "selected=\"selected\"";} ?>> <?php echo ucfirst($row_rsMois['lib_mois']) ?></option>
              <?php } else { ?>
              <option value="<?php echo $row_rsMois['mois_id']?>"<?php if (!(strcmp($row_rsMois['mois_id'], $txt_Month))) {echo "selected=\"selected\"";} ?>> <?php echo ucfirst($row_rsMois['lib_mois']) ?></option>
              <?php } ?>
              <?php
			} while ($row_rsMois = mysql_fetch_assoc($rsMois));
			  $rows = mysql_num_rows($rsMois);
			  if($rows > 0) {
				  mysql_data_seek($rsMois, 0);
				  $row_rsMois = mysql_fetch_assoc($rsMois);
			  }
			?>
            </select>
              <?php
             /** Display error messages if the "password" field is empty */
       if ($moisIsEmpty) { ?>
              <div class="control"><img src="images/img/s_attention.png" alt="" width="16" height="16" align="absmiddle" />Select month, please</div>
              <?php  } ?></td>
          </tr>
          <tr valign="baseline">
            <th nowrap="nowrap" align="right">Ann&eacute;e : </th>
            <td>
            <select name="aID" id="aID">
              <option value="" <?php if (!(strcmp("", $txt_Year))) {echo "selected=\"selected\"";} ?>>:: Select...</option>
              <?php
do {  
?>
              <?php if (isset($txt_Year) && $txt_Year != 0) { ?>
              <option value="<?php echo $row_rsSelYear['lib_annee']?>"<?php if (!(strcmp($row_rsSelYear['lib_annee'], $txt_Year))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSelYear['lib_annee']?></option>
              <?php } else { ?>
              <option value="<?php echo $row_rsSelYear['lib_annee']?>"<?php if (!(strcmp($row_rsSelYear['lib_annee'], $txt_Year))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSelYear['lib_annee']?></option>
              <?php } ?>
              <?php
} while ($row_rsSelYear = mysql_fetch_assoc($rsSelYear));
  $rows = mysql_num_rows($rsSelYear);
  if($rows > 0) {
      mysql_data_seek($rsSelYear, 0);
	  $row_rsSelYear = mysql_fetch_assoc($rsSelYear);
  }
?>
            </select>
              <?php
             /** Display error messages if the "password" field is empty */
       if ($anneeIsEmpty) { ?>
              <div class="control"><img src="images/img/s_attention.png" alt="" width="16" height="16" align="absmiddle" />Enter the YEAR, please</div>
              <?php  } ?></td>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?></td>
    </tr>
    <tr>
      <td><input type="submit" value="Rechercher..." />
        <?php if ($totalRows_rsSessions == 0) { // Show if recordset empty ?>
          <a href="<?php echo $linkSession ?>"><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/>Ajouter une nouvelle session à la commission</a>
          <?php } // Show if recordset empty ?></td>
    </tr>
  </table>
</form>
<?php if ($totalRows_rsSessions > 0) { // Show if recordset not empty ?>
<h1>Membres Commission</h1>
<?php if (isset($etat_validate) && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==4 || $_SESSION['MM_UserGroup']==6)) { ?>
<table>
  <tr>
    <td><a href="#" onclick="<?php popup($link13, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" /> Version imprimable</a>&nbsp; 
	<?php $user_group = (MinmapDB::getInstance()->get_user_groupe_by_name($_SESSION['MM_Username'])); ?>
    <a href="#" onclick="<?php popup($link, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" /> Imprimer Etat</a>&nbsp; 
    <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6)){ ?>
    <a href="#" onclick="<?php popup($link11, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" /> Imprimer Recapitulatif </a>
	<a href="#" onclick="<?php popup($link17, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" /> Imprimer Recapitulatif 1</a>
    <a href="#" onclick="<?php popup($link18, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" /> Imprimer Recapitulatif 2</a>
    <?php } ?>&nbsp;&nbsp;
      <!--<a href="#" onclick="<?php //popup($link12, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" />Version imprimable22</a>&nbsp;&nbsp;-->
      <?php if (isset($etat_validate) && $etat_validate==0) { ?>
      <a href="<?php echo $link2 . "&valid=mb" ?>"><img src="images/img/b_edit.png" width="16" height="16" /> Modifier la session</a>&nbsp;&nbsp; 
      <?php } ?>
      <a href="<?php echo $link10."&valid=mb" ?>"><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/>Ajouter une nouvelle session à la commission</a>&nbsp;&nbsp; 
 	  <?php $user_group = MinmapDB::getInstance()->get_user_groupe_by_name($_SESSION['MM_Username']);
		if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
       <a href="#"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/>Supprimer la session de la commission</a></BR>
       <?php } ?></td>
  </tr>
</table>
<?php } ?>
<?php $count_member = MinmapDB::getInstance()->get_count_member_by_commission_id($commission_id); ?>
<table border="1" align="center" class="std">
  <tr>
    <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
    <th nowrap="nowrap">U</th>
    <?php } else { ?>
    <th nowrap="nowrap">N&deg;</th>
    <?php } ?>
    <?php $user_group = MinmapDB::getInstance()->get_user_groupe_by_name($_SESSION['MM_Username']);
		if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
    <th nowrap="nowrap">&nbsp;</th>
    <?php } ?>
    <th align="center" nowrap="nowrap">Nom et Prenom</th>
    <th align="center" nowrap="nowrap">Fonction</th>
    <?php $counter=0; do  { $counter++; ?>
    <th nowrap="nowrap"><?php echo $counter ?>&nbsp;</th>
    <?php }while ($counter < $row_rsJourMois['nbre_jour']);?>
    <th nowrap="nowrap">Total</th>
    <th nowrap="nowrap">Taux</th>
    <th nowrap="nowrap">Montant</th>
  </tr>
  <tr>
    <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
    <td colspan="4" align="center"><strong>Nombre de dossiers trait&eacute;s</strong></td>
    <?php } else { ?>
    <td colspan="3" align="center"><strong>Nombre de dossiers trait&eacute;s</strong></td>
    <?php } ?>
    <?php  
	  $count = count(explode("**", $row_rsDossiers_traites['nombre_dossier'])); 
	  $liste_nbre = explode("**", $row_rsDossiers_traites['nombre_dossier']);
	  $counter=0; $compt=0; $som_value = 0; do  { $counter++; ?>
    <td><strong>
      <?php 
					//$i =0; do { 
					$countDoc = 0; 
					foreach(explode("**", $row_rsDossiers_traites['jour']) as $val){
						$countDoc++; 
						 $val == $counter ? (print $liste_nbre[$compt]) : ""; 
						 $val == $counter ? ($som_value = $som_value + $liste_nbre[$compt]) : "";
						 
						 //$i++;
					 }
					//}while ($i<$count)
			?>
      &nbsp;</strong></td>
    <?php $compt++; }while ($counter < $row_rsJourMois['nbre_jour']);?>
    <td align="right"><strong><?php echo $som_value //$row_rsSessions['nombre_dossier']; ?></strong></td>
    <td><?php echo array_sum($row_rsDossiers_traites['nombre_dossier']) ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php $counter=0; $compter=0; $somme1 = 0; $somme2 = 0; do  { $counter++; $compter++; ?>
  <tr>
    <td nowrap="nowrap"><?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
      <a href="<?php echo $link20 . "&persID=" . $row_rsSessions['personne_id']."&valid=mb" ?>"><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } else {?>
      <?php echo $compter ?>
      <?php } ?>
      <?php           
	$showGoToPersonnes1 = "upd_rib.php?recordID=". $row_rsSessions['personne_id'];
	?></td>
    <?php $user_group = MinmapDB::getInstance()->get_user_groupe_by_name($_SESSION['MM_Username']);
		if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
    <td nowrap="nowrap"><a href="<?php echo $link5 . $row_rsSessions['personne_id']; ?>" onclick="return confirm('Etes vous sur de vouloir supprimer 																																																				cette sessions ?');"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/></a><a href="maj_personnes.php?recordID=<?php echo $row_rsSessions['membres_personnes_personne_id']; ?>&amp;map=personnes"></a></td>
    <?php } ?>
    <td><a href="#" onclick="<?php popup($showGoToPersonnes1, "700", "400"); ?>"><?php echo strtoupper($row_rsSessions['personne_nom'] . " " . ucfirst(strtolower($row_rsSessions['personne_prenom']))); ?>
      <?php //echo $user_id = (MinmapDB::getInstance()->get_user_id_by_name($_SESSION['MM_Username']));
		  $user_rib = (MinmapDB::getInstance()->get_user_rib_by_id($row_rsSessions['personne_id']));
		  if (isset($user_rib) && $user_rib <> 'xxxxxxxxxxxxxxxxxxxxxxx'){ ?>
      <img src="images/img/s_okay.png" alt="" width="16" height="16" align="absmiddle"/>
      <?php } ?>
    </a>&nbsp; </td>
    <td nowrap="nowrap"><?php echo strtoupper($row_rsSessions['fonction_lib']); ?>&nbsp; </td>
    <?php $counter=0; do  { $counter++; ?>
    <td nowrap="nowrap"><a href="#">
      <?php 
					$countDoc = 0;
					foreach(explode("**", $row_rsSessions['jour']) as $val){
						$countDoc++; 
						$val == $counter ? (print "1") : $countDoc--; 
						
					}
			?>
    </a></td>
    <?php }while ($counter < $row_rsJourMois['nbre_jour']); ?>
    <td align="right" nowrap="nowrap"><?php echo $row_rsSessions['nombre_jour']; ?></td>
    <?php $showGoToMembre = "upd_membre.php?persID=" . $row_rsSessions['personne_id'] . "&comID=".$commission_id."&foncID=".$row_rsSessions['fonction_id'] ; ?>
    <td align="right" nowrap="nowrap"><?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
      <a href="#" onclick="<?php popup($showGoToMembre, "700", "400"); ?>"> <?php echo number_format($row_rsSessions['montant'],0,' ',' '); ?><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/> </a>
      <?php } else {?>
      <?php echo number_format($row_rsSessions['montant'],0,' ',' '); ?>
      <?php } ?></td>
    <td align="right" nowrap="nowrap"><strong><?php echo number_format($row_rsSessions['total'],0,' ',' '); ?>
      <?php $somme2 = $somme1; $somme1 = $somme1 + $row_rsSessions['total'];  ?>
      F CFA </strong></td>
  </tr>
  <?php } while ($row_rsSessions = mysql_fetch_assoc($rsSessions)); ?>
  <tr>
    <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
    <td height="29" colspan="<?php echo $row_rsJourMois['nbre_jour']+5 ?>">&nbsp;</td>
    <?php } else { ?>
    <td height="29" colspan="<?php echo $row_rsJourMois['nbre_jour']+4 ?>">&nbsp;</td>
    <?php } ?>
    <?php $counter=0; do  { $counter++; ?>
    <?php }while ($counter < $row_rsJourMois['nbre_jour']);?>
    <th align="center" nowrap="nowrap"><strong>Sous total</strong></th>
    <th nowrap="nowrap"><strong>
      <?php $somme1 = $somme1 - $row_rsCountIndemnity['total']; echo number_format($somme2,0,' ',' '); ?>
      F CFA</strong></th>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_rsSousCommission > 0) { // Show if recordset not empty ?>
<h1>Sous Commissions</h1>
  <table width="60%" border="1" align="center" class="std">
    
    <?php $count=0; $Montant_global=0; do { $count++; ?>
    <tr>
      <th width="18" nowrap="nowrap">N&deg;</th>
      <th width="158" nowrap="nowrap">Nom et objet du DAO</th>
      <th nowrap="nowrap">Membre de la sous commission</th>
      <th width="225" align="center" nowrap="nowrap">Montant Projet</th>
      <th nowrap="nowrap">Nombre Soumissionnaires</th>
    </tr>
    <tr>
      <td colspan="5" nowrap="nowrap">
      <?php if (isset($etat_validate) && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6)) { ?>
      <table align="left">
        <tr>
          <td>
          <a href="#" onclick="<?php popup($link15, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" />Version imprimable</a>&nbsp;
          <a href="#" onclick="<?php popup($link19, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" />Version imprimable2</a>&nbsp;
          <?php if (isset($etat_validate) && $etat_validate==0) { ?> 
          <a href="<?php echo $link16 . "&valid=mb&comID=" . $commission_id . "&sCom=" . $row_rsSousCommission['commission_id'] ?>"><img src="images/img/b_edit.png" width="16" height="16" /> Modifier</a>&nbsp;&nbsp;
          <?php } ?>
          <a href="<?php echo $link10 . "&valid=scom" ?>"><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/>Ajouter une session</a>&nbsp;&nbsp;<a href="#"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/>Supprimer la session</a></td>
          </tr>
      </table>
      <?php } ?>
      </td>
    </tr>
    <tr>
      <td align="center" valign="middle">&nbsp; <a href="detail_sous_commission.php?recordID=<?php echo $row_rsSousCommission['commission_id']; ?>"><?php echo $row_rsSousCommission['commission_id']; ?><?php //echo $count; ?></a><br /></td>
      <?php 
	  echo $dossierID = MinmapDB::getInstance()->get_dossier_id_by_value($row_rsSousCommission['commission_id'], $txt_Month, $txt_Year);
	  $showGoTextModif = "modif_dossiers.php?dosID=". $dossierID; ?>
      <td><a href="#" onclick="<?php popup($showGoTextModif, "500", "200"); ?>" >
        <?php $com_ID = $row_rsSousCommission['commission_id'];
	  		echo MinmapDB::getInstance()->get_dossier_ref_by_value($com_ID, $txt_Month, $txt_Year); 
			 ?>
        &nbsp;</a></td>
      <td valign="top">
	  <?php
	  	$colname_rsMembres = "-1";
		if (isset($row_rsSousCommission['commission_id'])) {
		  $colname_rsMembres = $row_rsSousCommission['commission_id'];
		}
		mysql_select_db($database_MyFileConnect, $MyFileConnect);
		$query_rsMembres = sprintf("SELECT * FROM membres WHERE commissions_commission_id = %s", GetSQLValueString($colname_rsMembres, "int"));
		$rsMembres = mysql_query($query_rsMembres, $MyFileConnect) or die(mysql_error());
		$row_rsMembres = mysql_fetch_assoc($rsMembres);
		$totalRows_rsMembres = mysql_num_rows($rsMembres);
	?>
        <table width="100%" align="left" id="*">
          <tr>
            <th nowrap="nowrap">Nom et Prenoms</th>
            <th nowrap="nowrap">Fonction</th>
            <th nowrap="nowrap">Montant</th>
          </tr>
          <?php do { ?>
                <?php           
				$showGoToPersonnes2 = "upd_rib.php?recordID=". $row_rsMembres['personnes_personne_id'];
				?>
            <tr>
              <td nowrap><a href="#" onclick="<?php popup($showGoToPersonnes2, "700", "400"); ?>"><?php echo strtoupper(MinmapDB::getInstance()->get_personne_name_by_person_id($row_rsMembres['personnes_personne_id'])); ?></a>
          <?php //echo $user_id = (MinmapDB::getInstance()->get_user_id_by_name($_SESSION['MM_Username']));
		  $user_rib = (MinmapDB::getInstance()->get_user_rib_by_id($row_rsMembres['personnes_personne_id']));
		  if (isset($user_rib) && $user_rib <> 'xxxxxxxxxxxxxxxxxxxxxxx'){ ?>
          <img src="images/img/s_okay.png" alt="" width="16" height="16" align="absmiddle"/>
          <?php } ?>
          </a></td>
              <td nowrap><?php echo strtoupper(MinmapDB::getInstance()->get_fonction_lib_by_fonction_id($row_rsMembres['fonctions_fonction_id'])); ?>&nbsp; </td>
              <td align="right" nowrap><?php echo number_format($row_rsMembres['montant'],0,' ',' '); $Montant_global = $Montant_global + $row_rsMembres['montant'];?>&nbsp; </td>
            </tr>
            <?php } while ($row_rsMembres = mysql_fetch_assoc($rsMembres)); ?>
      </table></td>
      <?php           
		$showGoToPersonnes3 = "sample64.php?comID=". $row_rsSousCommission['commission_id'];
		$GoToChangeStructure = "change_structure.php?strID=". $row_rsSessionRepresentant['structure_id'] ."&lID=". $_REQUEST['lID'];
	  ?>
      <td align="center"><strong><a href="#" onclick="<?php popup($showGoToPersonnes3, "500", "200"); ?>">
	  <?php echo number_format($row_rsSousCommission['montant_cumul'],0,' ',' ');  ?> F CFA<img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a></strong></td>
      <td align="center"><strong><a href="#" onclick="<?php popup($showGoToPersonnes3, "500", "200"); ?>">
	  <?php echo $row_rsSousCommission['nombre_offre']; ?><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a></strong></td>
    </tr>
    <?php } while ($row_rsSousCommission = mysql_fetch_assoc($rsSousCommission)); ?>
   <tr>
      <td width="18" nowrap="nowrap">&nbsp;</td>
      <td width="158" nowrap="nowrap">&nbsp;</td>
      <td nowrap="nowrap">&nbsp;</td>
      <th width="225" align="right" nowrap="nowrap">Sous Total :</th>
      <th align="right" nowrap="nowrap"><?php echo number_format($Montant_global,0,' ',' '); ?> F CFA&nbsp;</th>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
  
<p>
  <?php if ($totalRows_rsSessionRepresentant > 0) { // Show if recordset not empty ?>
</p>
<h1>Representants Maitres d'Ouvrages &agrave; la commission</h1>
<?php if (isset($etat_validate) && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6)) { ?>
<table>
  <tr>
    <td><a href="#" onclick="<?php popup($link14, "1200", "700") ?>"><img src="images/img/b_print.png" width="16" height="16" />Version imprimable</a>&nbsp;&nbsp;
    <?php if (isset($etat_validate) && $etat_validate==0) { ?>
    <a href="<?php echo $link2 . "&valid=mo" ?>"><img src="images/img/b_edit.png" width="16" height="16" /> Modifier</a>
	<?php } ?>
    <a href="change_etat_index.php?recordID=<?php echo $row_rsPersonnes['personne_id']; ?>&amp;map=personnes&amp;&amp;mapid=personne_id&amp;action=add_com&amp;page=rep"></a>&nbsp;&nbsp;<a href="<?php echo $link10 . "&valid=mo" ?>"><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/>Ajouter une session</a>&nbsp;&nbsp;
    <?php $user_group = MinmapDB::getInstance()->get_user_groupe_by_name($_SESSION['MM_Username']);
		if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
        <a href="#"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/>Supprimer les sessions de tous les repr&eacute;sentant</a>
    <?php } ?>
    </td>
  </tr>
</table>
<?php } ?>
<table border="1" align="center" class="std">
  <tr>
    <th>ID</th>
    <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
    <th>&nbsp;</th>
    <?php } ?>
    <th>Nom </th>
    <th>Structure</th>
    <?php $count=0; do { $count++ ?>
    <th><?php echo $count ?>&nbsp;</th>
    <?php } while($count<$row_rsJourMois['nbre_jour']) ?>
    <th>Total</th>
    <th>Taux</th>
    <th>Montant</th>
  </tr>
  <?php $compter=0; $sommes=0; do { $compter++ ?>
  <?php           
	$showGoToPersonnes3 = "upd_rib.php?recordID=". $row_rsSessionRepresentant['personne_id'];
	?>
  <tr>
    <td><?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
      <a href="<?php echo $link20 . "&persID=" . $row_rsSessionRepresentant['personne_id'] . "&valid=mo" ?>"><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } else {?>
      <?php echo $compter ?>
      <?php } ?></td>
    <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
    <td><a href="<?php echo $link5 . $row_rsSessionRepresentant['personne_id']; ?>" onclick="return confirm('Etes vous sur de vouloir supprimer 																																																				cette sessions ?');"><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/></a></td>
    <?php } ?>
    <td><a href="#" onclick="<?php popup($showGoToPersonnes3, "700", "400"); ?>"><?php echo htmlentities(strtoupper($row_rsSessionRepresentant['personne_nom'])); ?></a>
      <?php //echo $user_id = (MinmapDB::getInstance()->get_user_id_by_name($_SESSION['MM_Username']));
		  $user_rib = (MinmapDB::getInstance()->get_user_rib_by_id($row_rsSessionRepresentant['personne_id']));
		  if (isset($user_rib) && $user_rib <> 'xxxxxxxxxxxxxxxxxxxxxxx'){ ?>
      <img src="images/img/s_okay.png" alt="" width="16" height="16" align="absmiddle"/>
      <?php } ?>
      &nbsp; </td>
    <td><a href="#" onclick="<?php popup($GoToChangeStructure, "700", "400"); ?>"><?php echo strtoupper($row_rsSessionRepresentant['code_structure']); ?>&nbsp;</a></td>
    <?php $count=0; $sommer=0; do { $count++ ?>
    <td><?php 
					$countDoc = 0;
					foreach(explode("**", $row_rsSessionRepresentant['jour']) as $val){ $countDoc++; $val == $count ? (print "1") : $countDoc--; }
			?>
      &nbsp;</td>
    <?php } while($count<$row_rsJourMois['nbre_jour']) ?>
    <td><?php echo $row_rsSessionRepresentant['nombre_jour']; ?>&nbsp; </td>
    <?php $showGoToMembre = "upd_membre.php?persID=" . $row_rsSessionRepresentant['personne_id'] . "&comID=".$commission_id."&foncID=".$row_rsSessionRepresentant['fonction_id'] ; ?>
    <td align="right" nowrap="nowrap">
    <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==5 || $_SESSION['MM_UserGroup']==6) && $etat_validate==0) { ?>
    <a href="#" onclick="<?php popup($showGoToMembre, "700", "400"); ?>"><?php echo number_format(($row_rsSessionRepresentant['montant']),0,' ',' '); ?><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a>
    <?php } else { ?>
    <?php echo number_format(($row_rsSessionRepresentant['montant']),0,' ',' '); ?>
    <?php } ?>&nbsp; </td>
    <td align="right"><?php $sommes = $sommes + $row_rsSessionRepresentant['total']; echo number_format($row_rsSessionRepresentant['total'],0,' ',' '); ?>
      F CFA
      &nbsp; </td>
  </tr>
  <?php } while ($row_rsSessionRepresentant = mysql_fetch_assoc($rsSessionRepresentant)); ?>
  <tr>
    <td colspan="<?php echo $row_rsJourMois['nbre_jour']+4 ?>" nowrap="nowrap">&nbsp;</td>
    <?php if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup'] == 1 && $etat_validate==0){ ?>
    <td nowrap="nowrap">&nbsp;</td>
    <?php } ?>
    <?php $count=0; do  { $count++; ?>
    <?php }while ($count < 12); ?>
    <th align="right" nowrap="nowrap"><strong>Sous Total</strong></th>
    <th align="right" nowrap="nowrap"><strong>
      <?php  echo number_format($sommes,0,' ',' '); ?>
      F CFA </strong></th>
  </tr>
</table>
<p>&nbsp;</p>

  <?php } // Show if recordset not empty ?>
<table>
  <tr>
    <td>
    <!--<form action="scriptValidate.php" method="post">-->
    
    	<?php
		
		if (isset($etat_validate) && $etat_validate=='0' && isset($etat_controlate) && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==6)) {
		$link = 'scriptValidate.php?comID='.$commission_id.'&mID='.$txt_Month.'&aID='.$txt_Year; ?>
        <h2>Demande de Modification de l'etat par les SERVICES DE CONTROLE</h2>
   	      <?php } ?>
    <!--</form>--></td>
  </tr>
</table>
<table>
  <tr>
    <td>
    <!--<form action="scriptValidate.php" method="post">-->
    
    	<?php
		
		if (isset($etat_validate) && $etat_validate=='0' && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==6)) {
		$link = 'scriptControlate2.php?comID='.$commission_id.'&mID='.$txt_Month.'&aID='.$txt_Year.'&value=1&champ=userValidate'; ?>
    	<input name="BtnValider" type="button" value="Valider la Saisie de l'etat de la  commission" onclick="<?php popup($link, "1", "1"); ?>">
        <?php } elseif (isset($etat_validate) && $etat_validate=='1' && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==6)) { ?>
        <input name="BtnValider" type="button" value="Etat transmis au Controle pour validation" disabled>
        <?php } elseif (isset($etat_validate) && $etat_validate=='2' && isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1 || $_SESSION['MM_UserGroup']==6)) { ?>
        <input name="BtnValider" type="button" value="Etat Validé par les SERVICES DU CONTROLE" disabled>
        <?php } ?>
        <?php if (isset($_SESSION['MM_UserGroup']) && ($_SESSION['MM_UserGroup']==1)) { 
		$linkage = 'scriptControlate2.php?comID='.$commission_id.'&mID='.$txt_Month.'&aID='.$txt_Year.'&value=0&champ=userValidate'; ?>
        <input name="BtnValider" type="button" value="Reinitialiser le session" onclick="<?php popup($linkage, "1", "1"); ?>">
        <?php } ?>
    <!--</form>--><!--Etat Saisi par : <?php //echo $row_rsSessions['user_id']; ?>--></td>
  </tr>
</table>
  </br>
</p>
<p></p>
<!-- InstanceEndEditable -->

	 
    <!--/#tag_cloud-->

    <!--/.col_droite-->
    <!-- /contenu -->
<!--b006n1-->
<div id="pied">
			<div class="o2paj"><a href="#haut" title="Retour Haut de page">Haut de page</a></div>
		  <p><a href="#">Accueil</a> - <a href="#">Fichier</a> - <a href="#">Commission</a> - <a href="#">Sessions</a> - <a href="#">Paiement</a> - <a href="#">Op&eacute;rations</a> - <a href="#">Parametres</a> - <a href="#">Etats</a> -<a href="#"> Aide</a><br>
	  - Copyright Minist&egrave;re des Marches Publics- <a href="#">Mentions l&eacute;gales</a> site web : <a href="www.minmap.cm">www.minmap.cm</a></p>
	</div>
<!--/b006n1-->
  </div>
</div>
<script type="text/javascript">
<!--
xtnv = document;        //parent.document or top.document or document
xtsd = "http://logp4/";
xtsite = "128343";
xtn2 = "1";        // level 2 site
xtpage = "Accueil_Economie";        //page name (with the use of :: to create chapters)
xtdi = "";        //implication degree
//-->
</script>
<script type="text/javascript" src="../../js/xtcore.js"></script>
<noscript>
<img width="1" height="1" alt="" src="http://logp4.xiti.com/hit.xiti?s=128343&amp;s2=1&amp;p=Accueil_Economie&amp;di=&amp;" >
</noscript>
</body>

<!-- Mirrored from www.economie.gouv.fr/ by HTTrack Website Copier/3.x [XR&CO'2010], Mon, 22 Nov 2010 11:36:30 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=ISO-8859-1"><!-- /Added by HTTrack -->

<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsSousCommission);

mysql_free_result($rsMembres);

mysql_free_result($rsSessionRepresentant);

mysql_free_result($rsMois);

mysql_free_result($rsSelYear);

mysql_free_result($rsJourMois);

mysql_free_result($rsCommissions);
?>
