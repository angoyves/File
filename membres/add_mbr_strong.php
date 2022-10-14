<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require('../inc/db.php');
	  require('../includes/db.php');
	  require('../includes2/db.php');
	  require("../inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  require("../includes/MyFonction.php");
	  require("../includes/controler.php");
	  require("../includes/DW_Fonctions.php");
?>
<?php

$colname_rsPersonnes = "-1";
if (isset($_GET['perID'])) {
  $colname_rsPersonnes = $_GET['perID'];
}
$colname_rsCommissions = "-1";
if (isset($_GET['comID'])) {
  $colname_rsCommissions = $_GET['comID'];
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && (!$fonctionIsEmpty) ) {

//$user_id = (MinmapDB::getInstance()->get_user_id_by_name($_POST['user_name']));
//$credential = (MinmapDB::getInstance()->verify_membres_by_person_id($_GET['persID']));
//if (isset($_POST["add_commission_agescom"]) && ($_POST["add_commission_agescom"] == 0)){
	//if ($credential<>1) {
$insertSQL = sprintf("INSERT INTO membres (commissions_commission_id, fonctions_fonction_id, personnes_personne_id, montant, checboxName, `position`, display_agescom, dateCreation, dateUpdate, user_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['commissions_commission_id'], "int"),
                       GetSQLValueString($_POST['fonction_id'], "int"),
                       GetSQLValueString($_POST['personnes_personne_id'], "int"),
                       GetSQLValueString($_POST['montant'], "text"),
                       GetSQLValueString($_POST['checboxName'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['display'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($user_id, "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
	//}
  
 $updateSQL = sprintf("UPDATE commissions SET membre_insert=%s, dateUpdate=%s, user_id=%s WHERE commission_id=%s",
                       GetSQLValueString(1, "text"),
					   GetSQLValueString($date, "date"),
					   GetSQLValueString($user_id, "int"),
                       GetSQLValueString($_POST['commissions_commission_id'], "int"));
 
  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
  $structure_id = (isset($row_rsPersonnes['structure_id']) && $row_rsPersonnes['structure_id']=="342")?GetStructureID($_POST['fonction_id']):$row_rsPersonnes['structure_id'];
  $updateSQL2 = sprintf("UPDATE personnes SET add_commission_agescom=%s, structure_id = %s, dateUpdate=%s, user_id=%s WHERE personne_id=%s",
                       GetSQLValueString(1, "text"),
					   GetSQLValueString($structure_id, "int"),
					   GetSQLValueString($date, "date"),
					   GetSQLValueString($user_id, "int"),
                       GetSQLValueString($colname_rsPersonnes, "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result2 = mysql_query($updateSQL2, $MyFileConnect) or die(mysql_error());

  /*$insertGoTo = "detail_commission.php?comID=".$colname2_rsMembres;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));*/
       echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";
} /*else {
  //echo '<body onLoad="alert('Client introuvable...')">';
  //echo '<meta http-equiv="refresh" content="0;URL=show_commissions.php?comID='.$colname_rsCommissions.'>';
  $message = 'Impossible d\'ajouter ce membre, il est dejà membre dans une autre Commission';
  /*$insertGoTo = "add_membres.php?perID=".$_GET['perID']."&comID=".$_GET[comID];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}*/


mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsPersonnes = sprintf("SELECT personne_nom, personne_prenom, add_commission_agescom, structure_id FROM personnes WHERE personne_id = %s", $colname_rsPersonnes);
$rsPersonnes = mysql_query($query_rsPersonnes, $MyFileConnect) or die(mysql_error());
$row_rsPersonnes = mysql_fetch_assoc($rsPersonnes);
$totalRows_rsPersonnes = mysql_num_rows($rsPersonnes);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsCommissions = sprintf("SELECT commission_lib FROM commissions WHERE commission_id = %s", $colname_rsCommissions);
$rsCommissions = mysql_query($query_rsCommissions, $MyFileConnect) or die(mysql_error());
$row_rsCommissions = mysql_fetch_assoc($rsCommissions);
$totalRows_rsCommissions = mysql_num_rows($rsCommissions);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsFonctions = "SELECT fonction_id, fonction_lib FROM fonctions WHERE groupe_fonction_id = 3 AND display = '1' ORDER BY fonction_lib ASC";
$rsFonctions = mysql_query($query_rsFonctions, $MyFileConnect) or die(mysql_error());
$row_rsFonctions = mysql_fetch_assoc($rsFonctions);
$totalRows_rsFonctions = mysql_num_rows($rsFonctions);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsSelMembres = sprintf("SELECT commissions_commission_id, fonctions_fonction_id, commission_lib, fonction_lib FROM membres, commissions, fonctions, personnes WHERE membres.commissions_commission_id = commissions.commission_id AND membres.fonctions_fonction_id = fonctions.fonction_id AND personnes.personne_id = membres.personnes_personne_id AND personnes.add_commission_agescom = 1 AND personnes_personne_id = %s AND membres.display = 1 AND commissions.display_agescom = 1", $colname_rsPersonnes);
$rsSelMembres = mysql_query($query_rsSelMembres, $MyFileConnect) or die(mysql_error());
$row_rsSelMembres = mysql_fetch_assoc($rsSelMembres);
$totalRows_rsSelMembres = mysql_num_rows($rsSelMembres);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: "Arial Narrow";
	font-size: 18px;
	font-weight: bold;
}
.style3 {font-family: "Arial Narrow"}
.style8 {font-family: "Arial Narrow"; color: #FFFFFF; }
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
-->
</style>
</head>

<body>
  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td colspan="2" align="left"><span class="style1 style3"><?php echo strtoupper($row_rsCommissions['commission_lib']); ?></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right"><span class="style3"></span></td>
        <td><span class="style3"></span></td>
      </tr>
      <tr valign="baseline">
        <th align="right" nowrap><span class="style3 style3">Noms et Prenoms: </span></th>
        <td><span class="style3 style3"><?php echo strtoupper($row_rsPersonnes['personne_nom'].' '.$row_rsPersonnes['personne_prenom']); ?></span></td>
      </tr>
      <tr valign="baseline">
        <th align="right" nowrap><span class="style3 style3">Fonctions:</span></th>
        <td><span class="style3 style3">
          <select name="fonction_id">
            <option value="" >Select::</option>
            <?php
do {  
?>
            <option value="<?php echo $row_rsFonctions['fonction_id']?>"><?php echo strtoupper($row_rsFonctions['fonction_lib']); ?></option>
            <?php
} while ($row_rsFonctions = mysql_fetch_assoc($rsFonctions));
  $rows = mysql_num_rows($rsFonctions);
  if($rows > 0) {
      mysql_data_seek($rsFonctions, 0);
	  $row_rsFonctions = mysql_fetch_assoc($rsFonctions);
  }
?>
          </select>
         <?php           
			$showGoTo = "add_fonctions.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" /></a>&nbsp;
        <span class="style5"><a href="#" onclick="<?php popup($showGoTo, "710", "250"); ?>">
        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($fonctionIsEmpty) { ?>
        </a></span> </span>
          <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la fonction du membre, SVP!</div>
        <?php } ?></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap><span class="style3"></span></td>
        <td><input type="submit" value="Inserer  Enregistrement"></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap>&nbsp;</td>
        <td><?php echo $message ?>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="commissions_commission_id" value="<?php echo $colname_rsCommissions ?>">
    <input type="hidden" name="personnes_personne_id" value="<?php echo $colname_rsPersonnes  ?>">
    <input type="hidden" name="montant" value="">
    <input type="hidden" name="checboxName" value="">
    <input type="hidden" name="position" value="1">
    <input type="hidden" name="display" value="1">
    <input type="hidden" name="dateCreation" value="">
    <input type="hidden" name="dateUpdate" value="">
    <input type="hidden" name="add_commission_agescom" value="<?php echo $row_rsPersonnes['add_commission_agescom']; ?>">
    <input type="hidden" name="structure_id" value="<?php echo $row_rsPersonnes['structure_id']; ?>">
    <input type="hidden" name="user_id" value="">
  <input type="hidden" name="MM_insert" value="form1">
      </form>
  <p class="style3">  
  <?php if ($totalRows_rsSelMembres > 0) { // Show if recordset not empty ?>
<p class="style3">Listes des Commission du personnel
  <table align="center">
    <tr bgcolor="#004080">
      <th class="style8">N&deg;</th>
      <th class="style8">Commissions</th>
      <th class="style8">Fonctions</th>
    </tr>
    <?php $counter=0;  ?>
    <?php  do  {  ?>
    <?php $counter++; ?>
	<tr bgcolor="<?php echo alter_color($counter, "#eee", "#FFF"); ?>">
        <td class="style3"><?php echo $counter ?>&nbsp;</td>
		<?php           
			$showGoTo = "detail_membres.php?comID=".$row_rsSelMembres['commissions_commission_id'];
			/*if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}*/
	 	  ?>
        <td><a href="#" class="style3" onclick="<?php popup($showGoTo, "800", "350"); ?>"><?php echo $row_rsSelMembres['commission_lib']; ?>&nbsp;</a></td>
        <td class="style3"><?php echo $row_rsSelMembres['fonction_lib']; ?>&nbsp; </td>
    </tr>
      <?php } while ($row_rsSelMembres = mysql_fetch_assoc($rsSelMembres)); ?>
	<tr>
	  <td colspan="3" class="style3"><!--<a href="add_mbr_strong.php?perID=<?php // echo $_GET['perID']; ?>&amp;comID=<?php // echo $_GET['comID']; ?>">Ajout force</a>--></td>
    </tr>
   </table>
<br>
  <span class="style3"><?php echo $totalRows_rsSelMembres ?> Records Total</span>
  </p>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($rsSelMembres);

//mysql_free_result($rsMembres);
?>
