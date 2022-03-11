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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE appurements SET commission_id=%s, num_virement=%s, rib_beneficiaire=%s, nom_beneficiaire=%s, ref_dossier=%s, motif=%s, montant=%s, periode_debut=%s, periode_fin=%s, annee=%s, display=%s WHERE appurement_id=%s",
                       GetSQLValueString($_POST['commission_id'], "int"),
                       GetSQLValueString($_POST['num_virement'], "int"),
                       GetSQLValueString($_POST['rib_beneficiaire'], "text"),
                       GetSQLValueString($_POST['nom_beneficiaire'], "text"),
                       GetSQLValueString($_POST['ref_dossier'], "text"),
                       GetSQLValueString($_POST['motif'], "text"),
                       GetSQLValueString($_POST['montant'], "int"),
                       GetSQLValueString($_POST['periode_debut'], "text"),
                       GetSQLValueString($_POST['periode_fin'], "text"),
                       GetSQLValueString($_POST['annee'], "text"),
                       GetSQLValueString($_POST['display'], "text"),
                       GetSQLValueString($_POST['appurement_id'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());

  /*$updateGoTo = "show_all_ov.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));*/
      echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";
}

$colname_rsUpdOV = "-1";
if (isset($_GET['recordID'])) {
  $colname_rsUpdOV = $_GET['recordID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsUpdOV = sprintf("SELECT * FROM appurements WHERE appurement_id = %s", GetSQLValueString($colname_rsUpdOV, "int"));
$rsUpdOV = mysql_query($query_rsUpdOV, $MyFileConnect) or die(mysql_error());
$row_rsUpdOV = mysql_fetch_assoc($rsUpdOV);
$totalRows_rsUpdOV = mysql_num_rows($rsUpdOV);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AGESCOM::</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Commission ID:</td>
      <td><input type="text" name="commission_id" value="<?php echo htmlentities($row_rsUpdOV['commission_id'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rib beneficiaire:</td>
      <td><input type="text" name="rib_beneficiaire" value="<?php echo htmlentities($row_rsUpdOV['rib_beneficiaire'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nom beneficiaire:</td>
      <td><input type="text" name="nom_beneficiaire" value="<?php echo htmlentities($row_rsUpdOV['nom_beneficiaire'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Motif:</td>
      <td><input type="text" name="motif" value="<?php echo $row_rsUpdOV['motif']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Montant:</td>
      <td><input type="text" name="montant" value="<?php echo htmlentities($row_rsUpdOV['montant'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Mettre &agrave; jour l'enregistrement" /></td>
    </tr>
  </table>
  <input type="hidden" name="appurement_id" value="<?php echo $row_rsUpdOV['appurement_id']; ?>" />
  <input type="hidden" name="num_virement" value="<?php echo htmlentities($row_rsUpdOV['num_virement'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="ref_dossier" value="<?php echo htmlentities($row_rsUpdOV['ref_dossier'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="periode_debut" value="<?php echo htmlentities($row_rsUpdOV['periode_debut'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="periode_fin" value="<?php echo htmlentities($row_rsUpdOV['periode_fin'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="annee" value="<?php echo htmlentities($row_rsUpdOV['annee'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="display" value="<?php echo htmlentities($row_rsUpdOV['display'], ENT_COMPAT, 'utf-8'); ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="appurement_id" value="<?php echo $row_rsUpdOV['appurement_id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsUpdOV);
?>
