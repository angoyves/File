<?php require_once('../../Connections/MyFileConnect.php'); ?>
<?php require('../includes/inc/db.php'); ?>
<?php
	  require('../includes2/db.php');
	  require('../includes2/fonction_db.php');
	  require('../includes2/DW_Fonctions.php');
	  require('../includes2/controler.php');
	  require("../inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  //require('../AGIS/includes/MyFonction.php');


?>
<?php

$typecommissionIsEmpty = false;
$natureIsEmpty = false;
$regionIsEmpty = false;
$departementIsEmpty = false;
$structureIsEmpty = false;
$localiteIsEmpty = false;

if (isset($_POST['type_commission_id']) && $_POST['type_commission_id'] == ""){
$typecommissionIsEmpty = true; }
if (isset($_POST['nature_id']) && $_POST['nature_id'] == ""){
$natureIsEmpty = true; }
if (isset($_POST['region_id']) && $_POST['region_id'] == ""){
$regionIsEmpty = true; }
if (isset($_POST['departement_id']) && $_POST['departement_id'] == ""){
$departementIsEmpty = true; }
if (isset($_POST['localite_id']) && $_POST['localite_id'] == ""){
$localiteIsEmpty = true; }
if (isset($_POST['idStructure']) && $_POST['idStructure'] == ""){
$structureIsEmpty = true; }

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_pubPm_insert")) {
  //$localite_lib = MinmapDB::getInstance()->get_localite_lib_by_localite_id($_POST['localite_id']);
  //$type_commission_lib = MinmapDB::getInstance()->get_type_commission_lib_by_commission_id($_POST['type_commission_id']);
  //$nature_lib = MinmapDB::getInstance()->get_nature_lib_by_nature_id($_POST['nature_id']);
  
  $comissionLib = MinmapDB::getInstance()->get_lib_by_id(type_commissions, type_commission_lib, type_commission_id, $_POST['type_commission_id']).' de '
  . MinmapDB::getInstance()->get_lib_by_id(natures, lib_nature, nature_id, $_POST['nature_id']).' place aupres de la (du) '
  . MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $_POST['idStructure']);
  MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_rsPersonnes['structure_id']);
  $insertSQL = sprintf("INSERT INTO commissions (commission_id, localite_id, type_commission_id, nature_id, structure_id, region_id, user_id, commission_lib, commission_parent, montant_cumul, nombre_offre, membre_insert, dateCreation, dateUpdate, display_agescom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['commission_id'], "int"),
                       GetSQLValueString($_POST['localite_id2'], "int"),
                       GetSQLValueString($_POST['type_commission_id'], "int"),
                       GetSQLValueString($_POST['nature_id'], "int"),
                       GetSQLValueString($_POST['idStructure'], "int"),
                       GetSQLValueString($_POST['region_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       //GetSQLValueString($_POST['commission_lib'], "text"),$comissionLib
					   GetSQLValueString($comissionLib, "text"),
                       GetSQLValueString($_POST['commission_parent'], "int"),
                       GetSQLValueString($_POST['montant_cumul'], "text"),
                       GetSQLValueString($_POST['nombre_offre'], "text"),	
                       GetSQLValueString(0, "text"),
                       GetSQLValueString(date(), "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString(1, "text"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

 $insertGoTo = "../commissions/CommissionListNew.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
/*echo "<script type='".text/javascript."'>
			if (confirm('Créer une nouvelle Commission???')) 
			{".
				  $insertGoTo = "CommissionReg.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			else
			{".
				  $insertGoTo = "liste_commissions.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			}
		</script>";
}*/
  
 /*     echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";*/
}


?>

<?php 

    $commissionID = MinmapDB::getInstance()->get_count_id_by_values(commissions, commission_id, localite_id, nature_id, structure_id, $_POST['localite_id'], $_POST['nature_id'], $_POST['structure_id']);
    if ($commissionID) {
        $commissionIsUnique = false;
    }

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((!$commissionIsUnique) || ($typecommissionIsEmpty) || ($natureIsEmpty) || ($regionIsEmpty) || ($departementIsEmpty) || ($localiteIsEmpty) || ($structureIsEmpty)){
        $txtError = 'This Session already exists. Please check the spelling and try again';
} else {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //$localite_lib = MinmapDB::getInstance()->get_localite_lib_by_localite_id($_POST['localite_id']);
  //$type_commission_lib = MinmapDB::getInstance()->get_type_commission_lib_by_commission_id($_POST['type_commission_id']);
  //$nature_lib = MinmapDB::getInstance()->get_nature_lib_by_nature_id($_POST['nature_id']);
  
  $comissionLib = MinmapDB::getInstance()->get_lib_by_id(type_commissions, type_commission_lib, type_commission_id, $_POST['type_commission_id']).' de '
  . MinmapDB::getInstance()->get_lib_by_id(natures, lib_nature, nature_id, $_POST['nature_id']).' place aupres de la (du) '
  . MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $_POST['structure_id']);
  //MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_rsPersonnes['structure_id']);
  $comissionSigle = MinmapDB::getInstance()->get_lib_by_id(type_commissions, type_commission_sigle, type_commission_id, $_POST['type_commission_id'])
  . MinmapDB::getInstance()->get_lib_by_id(natures, sigle_nature, nature_id, $_POST['nature_id']).' '
  . MinmapDB::getInstance()->get_lib_by_id(structures, code_structure, structure_id, $_POST['structure_id']);
  //MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_rsPersonnes['structure_id']);
  $insertSQL = sprintf("INSERT INTO commissions (commission_id, localite_id, type_commission_id, nature_id, structure_id, region_id, departement_id, user_id, commission_lib, commission_sigle, commission_parent, montant_cumul, nombre_offre, membre_insert, dateCreation, dateUpdate, display_agescom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['commission_id'], "int"),
                       GetSQLValueString($_POST['localite_id'], "int"),
                       GetSQLValueString($_POST['type_commission_id'], "int"),
                       GetSQLValueString($_POST['nature_id'], "int"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['region_id'], "int"),
					   GetSQLValueString($_POST['departement_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       //GetSQLValueString($_POST['commission_lib'], "text"),$comissionLib
					   GetSQLValueString($comissionLib, "text"),
					   GetSQLValueString($comissionSigle, "text"),
                       GetSQLValueString($_POST['commission_parent'], "int"),
                       GetSQLValueString($_POST['montant_cumul'], "text"),
                       GetSQLValueString($_POST['nombre_offre'], "text"),	
                       GetSQLValueString(0, "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($_POST['display'], "text"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

 MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId,  PageLink, ModificationType, DateCreation, GetSQLValueString(12, "int"), GetSQLValueString('add_commissions.php', "text"), GetSQLValueString('Creation de la commision '.$comissionSigle, "text"), GetSQLValueString($date, "date"));
/* $insertGoTo = "liste_commissions.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));*/
  
/*echo "<script type='".text/javascript."'>
			if (confirm('Créer une nouvelle Commission???')) 
			{".
				  $insertGoTo = "add_commissions.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			else
			{".
				  $insertGoTo = "liste_commissions.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			}
		</script>";
}*/
  
 /*     echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";*/
  //$comID = MinmapDB::getInstance()->get_commission_id_by_sigle($comissionSigle);
  $comID = MinmapDB::getInstance()->get_id_by_lib(commissions, commission_id, commission_sigle, $comissionSigle);
  //$updateGoTo = "detail_membres.php?comID=".$comID;
  $updateGoTo = "../commissions/CommissionListNew.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}