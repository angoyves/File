<?php 
	  require_once('../Connections/MyFileConnect.php'); 
?>
<?php
	  require_once('../includes/db.php');
	  require("../src/inc/design.inc.php");
	  require("../src/inc/biblio.inc.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  require("../src/inc/db.php");
	  require('../includes/MyFonction.php');
?>
<?php

$colname_rsPersonnes = "-1";
if (isset($_POST['txt_search'])) {
  $colname_rsPersonnes = $_POST['txt_search'];
}
$colname2_rsPersonnes = "-1";
if (isset($_POST['txt_search'])) {
  $colname2_rsPersonnes = $_POST['txt_search'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsPersonnes = sprintf("SELECT structures.*, localites.localite_id, localite_lib FROM structures, localites WHERE structures.localite_id = localites.localite_id AND (structure_lib LIKE %s OR code_structure LIKE %s) AND structures.display_agescom = 0 ORDER BY structure_lib ASC", GetSQLValueString("%" . $colname_rsPersonnes . "%", "text"),GetSQLValueString("%" . $colname2_rsPersonnes . "%", "text"));
$rsPersonnes = mysql_query($query_rsPersonnes, $MyFileConnect) or die(mysql_error());
$row_rsPersonnes = mysql_fetch_assoc($rsPersonnes);
$totalRows_rsPersonnes = mysql_num_rows($rsPersonnes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APPLICATION DE GESTION DES INDEMNITES DE SESSION</title>
<style type="text/css">
<!--
.style1 {font-family: "Arial Narrow"}
.style4 {font-family: "Arial Narrow"; color: #FFFFFF; }
-->
</style>
</head>

<body>
<table width="75%" border="0" align="center" class="std">
  <tr>
    <td colspan="8">
    <?php
	//$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
	  //$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING'].'&txtSearch='.$_POST['txt_search']);
	  $editFormAction = getURI(true, 'txtSearch').'txtSearch='.$_POST['txt_search'];
	}
	
	?>
      <form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>">
      Rechercher :<input type="text" name="txt_search" id="txt_search" value="<?php echo (isset($_POST['txt_search'])? $_POST['txt_search'] : $_GET['txtSearch']); ?>" />
      <input type="submit" name="button" id="button" value="Submit" />
    </form></td>
  </tr>
  <?php if (!$sessionIsUnique) { ?>
        <div class="error"><img src="../images/img/s_error.png" alt="" width="16" height="16" align="absmiddle" />
        This Session already exists. Please check the spelling and try again</div>
  <?php   } ?>
  <?php if ($totalRows_rsPersonnes > 0) { // Show if recordset not empty ?>
  <tr bgcolor="#348FC7">
    <th><span class="style1">ID</th>
    <th>&nbsp;</th>
    <th><span class="style1">Libelle</th>
    <th>&nbsp;</th>
    <th><span class="style1">Localite</th>
    <th><span class="style1">Ajouter</th>
  </tr>
  <?php $counter=0; do  { $counter++; ?>
    <tr bgcolor="<?php echo alter_color($counter, "#eee", "#FFF"); ?>">
      <td><span class="style1"><a href="#"> <img src="../images/img/b_views.png" width="16" height="16" /></a></td>
      <td><?php echo $row_rsPersonnes['structure_id']; ?>&nbsp;</td>
      <td><span class="style1"><?php echo $row_rsPersonnes['structure_lib']; ?><a href="" onclick="<?php popup('upd_structures.php?strID='.$row_rsPersonnes['structure_id'].'&regID='.$_GET['regID'].'&depID='.$_GET['depID'].'&locID='.$_GET['locID'], "710", "350"); ?>"><img src="../images/img/b_edit.png" width="16" height="16" /></a></td>
      <td><?php echo $row_rsPersonnes['code_structure']; ?>&nbsp;</td>
      <td><span class="style1"><?php echo $row_rsPersonnes['localite_lib']; ?> </td>
      <td><span class="style1">
          <?php if (isset ($_GET['regID'])) { ?>
          <a href="activ_structure.php?strID=<?php echo $row_rsPersonnes['structure_id']; ?>&regID=<?php echo $_GET['regID']; ?>&locID=<?php echo $_GET['locID'] ?>"><img src="../images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/>+++++++</a>
          <?php } else {?>
          <a href="strCtrl.php?recordID=<?php echo $row_rsPersonnes['structure_id']; ?>&amp;map=personnes&amp;mapid=structure_id&amp;action=add_com&amp;page=addMbr3&amp;fID=<?php echo $_GET['comID']; ?>&amp;pID=<?php echo $_GET['pID=']; ?>&amp;aID=<?php echo $_GET['aID']; ?>&amp;mID=<?php echo $_GET['mID']; ?>"><img src="../images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle"/></a>
        <?php }  ?>
  &nbsp;
    </td>
  
  </tr>
<?php } while ($row_rsPersonnes = mysql_fetch_assoc($rsPersonnes)); ?>
<?php } //else {// Show if recordset not empty ?>
  <tr>
    <td colspan="8">
  <p>&nbsp;</p>
  <table width="100%" border="0" align="left">
<?php if ($totalRows_rsPersonnes == 0) { // Show if recordset empty ?>  
    <tr>
      <td><span class="style1">Aucun resultat trouvé pour la recherche sur :<strong><?php echo $_POST['txt_search'] ?></strong></td>
    </tr>
<?php } // Show if recordset empty ?><?php //} ?>
<?php if ((isset($_POST["txt_search"])) || ($totalRows_rsPersonnes == 0) ) { // Show if recordset empty ?>  
    <tr>
      <td><span class="style1">
        <?php           
			//$showGoTo = "sample21.php?txt=".$_POST['txt_search'];
			$showGoTo = "add_structures.php?txt=".$_POST['txt_search']."&locID=".$loc_id;
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
        <a href="#" onclick="<?php popup($showGoTo, "610", "300"); ?>">Enregistrer  une nouvelle structure...<img src="../images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle" /></a>
        </td>
      </tr>
  <?php } ?>
  </table>
  </td>
  </tr>

</table>
</body>
</html>
<?php
mysql_free_result($rsPersonnes);
?>
