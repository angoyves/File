<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require('../includes/db.php');
	  require('../includes/fonction_db.php');
	  require('../includes/DW_Fonctions.php');
	  require('../includes/controler.php');
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    if (isset($_POST['localite_id']) && $_POST['localite_id'] == 79){
  $insertSQL = sprintf("INSERT INTO structures (structure_id, code_structure, structure_lib, type_structure_id, localite_id, minister, date_creation, display_agescom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['code_structure'], "text"),
                       GetSQLValueString($_POST['structure_lib'], "text"),
                       GetSQLValueString($_POST['type_structure_id'], "int"),
                       GetSQLValueString($_POST['localite_id'], "int"),
                       GetSQLValueString($_POST['minister'], "text"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['display_agescom'], "text"));
     } else { 
  $insertSQL = sprintf("INSERT INTO structures (structure_id, code_structure, structure_lib, type_structure_id, localite_id, minister, date_creation, display_agescom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['code_structure'], "text"),
                       GetSQLValueString($_POST['structure_lib'], "text"),
                       GetSQLValueString($_POST['type_structure_id'], "int"),
                       GetSQLValueString($_POST['localite_id'], "int"),
                       GetSQLValueString($_POST['minister'], "text"),
                       GetSQLValueString($_POST['date_creation'], "date"),
                       GetSQLValueString($_POST['display_agescom'], "text"));
	 }

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

  /*$insertGoTo = "list_structures.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));*/
  echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeStructures = "SELECT type_structure_id, type_structure_lib FROM type_structure WHERE display = '1' ORDER BY type_structure_lib ASC";
$rsTypeStructures = mysql_query($query_rsTypeStructures, $MyFileConnect) or die(mysql_error());
$row_rsTypeStructures = mysql_fetch_assoc($rsTypeStructures);
$totalRows_rsTypeStructures = mysql_num_rows($rsTypeStructures);

