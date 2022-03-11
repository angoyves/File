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
$editFormAction = '';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$txtSearch = '-1';
if (isset($_REQUEST['txtSearch'])){
	$txtSearch = $_REQUEST['txtSearch'];
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsAffichePerson = sprintf("SELECT * FROM personnes WHERE personne_nom LIKE %s ORDER BY personne_nom ASC", GetSQLValueString("%" . $txtSearch . "%", "text"));
$rsAffichePerson = mysql_query($query_rsAffichePerson, $MyFileConnect) or die(mysql_error());
$row_rsAffichePerson = mysql_fetch_assoc($rsAffichePerson);
$totalRows_rsAffichePerson = mysql_num_rows($rsAffichePerson);

if ((isset($_POST["MM_delete"])) && ($_POST["MM_delete"] == "form1")) {
$record_id = $_REQUEST['persID'];
$record_id1 = $_REQUEST['persID1'];
MinmapDB::getInstance()->update_record(sessions, membres_personnes_personne_id, membres_personnes_personne_id, $date, $record_id, $record_id1);
MinmapDB::getInstance()->delete_record(membres, personnes_personne_id, $record_id1);
MinmapDB::getInstance()->delete_record(rib, personne_id, $record_id1);
MinmapDB::getInstance()->delete_record(personnes, personne_id, $record_id1);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form2" name="form2" method="post" action="">
  <table width="278">
    <tr>
      <th width="41" scope="row">&nbsp;</th>
      <td width="144">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap" scope="row">Nom :</th>
      <td><input name="txtSearch" type="text" id="txtSearch" /></td>
      <td><input type="submit" name="BtnSearch" id="BtnSearch" value="Rechercher" /></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_serach" value="form1" />
</form></br>
<table width="75%" border="1" align="center" class="std">
  <tr>
    <th colspan="2">N°</th>
    <th>Matricule</th>
    <th>Structure</th>
    <th>Nom et prenom</th>
    <th>RIB</th>
    <th align="center">1</th>
    <th>2</th>
    <th>M</th>
    <th>Actif</th>
    <th>Supprime</th>
  </tr>
  <?php $counter=0; do  { $counter++; ?>
  <tr bgcolor="<?php echo alter_color($counter, "#eee", "#FFF"); ?>">
    <td colspan="2"><?php  echo $row_rsAffichePerson['personne_id'];?>&nbsp;</td>
    <td><?php echo $row_rsAffichePerson['personne_matricule']; ?>
      &nbsp; </td>
    <td><?php echo $row_rsAffichePerson['structure_id']; ?>&nbsp;</td>
    <td nowrap="nowrap"><?php echo ucfirst($row_rsAffichePerson['personne_nom']) . " " . ucfirst($row_rsAffichePerson['personne_prenom']); ?>&nbsp;</td>
    <td nowrap="nowrap"><a href="#" onclick="<?php popup($showGoToPersonnes1, "700", "400"); ?>">
      <?php $user_rib = MinmapDB::getInstance()->get_user_rib_by_id($row_rsAffichePerson['personne_id']);
	  if (isset($user_rib) && $user_rib <> 'xxxxxxxxxxxxxxxxxxxxxxx'){
		  echo $user_rib; }else{ echo 'Cliquez pour saisir le RIB'; } ?>
      <?php /*echo strtoupper($row_rsAffichePerson['banque_code'].'-'.$row_rsAffichePerson['agence_code'].'-'.$row_rsAffichePerson['numero_compte'].'-'.$row_rsAffichePerson['cle']); */?>
    </a>&nbsp;</td>
    <td nowrap="nowrap"><a href="<?php echo $editFormAction . "txtSearch=" .$txtSearch. "&persID=" . $row_rsAffichePerson['personne_id']; ?>" ><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle" /></a></td>
    <td nowrap="nowrap"><a href="<?php echo $editFormAction . "&persID1=" . $row_rsAffichePerson['personne_id'] ?>" ><img src="images/img/b_snewtbl.png" alt="" width="16" height="16" align="absmiddle" /></a></td>
    <td align="center"><?php if (isset($row_rsAffichePerson['add_commission']) && $row_rsAffichePerson['add_commission'] == 2 ){ ?>
      <img src="images/img/b_usrlist.png" alt="" width="16" height="16" align="absmiddle"/>
      <?php } ?>
      &nbsp; </td>
    <td align="center"><?php if (isset($row_rsAffichePerson['display']) && $row_rsAffichePerson['display'] == '1') { ?>
      <a href="change_etat_index.php?recordID=<?php echo $row_rsAffichePerson['personne_id']; ?>&amp;map=personnes&amp;mapid=personne_id&amp;action=desactive&amp;menuID=<?php echo $_GET['menuID']; ?>"><img src="images/img/s_okay.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } else { ?>
      <a href="change_etat_index.php?recordID=<?php echo $row_rsAffichePerson['personne_id']; ?>&amp;map=personnes&amp;mapid=personne_id&amp;action=active&amp;menuID=<?php echo $_GET['menuID']; ?>"><img src="images/img/s_cancel.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } ?></td>
    <td align="center"><a href="del_personnes.php?recordID=<?php echo $row_rsAffichePerson['personne_id']; ?>&amp;menuID=<?php echo $_GET['menuID']; ?>" onclick="return confirm('Etes vous sur de vouloir supprimer cet enregistrement?');" ><img src="images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/></a></td>
  </tr>
  <?php } while ($row_rsAffichePerson = mysql_fetch_assoc($rsAffichePerson)); ?>
</table>
</br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="200" align="center">
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap" scope="row">Change personne ID :</th>
      <td><input type="text" name="persID" id="persID" value="<?php echo trim(isset($_REQUEST['persID'])?$_REQUEST['persID']:''); ?>" /></td>
      <td>By</td>
      <td><input type="text" name="persID1" id="persID1" value="<?php echo trim(isset($_REQUEST['persID1'])?$_REQUEST['persID1']:''); ?>"/></td>
      <td><input type="submit" name="BtnDelete" id="BtnDelete" value="Submit" onclick="return confirm('Etes vous sur de vouloir modifier ?');"/></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td colspan="2" nowrap="nowrap"><?php echo $_REQUEST['persID']. ":" .MinmapDB::getInstance()->get_personne_name_by_person_id(isset($_REQUEST['persID'])?$_REQUEST['persID']:''); ?>&nbsp;</td>
      <td colspan="2" nowrap="nowrap"><?php echo $_REQUEST['persID1']. ":" .MinmapDB::getInstance()->get_personne_name_by_person_id(isset($_REQUEST['persID1'])?$_REQUEST['persID1']:''); ?>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_delete" value="form1" />
</form>
</body>
</html>