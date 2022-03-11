<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require("../inc/biblio.inc.php");
	  require("../includes/DW_Fonctions.php");
	  require("../includes/controler.php");
	  require("../includes/fonction_db.php");
	  //require("src/inc/mysql_biblio.inc.php");
?>
<?php


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE membres SET fonctions_fonction_id=%s, montant=%s, checboxName=%s, `position`=%s, date_designation=%s, date_constation=%s, date_cessation=%s, dateUpdate=%s, display=%s, state=%s, user_id=%s WHERE commissions_commission_id=%s AND personnes_personne_id=%s",
                       GetSQLValueString($_POST['fonctions_fonction_id'], "int"),
                       GetSQLValueString($_POST['montant'], "text"),
                       GetSQLValueString($_POST['checboxName'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['date_designation'], "date"),
					   GetSQLValueString($_POST['date_constation'], "date"),
					   GetSQLValueString($_POST['date_cessation'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_GET['comID'], "int"),
					   GetSQLValueString($_GET['perID'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
  

  $updateSQL1 = sprintf("UPDATE personnes SET personne_telephone=%s, dateUpdate=%s WHERE personne_id=%s",
                       GetSQLValueString($_POST['personne_telephone'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['personnes_personne_id'], "int"));
					   
  $Result1 = mysql_query($updateSQL1, $MyFileConnect) or die(mysql_error());
  
if ((isset($_POST['date_constation2'])) && ($_POST['date_constation2'] <> $_POST['date_constation']) && ($_POST['date_constation2'] <> NULL)) {  
    $insertSQL = sprintf("INSERT INTO hist_membres (fonction_id, date_designation, date_constation, dateCreation, display_agescom, user_id, commission_id, personne_id)  VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fonctions_fonction_id'], "int"),
                       GetSQLValueString($_POST['date_designation'], "date"),
					   GetSQLValueString($_POST['date_constation2'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_GET['comID'], "int"),
					   GetSQLValueString($_GET['perID'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
}
  /*MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId, PageLink, ModificationType, DateUpdate, GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));*/
  
  /*MinmapDB2::getInstance()->insert_4_chmp_into_table(GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));*/
  
  MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId,  PageLink, ModificationType, DateCreation, GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));

  /*$updateGoTo = "detail_commission.php";
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

$colname1_rsUpdPersonne = "-1";
if (isset($_GET['perID'])) {
  $colname1_rsUpdPersonne = (get_magic_quotes_gpc()) ? $_GET['perID'] : addslashes($_GET['perID']);
}
$colname_rsUpdPersonne = "-1";
if (isset($_GET['comID'])) {
  $colname_rsUpdPersonne = (get_magic_quotes_gpc()) ? $_GET['comID'] : addslashes($_GET['comID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsUpdPersonne = sprintf("SELECT membres.*, commission_lib, personne_id, personne_nom, personne_prenom, personne_telephone FROM membres, personnes, commissions  WHERE commissions_commission_id = commission_id  AND personnes_personne_id = personne_id AND commissions_commission_id = %s  AND personnes_personne_id = %s AND membres.display_agescom = 1", $colname_rsUpdPersonne,$colname1_rsUpdPersonne);
$rsUpdPersonne = mysql_query($query_rsUpdPersonne, $MyFileConnect) or die(mysql_error());
$row_rsUpdPersonne = mysql_fetch_assoc($rsUpdPersonne);
$totalRows_rsUpdPersonne = mysql_num_rows($rsUpdPersonne);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsFonctions = "SELECT fonction_id, fonction_lib FROM fonctions WHERE groupe_fonction_id =3 AND display = '1' ORDER BY fonction_lib ASC";
$rsFonctions = mysql_query($query_rsFonctions, $MyFileConnect) or die(mysql_error());
$row_rsFonctions = mysql_fetch_assoc($rsFonctions);
$totalRows_rsFonctions = mysql_num_rows($rsFonctions);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style4 {
	font-size: 16px;
	font-family: "Arial Narrow";
}
.style6 {font-family: "Arial Narrow"}
-->
</style>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Commissions:</span></th>
      <td><span class="style6"><?php echo $row_rsUpdPersonne['commissions_commission_id']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle" ><span class="style6">Noms et Prenoms :</span></th>
      <td ><span class="style6">
        <input type="hidden" name="personnes_personne_id" value="<?php echo $row_rsUpdPersonne['personnes_personne_id']; ?>" size="32" />
        <?php echo strtoupper($row_rsUpdPersonne['personne_nom'].' '.$row_rsUpdPersonne['personne_prenom']); ?></span></td>
    </tr>
    
    <tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Fonction:</span></th>
      <td><span class="style6">
        <select name="fonctions_fonction_id">
          <?php
do {  
?>
          <option value="<?php echo $row_rsFonctions['fonction_id']?>"<?php if (!(strcmp($row_rsFonctions['fonction_id'], $row_rsUpdPersonne['fonctions_fonction_id']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsFonctions['fonction_lib']); ?></option>
          <?php
} while ($row_rsFonctions = mysql_fetch_assoc($rsFonctions));
  $rows = mysql_num_rows($rsFonctions);
  if($rows > 0) {
      mysql_data_seek($rsFonctions, 0);
	  $row_rsFonctions = mysql_fetch_assoc($rsFonctions);
  }
?>
        </select>
      </span> </td>
    </tr>
	<tr valign="baseline">
      <th align="right" valign="middle" >Contact :</th>
      <td ><span class="style6">
        <input name="personne_telephone" type="text"  value="<?php echo $row_rsUpdPersonne['personne_telephone']; ?>" size="32" />
      </span></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Date Designation:</span></th>
      <td>
        <span class="style6">
      <input name="date_designation" type="date"  value="<?php echo $row_rsUpdPersonne['date_designation']; ?>" size="32"> 
      ex: 12/12/2012 </span></span></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Date Constation:</span></th>
      <td>
        <span class="style6">
      <input name="date_constation" type="date"  value="<?php echo $row_rsUpdPersonne['date_constation']; ?>" size="32"> 
      ex: 12/12/2012 </span></span></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle" nowrap class="style4">Etat:</th>
      <td><p>
        <label>
          <input type="radio" name="State" value="A" <?php if (!(strcmp($row_rsUpdPersonne['state'],A))) {echo "checked=\"checked\"";} ?> id="State_0" />
          En activité</label>
        <br />
        <label>
          <input type="radio" name="State" value="C"  <?php if (!(strcmp($row_rsUpdPersonne['state'],C))) {echo "checked=\"checked\"";} ?> id="State_1" />
          En cessation d'activité</label>
        <br />
        <label>
          <input type="radio" name="State" value="O"  <?php if (!(strcmp($row_rsUpdPersonne['state'],O))) {echo "checked=\"checked\"";} ?> id="State_2" />
          Autres</label>
        <br />
      </p></td>
    </tr>
	<tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Date Cessation:</span></th>
      <td>
        <span class="style6">
      <input name="date_cessation" type="date"  value="<?php echo $row_rsUpdPersonne['date_cessation']; ?>" size="32"> 
      ex: 12/12/2012 </span></span></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle"><span class="style6">Afficher:</span></th>
      <td><input name="display" type="checkbox" value="1" <?php if (!(strcmp($row_rsUpdPersonne['display'],1))) {echo "checked=\"checked\"";} ?>></td>
    </tr>
    <tr valign="baseline">
      <th align="right" valign="middle" nowrap class="style4">&nbsp;</th>
      <td><input type="submit" value="Modifier" /></td>
    </tr>
  </table>
  <input type="hidden" name="checboxName" value="<?php echo $row_rsUpdPersonne['checboxName']; ?>">
  <input type="hidden" name="dateUpdate" value="<?php echo $row_rsUpdPersonne['dateUpdate']; ?>">
  <input type="hidden" name="user_id" value="<?php echo $row_rsUpdPersonne['user_id']; ?>">
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="commissions_commission_id" value="<?php echo $row_rsUpdPersonne['commissions_commission_id']; ?>">
  <input name="montant" type="hidden" value="<?php echo $row_rsUpdPersonne['montant']; ?>" size="50" />
  <input name="position" type="hidden" value="<?php echo $row_rsUpdPersonne['position']; ?>" size="15" />
  <span class="style6">
  <input name="date_constation2" type="hidden"  value="<?php echo $row_rsUpdPersonne['date_constation']; ?>" size="32" />
  </span>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsUpdPersonne);
?>
