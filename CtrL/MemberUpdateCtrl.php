<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require("../inc/biblio.inc.php");
	  require("../includes/DW_Fonctions.php");
	  require("../includes/controler.php");
	  require("../includes/fonction_db.php");

?>
<?php
//echo $_POST['MM_update'].'-'.$_POST['comId'].'-'.$_POST['perId'].'-'.$_POST['fonId'].'-'.$_POST['State'].'-'.$_POST['date_cessation'];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_member_update")) {
  $updateSQL = sprintf("UPDATE membres SET fonctions_fonction_id=%s, date_designation=%s, date_constation=%s, date_cessation=%s, dateUpdate=%s, display=%s, state=%s WHERE commissions_commission_id=%s AND personnes_personne_id=%s",
                       GetSQLValueString($_POST['fonctions_fonction_id'], "int"),
                       GetSQLValueString($_POST['date_designation'], "date"),
					   GetSQLValueString($_POST['date_constation'], "date"),
					   GetSQLValueString($_POST['date_cessation'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
					   GetSQLValueString($_POST['State'], "text"),
                       GetSQLValueString($_POST['comId'], "int"),
					   GetSQLValueString($_POST['perId'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
  

  $updateSQL1 = sprintf("UPDATE personnes SET personne_telephone=%s, sexe=%s, dateUpdate=%s WHERE personne_id=%s",
                       GetSQLValueString($_POST['personne_telephone'], "text"), 
					   GetSQLValueString($_POST['sexe'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['perId'], "int"));
					   
  $Result1 = mysql_query($updateSQL1, $MyFileConnect) or die(mysql_error());
  
if ((isset($_POST['date_constation2'])) && ($_POST['date_constation2'] <> $_POST['date_constation']) && ($_POST['date_constation2'] <> NULL)) {  
    $insertSQL = sprintf("INSERT INTO hist_membres (fonction_id, date_designation, date_constation, dateCreation, display_agescom, user_id, commission_id, personne_id)  VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fonctions_fonction_id'], "int"),
                       GetSQLValueString($_POST['date_designation'], "date"),
					   GetSQLValueString($_POST['date_constation2'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['comId'], "int"),
					   GetSQLValueString($_POST['perId'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
}
  /*MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId, PageLink, ModificationType, DateUpdate, GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));*/
  
  /*MinmapDB2::getInstance()->insert_4_chmp_into_table(GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));*/
  
  MinmapDB2::getInstance()->insert_4_chmp_into_table(listing_action_agescom, UserId,  PageLink, ModificationType, DateCreation, GetSQLValueString(12, "int"), GetSQLValueString('upd_personn.php', "text"), GetSQLValueString('Mise à jour personne', "text"), GetSQLValueString($date, "date"));

 //$updateGoTo = "../commissions/CommissionDetails.php?bizRegNo=".$_REQUEST['comId'];
   /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  //header(sprintf("Location: %s", $updateGoTo));
     /* echo "<script type='".text/javascript."'>
	  	var form = document.frm_user;
		
		form.bizRegNo.value = exDocType;
		
		form.action = '"/ed/rcv/moveCtDocList.do"';
		form.target = '"_top"';
		form.submit();
  		window.opener.location.reload(); 
		self.close(); 
		</script>";*/
}
?>
<form name="frm_member_update" id="frm_member_update" method="post">
<input type="hidden" name="bizRegNo">
</form>

<script type="text/javaScript" language="javascript">

		var form = document.frm_member_update;
		//form.isBack.value = "N";
		form.bizRegNo.value = "<?php echo $_REQUEST['comId'] ?>";
		form.target = "_top";
		form.action = "../commissions/CommissionDetails.php";
		form.submit();

</script>