$colname_rsSelLocalites = "-1";
if (isset($_GET['depID'])) {
  $colname_rsSelLocalites = (get_magic_quotes_gpc()) ? $_GET['depID'] : addslashes($_GET['depID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsSelLocalites = sprintf("SELECT localite_id, localite_lib FROM localites WHERE departement_id = %s AND display = 1 ORDER BY localite_lib ASC", $colname_rsSelLocalites);
$rsSelLocalites = mysql_query($query_rsSelLocalites, $MyFileConnect) or die(mysql_error());
$row_rsSelLocalites = mysql_fetch_assoc($rsSelLocalites);
$totalRows_rsSelLocalites = mysql_num_rows($rsSelLocalites);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

$colname_rsDepartements = "-1";
if (isset($_GET['regID'])) {
  $colname_rsDepartements = $_GET['regID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsDepartements = sprintf("SELECT * FROM departements WHERE regions_region_id = %s AND display = 1 ORDER BY departement_lib ASC", $colname_rsDepartements);
$rsDepartements = mysql_query($query_rsDepartements, $MyFileConnect) or die(mysql_error());
$row_rsDepartements = mysql_fetch_assoc($rsDepartements);
$totalRows_rsDepartements = mysql_num_rows($rsDepartements);

$colname_rsLocalites = "-1";
if (isset($_GET['depID'])) {
  $colname_rsLocalites = $_GET['depID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = sprintf("SELECT localite_id, localite_lib FROM localites WHERE departement_id = %s AND display = 1 ORDER BY localite_lib ASC", $colname_rsLocalites);
$rsLocalites = mysql_query($query_rsLocalites, $MyFileConnect) or die(mysql_error());
$row_rsLocalites = mysql_fetch_assoc($rsLocalites);
$totalRows_rsLocalites = mysql_num_rows($rsLocalites);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<style type="text/css">
<!--
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
-->
</style>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Code structure:</td>
      <td><input type="text" name="code_structure" value="" size="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Libelle Structure:</td>
      <td><textarea name="structure_lib" cols="32"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Type structure:</td>
      <td><select name="type_structure_id">
        <option value=""  <?php if (!(strcmp("", 4))) {echo "selected=\"selected\"";} ?>>Select::</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsTypeStructures['type_structure_id']?>"<?php if (!(strcmp($row_rsTypeStructures['type_structure_id'], 4))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTypeStructures['type_structure_lib']?></option>
        <?php
} while ($row_rsTypeStructures = mysql_fetch_assoc($rsTypeStructures));
  $rows = mysql_num_rows($rsTypeStructures);
  if($rows > 0) {
      mysql_data_seek($rsTypeStructures, 0);
	  $row_rsTypeStructures = mysql_fetch_assoc($rsTypeStructures);
  }
?>
      </select>
      </td>
    </tr>
    <?php if (isset($_GET['regID']) && $_GET['regID'] == "13"){ ?>
    <input type="hidden" name="localite_id" value="79" />
    <?php } else { ?>
    <tr valign="baseline">
      <td align="right" nowrap>Localite:</td>
      <td><select name="localite_id2" type="hidden" >
        <option value=""  <?php if (!(strcmp("", $row_rsSelLocalites['localite_id']))) {echo "selected=\"selected\"";} ?>>Select::</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rsSelLocalites['localite_id']?>"<?php if (!(strcmp($_GET['locID'], $row_rsSelLocalites['localite_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsSelLocalites['localite_lib']?></option>
        <?php
} while ($row_rsSelLocalites = mysql_fetch_assoc($rsSelLocalites));
  $rows = mysql_num_rows($rsSelLocalites);
  if($rows > 0) {
      mysql_data_seek($rsSelLocalites, 0);
	  $row_rsSelLocalites = mysql_fetch_assoc($rsSelLocalites);
  }
?>
      </select>
      </td>
    </tr>
    <tr valign="baseline" class="style1">
      <td align="right" nowrap="nowrap" class="style9">Region:</td>
      <td valign="middle" class="style5">
      <select name="menu1" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_structures.php" <?php if (!(strcmp("add_structures.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php
		do {  
		?>
        <option value="<?php echo "add_structures.php?tlocID=2&typID=".$_GET['typID']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
        <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
      </select>
        <?php           
			$showGoTo = "add_regions.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <?php //if (isset($_GET['regID'])){ ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "150"); ?>"> <img src="../images/img/b_snewtbl.png" width="16" height="16" /></a>
      <?php //} ?></td>
    </tr>
    <tr valign="baseline" class="style1">
      <td align="right" nowrap="nowrap" class="style9">Departement:</td>
      <td valign="middle" class="style5">
      <select name="menu2" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_structures.php" <?php if (!(strcmp("add_structures.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
        <?php do {  ?>
        <option value="<?php echo "add_structures.php?tlocID=3&typID=".$_GET['typID']."&regID=".$_REQUEST['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?> </option>
        <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
      </select>
        <?php           
			$showGoTo = "add_localite.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <?php if (isset($_GET['regID'])){ ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"> 
        <img src="../images/img/b_snewtbl.png" width="16" height="16" /></a>
        <?php } ?></td>
    </tr>
    <tr valign="baseline" class="style1">
      <td align="right" nowrap="nowrap" class="style9">Localite:</td>
      <td valign="middle" class="style5"><select name="localite_id3" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_structures.php" <?php if (!(strcmp("add_structures.php", $_GET['locID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php do {  ?>
        <option value="<?php echo "add_structures.php?typID=".$_GET['typID']."&regID=".$_REQUEST["regID"]."&depID=".$_REQUEST["depID"]."&locID=".$row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], $_GET['locID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']) ?></option>
        <?php
		} while ($row_rsLocalites = mysql_fetch_assoc($rsLocalites));
		  $rows = mysql_num_rows($rsLocalites);
		  if($rows > 0) {
			  mysql_data_seek($rsLocalites, 0);
			  $row_rsLocalites = mysql_fetch_assoc($rsLocalites);
		}
		?>
      </select>
        <?php           
			$showGoTo = "add_localite.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <?php if (isset($_GET['depID'])){ ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "750"); ?>"><img src="../images/img/b_snewtbl.png" width="16" height="16" />
        <?php } ?>
      </a></td>
    </tr>
    <?php } ?>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="hidden" name="minister" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="structure_id" value="">
  <input type="hidden" name="date_creation" value="">
  <input type="hidden" name="localite_id" value="<?php echo (isset($_REQUEST['locID'])?$_REQUEST['locID']:79) ?>">
  <input type="hidden" name="display" value="1">
  <input type="hidden" name="display_agescom" value="0">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsTypeStructures);

mysql_free_result($rsSelLocalites);

mysql_free_result($rsRegion);

mysql_free_result($rsDepartements);

mysql_free_result($rsLocalites);
?>
