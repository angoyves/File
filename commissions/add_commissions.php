<?php require_once('Connections/MyFileConnect.php'); ?>
<?php
	  require('includes/db.php');
	  require('includes/fonction_db.php');
	  require('includes/DW_Fonctions.php');
	  require('includes/controler.php');
	  require("inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("src/inc/mysql_biblio.inc.php");
?>
<?php 

/* if (isset($_GET['typID']) && $_GET['typID']=10){
  	$updateGoTo = "add_comites.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $updateGoTo));
  } else {*/

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
  $updateGoTo = "detail_membres.php?comID=".$comID;
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}

$colname_rsLocalites = "-1";
if (isset($_GET['depID'])) {
  $colname_rsLocalites = (get_magic_quotes_gpc()) ? $_GET['depID'] : addslashes($_GET['depID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = sprintf("SELECT localite_id, localite_lib FROM localites WHERE departement_id = %s AND display = 1 ORDER BY localite_lib ASC", $colname_rsLocalites);
$rsLocalites = mysql_query($query_rsLocalites, $MyFileConnect) or die(mysql_error());
$row_rsLocalites = mysql_fetch_assoc($rsLocalites);
$totalRows_rsLocalites = mysql_num_rows($rsLocalites);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeCommission = "SELECT type_commission_id, type_commission_lib FROM type_commissions WHERE display = '1' ORDER BY type_commission_lib ASC";
$rsTypeCommission = mysql_query($query_rsTypeCommission, $MyFileConnect) or die(mysql_error());
$row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
$totalRows_rsTypeCommission = mysql_num_rows($rsTypeCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsNatureCommission = "SELECT nature_id, lib_nature FROM natures WHERE display = '1' ORDER BY lib_nature ASC";
$rsNatureCommission = mysql_query($query_rsNatureCommission, $MyFileConnect) or die(mysql_error());
$row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
$totalRows_rsNatureCommission = mysql_num_rows($rsNatureCommission);

/*mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = "SELECT structure_id, structure_lib FROM structures WHERE type_structure_id =4 AND display = '1' ORDER BY structure_lib ASC";
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);*/


//$colname_rsStructures = isset($_REQUEST["locID"])?$_REQUEST["locID"]:"79";
$colname_rsStructures = "79";
if (isset($_GET['locID'])) {
  $colname_rsStructures = (get_magic_quotes_gpc()) ? $_GET['locID'] : addslashes($_GET['locID']);
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = sprintf("SELECT structure_id, structure_lib, code_structure FROM structures WHERE localite_id = %s AND display_agescom = 1 ORDER BY code_structure ASC", $colname_rsStructures);
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

$colname_rsDepartements = "-1";
if (isset($_GET['regID'])) {
  $colname_rsDepartements = (get_magic_quotes_gpc()) ? $_GET['regID'] : addslashes($_GET['regID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsDepartements = sprintf("SELECT * FROM departements WHERE regions_region_id = %s AND display = 1 ORDER BY departement_lib ASC", $colname_rsDepartements);
$rsDepartements = mysql_query($query_rsDepartements, $MyFileConnect) or die(mysql_error());
$row_rsDepartements = mysql_fetch_assoc($rsDepartements);
$totalRows_rsDepartements = mysql_num_rows($rsDepartements);
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>::Application de gestion des CPM::</title>
<style type="text/css">
<!--
.style1 {font-family: "Arial Narrow"}
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
.style9 {font-family: "Arial Narrow"; font-size: 16; }
.style10 {font-size: 16}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body class="style1">
<p><strong>AJOUTER UNE COMMISSION DE PASSATION DES MARCHES </strong></p>
<p><br />
</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" class="style1" id="form1">
  <table align="center" class="style1">
<tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Type Commission:</td>
      <td class="style1"><select name="type_commission" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value=""  <?php if (!(strcmp("", 7))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php
do {  
?><option value="<?php echo "add_commissions.php?typID=".$row_rsTypeCommission['type_commission_id']?>"<?php if (!(strcmp($row_rsTypeCommission['type_commission_id'], $_GET['typID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsTypeCommission['type_commission_lib']) ?></option>
          <?php
} while ($row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission));
  $rows = mysql_num_rows($rsTypeCommission);
  if($rows > 0) {
      mysql_data_seek($rsTypeCommission, 0);
	  $row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
  }
?>
      </select>
        <span class="style5">
        <?php           
			$showGoTo = "add_types.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "250"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($typecommissionIsEmpty) { ?>
</a></span>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
      <?php } ?></td>
    </tr>
    
    
    <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3 || $_GET['typID'] == 4 || $_GET['typID'] == 5 || $_GET['typID'] == 7 || $_GET['typID'] == 8)){ ?>    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Region:</td>
      <td valign="middle" class="style5"><select name="menu1" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_commissions.php" <?php if (!(strcmp("add_commissions.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php
		do {  
		?>
				<option value="<?php echo "add_commissions.php?tlocID=2&typID=".$_GET['typID']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
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
        <a href="#" onclick="<?php popup($showGoTo, "710", "150"); ?>">
        <img src="images/img/b_snewtbl.png" width="16" height="16" /></a>
        <?php //} ?>
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($regionIsEmpty) { ?>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
      <?php } ?></td>
    </tr>
    <?php } ?>
    <?php if (isset($_GET['typID']) && ($_GET['typID'] == 4 || $_GET['typID'] == 5 || $_GET['typID'] == 7 || $_GET['typID'] == 8)){ ?>   
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Departement:</td>
      <td valign="middle" class="style5">
      <select name="menu2" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_commissions.php" <?php if (!(strcmp("add_commissions.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
        <?php do {  ?>
            <option value="<?php echo "add_commissions.php?tlocID=3&typID=".$_GET['typID']."&regID=".$_REQUEST['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?>
            </option>
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
			} }
	 	  ?>
        <?php if (isset($_GET['regID'])){ ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>">
        <img src="images/img/b_snewtbl.png" width="16" height="16" /></a>
        <?php } ?>
        
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
        if ($departementIsEmpty) { ?>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le departement, SVP!</div>
        <?php } ?>
      </td>        
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Localite:</td>
      <td valign="middle" class="style5">
      <select name="localite_id" class="style1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="add_commissions.php" <?php if (!(strcmp("add_commissions.php", $_GET['locID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php do {  ?>
		<option value="<?php echo "add_commissions.php?tlocID=".$_GET['tlocID']."&typID=".$_GET['typID']."&regID=".$_REQUEST["regID"]."&depID=".$_REQUEST["depID"]."&locID=".$row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], $_GET['locID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']) ?></option>
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
        <a href="#" onclick="<?php popup($showGoTo, "710", "750"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
        <?php } ?>
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($localiteIsEmpty) { ?> </a>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la localite de la Commission, SVP!</div>
	  </td>
    </tr>
    
    <?php } ?>
    
    <?php //} ?>
    
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Nature Commission:</td>
      <td class="style1"><select name="nature_id" class="style1">
        <option value=""  <?php if (!(strcmp("", 9))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php
do {  
?><option value="<?php echo $row_rsNatureCommission['nature_id']?>"<?php if (!(strcmp($row_rsNatureCommission['nature_id'], "9"))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsNatureCommission['lib_nature']) ?></option>
          <?php
} while ($row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission));
  $rows = mysql_num_rows($rsNatureCommission);
  if($rows > 0) {
      mysql_data_seek($rsNatureCommission, 0);
	  $row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
  }
?>
      </select>
        <span class="style5">
        <?php           
			$showGoTo = "add_natures.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "150"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($natureIsEmpty) { ?>
</a></span>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la nature de la Commission, SVP!</div>
        <?php } ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">Structure de rattachement:</td>
      <td class="style1"><select name="structure_id" class="style1">
        <option value=""  <?php if (!(strcmp("", 894))) {echo "selected=\"selected\"";} ?>>Select...</option>
        <?php
do {  
?><option value="<?php echo $row_rsStructures['structure_id']?>"<?php if (!(strcmp($row_rsStructures['structure_id'], 894))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsStructures['code_structure']) ?></option>
          <?php
} while ($row_rsStructures = mysql_fetch_assoc($rsStructures));
  $rows = mysql_num_rows($rsStructures);
  if($rows > 0) {
      mysql_data_seek($rsStructures, 0);
	  $row_rsStructures = mysql_fetch_assoc($rsStructures);
  }
?>
      </select>
        <span class="style5">
        <?php           
			//$showGoTo = "add_structures.php";
			$reg_id = isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
			$dep_id = isset($_REQUEST['depID'])?$_REQUEST['depID']:"10";
			$loc_id = isset($_REQUEST['locID'])?$_REQUEST['locID']:"79";
			$showGoTo = "showstructure.php?regID=". isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup('sample30.php?regID='.$reg_id.'&depID='.$dep_id.'&locID='.$loc_id, "710", "750"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" /></a>
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($structureIsEmpty) { ?>
        </span>
        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la structure de rattachement, SVP!</div>
        <?php } ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" class="style9">&nbsp;</td>
      <td class="style1"><input name="submit" type="submit" value="Ins&eacute;rer un enregistrement" onClick="return confirm('Créer la commission ?')";/></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap" class="style9">&nbsp;</td>
      <td class="style1"><input type="hidden" name="commission_lib" cols="32" rows="5"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><span class="style10"></span></td>
      <td class="style1"><input name="display" type="hidden" value="1" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap"><span class="style10">
        <?php if (isset($_GET['valid']) && $_GET['valid'] == 'ok'){ ?>
        <span class="succes">Commission insérée avec succès!!!</span>
        <?php } ?>
</span>
		<?php if (!$commissionIsUnique) { ?>
		<div class="error">
		<img src="../AGISimages/img/s_error.png" alt="" width="16" height="16" align="absmiddle" />
        This Commission already exists. Please check the spelling and try again
        </div> 
		<?php } ?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="type_commission_id" value="<?php echo isset($_REQUEST["typID"])?$_REQUEST["typID"]:"" ?>" />
  <input type="hidden" name="commission_id" value="" />
  <input type="hidden" name="user_id" value="" />
  <input type="hidden" name="commission_parent" value="" />
  <input type="hidden" name="montant_cumul" value="" />
  <input type="hidden" name="nombre_offre" value="" />
  <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3)){ ?>
  <input type="hidden" name="region_id" value="<?php echo $_REQUEST["regID"]; ?>" />
  <input type="hidden" name="departement_id" value="10" />
  <input type="hidden" name="localite_id" value="79" />
  <?php } else if (isset($_GET['typID']) && ($_GET['typID'] == 4 || $_GET['typID'] == 5 || $_GET['typID'] == 7 || $_GET['typID'] == 8)){ ?>
    <input type="hidden" name="region_id" value="<?php echo $_REQUEST["regID"]; ?>" />
  <input type="hidden" name="departement_id" value="<?php echo $_REQUEST["depID"]; ?>" />
  <input type="hidden" name="localite_id" value="<?php echo $_REQUEST["locID"]; ?>" />
  <?php } else { ?>
  <input type="hidden" name="region_id" value="13" />
  <input type="hidden" name="departement_id" value="10" />
  <input type="hidden" name="localite_id" value="79" />
  <?php } ?>  
  <input type="hidden" name="membre_insert" value="" />
  <input type="hidden" name="dateCreation" value="" />
  <input type="hidden" name="dateUpdate" value="" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p class="style1">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsDepartements);

mysql_free_result($rsStructures);

mysql_free_result($rsLocalites);
?>