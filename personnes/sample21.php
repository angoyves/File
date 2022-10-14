<?php 
	  require_once('Connections/MyFileConnect.php'); 
?>
<?php
	  require_once('includes/db.php');
	  require('includes/fonction_db.php');
	  require("src/inc/design.inc.php");
	  require("src/inc/biblio.inc.php");
	  require("src/inc/mysql_biblio.inc.php");
	  require("src/inc/db.php");
	  require('includes/MyFonction.php');
?>
<?php

$typeCommission_id = MinmapDB::getInstance()->get_type_id_by_commission_id($_POST['commission_id']);

$showGoTo = $_SERVER["PHP_SELF"];
	if (isset($_SERVER['QUERY_STRING'])) {
		$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
		$showGoTo .= $_SERVER['QUERY_STRING'];
		}
	
 if (!function_exists("GetMontantValue")) {
function GetMontantValue($theCommission_type_id)  
{

  switch ($theCommission_type_id) {
    case 1:
		  $montant = 100000;  
      break;    
    case 3:
		  $montant = 75000;  
      break;   
    case 4:
		  $montant = 75000;  
      break;
    default:
		  $montant = 75000;  
      break;
  }
  return $montant;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$date = date('Y-m-d H:i:s');
$personne_nom = $_POST['personne_nom'];
$structure_id = GetSQLValueString($_POST['structure_id'], "int");
/*
echo $_POST['personne_id'] . " " . $_POST['personne_matricule'] . " " . $_POST['personne_nom'] . " " . $_POST['personne_prenom'] . " " . $_POST['personne_grade'] . " " . $_POST['personne_telephone'] . " " . $_POST['structure_id'] . " " . $_POST['sous_groupe_id'] . " " . $_POST['fonction_id'] . " " . $_POST['domaine_id'] . " " . $_POST['user_id'] . " " . $_POST['personne_date_nais'] . " " . $_POST['type_personne_id'] . " " . $_POST['lieu'] . " " . $_POST['add_commission'] . " " . $date  . " " . $_POST['dateUpdate'] . " " . $_POST['display'];
*/

$localite_id = MinmapDB::getInstance()->get_localite_id_by_commission_id($_GET['comID']);
  $user_id = (MinmapDB::getInstance()->get_user_id_by_name($_GET['uID']));

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") ) {
	//echo "Nom :" . $personne_nom . "  Structure :" . $structure_id; 
	//echo $personne = MinmapDB::getInstance()->get_personne_id_by_name_and_structure(ALONE2, 400);
$insertSQL = sprintf("INSERT INTO personnes (personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade, personne_telephone, structure_id, sous_groupe_id, fonction_id, domaine_id, user_id, personne_date_nais, type_personne_id, localite_id, add_commission, date_creation, dateUpdate, display, personnel_minmap) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['personne_id'], "int"),
                       GetSQLValueString($_POST['personne_matricule'], "text"),
                       GetSQLValueString(strtoupper($_POST['personne_nom']), "text"),
                       GetSQLValueString(ucwords($_POST['personne_prenom']), "text"),
                       GetSQLValueString($_POST['personne_grade'], "text"),
                       GetSQLValueString($_POST['personne_telephone'], "text"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['sous_groupe_id'], "int"),
                       GetSQLValueString($_POST['fonction_id'], "int"),
                       GetSQLValueString($_POST['domaine_id'], "int"),
                       GetSQLValueString($user_id, "int"),
                       GetSQLValueString($_POST['personne_date_nais'], "date"),
                       GetSQLValueString($_POST['type_personne_id'], "int"),
                       GetSQLValueString($localite_id, "int"),
                       GetSQLValueString($_POST['add_commission'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($_POST['display'], "text"),
					   GetSQLValueString($_POST['personnel_minmap'], "text"));

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$Result = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
          
 $comissionSigle = MinmapDB::getInstance()->get_lib_by_id(commissions, commission_sigle, commission_id, $_GET['comID']);
 MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId,  PageLink, ModificationType, DateCreation, GetSQLValueString(12, "int"), GetSQLValueString($showGoTo, "text"), GetSQLValueString('Insertion d\'un membre de la commision '.$comissionSigle, "text"), GetSQLValueString($date, "date"));
  
$personne = MinmapDB::getInstance()->get_personne_id_by_name_and_structure($personne_nom, $structure_id);

if ($personne){
/*$insertSQL1 = sprintf("INSERT INTO membres (commissions_commission_id, fonctions_fonction_id, personnes_personne_id, montant, checboxName, `position`, display, dateCreation) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['comID'], "int"),
                       GetSQLValueString($_POST['fonctions_fonction_id'], "int"),
                       GetSQLValueString($personne, "int"),
                       GetSQLValueString($_POST['montant'], "text"),
                       GetSQLValueString($_POST['checboxName'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString(1, "text"),
                       GetSQLValueString($date, "date"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL1, $MyFileConnect) or die(mysql_error());*/
  
	/*$insertSQL1 = sprintf("INSERT INTO membres (commissions_commission_id, fonctions_fonction_id, personnes_personne_id, montant, checboxName, position, dateCreation, display) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_GET['comID'], "int"),
						   GetSQLValueString(40, "int"),
						   GetSQLValueString($personne, "int"),
						   GetMontantValue( GetSQLValueString($typeCommission_id, "int")),
						   GetSQLValueString("un", "text"),
						   GetSQLValueString(1, "int"),
						   GetSQLValueString($date, "date"),
						   GetSQLValueString(1, "int"));

	$updateSQL2 = sprintf("UPDATE personnes SET add_commission='0', add_rep ='1' WHERE personne_id=%s",
						   GetSQLValueString($personne, "int"));
	
	mysql_select_db($database_MyFileConnect, $MyFileConnect);
	/*$Result1 = mysql_query($insertSQL1, $MyFileConnect) or die(mysql_error());
	$Result2 = mysql_query($updateSQL2, $MyFileConnect) or die(mysql_error());*/
  
  $insertSQL3 = sprintf("INSERT INTO rib (personne_id, personne_matricule, agence_cle, banque_code, agence_code, numero_compte, cle, date_creation) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($personne, "int"),
					   GetSQLValueString(xxxxx-x, "text"),
					   GetSQLValueString(xxxxxxxxxx, "text"),
                       GetSQLValueString(xxxxx, "text"),
                       GetSQLValueString(xxxxx, "text"),
                       GetSQLValueString(xxxxxxxxxxx, "text"),
                       GetSQLValueString(xx, "text"),
                       GetSQLValueString($date, "date"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result3 = mysql_query($insertSQL3, $MyFileConnect) or die(mysql_error());
}
  
  $insertGoTo = "sample16.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  //exit();*/
  echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructure = "SELECT structure_id, structure_lib, code_structure FROM structures WHERE type_structure_id = 4 AND display = '1' ORDER BY structure_lib ASC";
$rsStructure = mysql_query($query_rsStructure, $MyFileConnect) or die(mysql_error());
$row_rsStructure = mysql_fetch_assoc($rsStructure);
$totalRows_rsStructure = mysql_num_rows($rsStructure);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APPLICATION DE GESTION DES INDEMNITES DE SESSION</title>
</head>

<body>
<h1>Insertion d'une personne</h1>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <input type="hidden" name="commissions_commission_id" value="" />
  <input type="hidden" name="fonctions_fonction_id" value="40" />
  <input type="hidden" name="personnes_personne_id" value="" />
  <input type="hidden" name="montant" value="100000" />
  <input type="hidden" name="checboxName" value="" />
  <input type="hidden" name="position" value="5" />
  <input type="hidden" name="dateCreation" value="" />
  <input type="hidden" name="MM_insert2" value="form2" />
<table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nom :</td>
      <td><input name="personne_nom" type="text" value="<?php echo (isset($_GET['txt']) && $_GET['txt'] != '')? $_GET['txt']:$_POST['personne_nom']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Prenom :</td>
      <td><input type="text" name="personne_prenom" value="<?php echo $_POST['personne_prenom']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telephone :</td>
      <td><input type="text" name="personne_telephone" value="<?php echo $_POST['personne_telephone']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Personnel MINMAP</td>
      <td><input name="personnel_minmap" type="checkbox" id="personnel_minmap" value="0" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert enregistrement"/></td>
    </tr>
  </table>
  <input type="hidden" name="personne_id" value="" />
  <input type="hidden" name="personne_matricule" value="xxxxxx-x" />
  <input type="hidden" name="personne_grade" value="" />
  <input type="hidden" name="sous_groupe_id" value="33" />
  <input type="hidden" name="fonction_id" value="35" />
  <input type="hidden" name="domaine_id" value="1" />
  <input type="hidden" name="user_id" value="" />
  <input type="hidden" name="personne_date_nais" value="" />
  <input type="hidden" name="type_personne_id" value="3" />
  <input type="hidden" name="localite_id" value="<?php echo isset($_GET['locID'])?$_GET['locID']:"79"; ?>" />
  <input type="hidden" name="add_commission" value="1" />
  <input type="hidden" name="date_creation" value="" />
  <input type="hidden" name="dateUpdate" value="" />
  <input type="hidden" name="display" value="1" />
  <input name="structure_id" type="hidden" id="structure_id" value="342" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsStructure);
?>
