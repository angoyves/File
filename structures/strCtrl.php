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

$date = date('Y-m-d H:i:s');

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

  $user_id = (MinmapDB::getInstance()->get_user_id_by_name($_GET['uID']));
  $personne_id = $_GET['pID'];
  if ($personne_id){
  /*$updateSQL = sprintf("UPDATE personnes SET add_commission=1, dateUpdate=%s, user_id=%s WHERE personne_id=%s",
					   GetSQLValueString($date, "date"),
					   GetSQLValueString($user_id, "int"),
                       GetSQLValueString($_GET['pID'], "int"));*/
  $updateSQL = sprintf("UPDATE personnes SET user_id=%s, add_commission=%s, dateUpdate=%s WHERE personne_id=%s",
                       GetSQLValueString($user_id, "text"),
					   GetSQLValueString(1, "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($personne_id, "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
	
  /*mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());*/
  }
  //$updateGoTo = "index.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));*/
  echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";

mysql_free_result($rsUdpUsers);
?>