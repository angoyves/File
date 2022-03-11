<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require('../inc/db.php');
	  require('../includes/db.php');
	  require("../inc/biblio.inc.php");
	  //require("../include/logfile.php");
	  require("../src/inc/mysql_biblio.inc.php");
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsPersonnes = 20;
$pageNum_rsPersonnes = 0;
if (isset($_GET['pageNum_rsPersonnes'])) {
  $pageNum_rsPersonnes = $_GET['pageNum_rsPersonnes'];
}
$startRow_rsPersonnes = $pageNum_rsPersonnes * $maxRows_rsPersonnes;

$col_rsPersonnes = "-1";
if (isset($_REQUEST['txtSearch'])) {
  $col_rsPersonnes = $_REQUEST['txtSearch'];
}

$colname_rsStructure = "-1";
if (isset($row_rsPersonnes['structure_id'])) {
  $colname_rsStructure = $row_rsPersonnes['structure_id'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructure = sprintf("SELECT structure_lib FROM structures WHERE structure_id = %s", GetSQLValueString($colname_rsStructure, "int"));
$rsStructure = mysql_query($query_rsStructure, $MyFileConnect) or die(mysql_error());
$row_rsStructure = mysql_fetch_assoc($rsStructure);
$totalRows_rsStructure = mysql_num_rows($rsStructure);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsPersonnes = sprintf("SELECT * FROM personnes WHERE (personne_id LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR personne_matricule LIKE %s) AND display = 1 ORDER BY personne_nom ASC", GetSQLValueString("%" . $col_rsPersonnes . "%", "text"),GetSQLValueString("%" . $col_rsPersonnes . "%", "text"),GetSQLValueString("%" . $col_rsPersonnes . "%", "text"),GetSQLValueString("%" . $col_rsPersonnes . "%", "text"));
$rsPersonnes = mysql_query($query_rsPersonnes, $MyFileConnect) or die(mysql_error());
$row_rsPersonnes = mysql_fetch_assoc($rsPersonnes);
$totalRows_rsPersonnes = mysql_num_rows($rsPersonnes);

/*$queryString_rsPersonnes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsPersonnes") == false && 
        stristr($param, "totalRows_rsPersonnes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsPersonnes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsPersonnes = sprintf("&totalRows_rsPersonnes=%d%s", $totalRows_rsPersonnes, $queryString_rsPersonnes);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AGESCOM::</title>
<style type="text/css">
<!--
.style1 {font-family: "Arial Narrow"}
.style4 {font-family: "Arial Narrow"; color: #FFFFFF; }
-->
</style>
</head>

<body onload="document.getElementById('txtSearch').focus()">
<table align="center">
<tr>
    <td colspan="5">
    <form action="" method="post" name="form1" class="style1" id="form1">
      Rechercher :
      <input type="text" name="txtSearch" id="txtSearch" />
      <input type="submit" name="button" id="button" value="Rechercher" />
      <?php           
			$showGoTo = "ins_persons.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
            <a href="#" onclick="<?php popup($showGoTo, "710", "450"); ?>"><img src="../images/img/b_snewtbl.png" width="16" height="16" />Personnel MINMAP </a>
           <?php           
			$showGoTo = "sample21.php?txt=".$_POST['txtSearch'];
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "450"); ?>"><img src="../images/img/b_snewtbl.png" width="16" height="16" />Expert</a>
    </form></td>
  </tr>
  <tr bgcolor="#220022">
    <th bgcolor="#220022"><span class="style4">Matricule</span></th>
    <th><span class="style4">Noms &amp; Prenoms</span></th>
    <th><span class="style4">Structure</span></th>
    <th><span class="style4">Ajouter+</span></th>
  </tr>
  <?php $counter=0; do  { $counter++; ?>
	<tr bgcolor="<?php echo alter_color($counter, "#eee", "#FFF"); ?>">
      <td nowrap="nowrap"><span class="style1"><a href="../delete_doublon.php?txtSearch=<?php echo substr($row_rsPersonnes['personne_nom'],0,6) ?>">Supprimer les doublons</a>&nbsp; </span></td>
      <td><span class="style1"><?php echo strtoupper($row_rsPersonnes['personne_nom'].' '.$row_rsPersonnes['personne_prenom']); ?>&nbsp; </span></td>
      <td>
	    <span class="style1"><?php //echo MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_rsPersonnes['structure_id']); ?><?php echo $row_rsStructure['structure_lib']; ?></span></td>
      <td><span class="style1"><a href="../membres/addMembres.php?perID=<?php echo $row_rsPersonnes['personne_id']; ?>&amp;comID=<?php echo $_GET['comID'] ?>">Choisir++</a>&nbsp;</span></td>
  </tr>
    <?php } while ($row_rsPersonnes = mysql_fetch_assoc($rsPersonnes)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_rsPersonnes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsPersonnes=%d%s", $currentPage, 0, $queryString_rsPersonnes); ?>">Premier</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsPersonnes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rsPersonnes=%d%s", $currentPage, max(0, $pageNum_rsPersonnes - 1), $queryString_rsPersonnes); ?>">Précédent</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_rsPersonnes < $totalPages_rsPersonnes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsPersonnes=%d%s", $currentPage, min($totalPages_rsPersonnes, $pageNum_rsPersonnes + 1), $queryString_rsPersonnes); ?>">Suivant</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_rsPersonnes < $totalPages_rsPersonnes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rsPersonnes=%d%s", $currentPage, $totalPages_rsPersonnes, $queryString_rsPersonnes); ?>">Dernier</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Enregistrements <?php echo ($startRow_rsPersonnes + 1) ?> à <?php echo min($startRow_rsPersonnes + $maxRows_rsPersonnes, $totalRows_rsPersonnes) ?> sur 
</body>
</html>
<?php
mysql_free_result($rsStructure);

mysql_free_result($rsPersonnes);
?>
