<?php require_once('../../Connections/MyFileConnect.php'); ?>

<?php 
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_nature")) {
  $insertSQL = sprintf("INSERT INTO natures (nature_id, lib_nature, dateCreation, lastUpdate, display, sigle_nature) VALUES (%s, %s, %s, %s, %s,  %s)",
                       GetSQLValueString($_POST['nature_id'], "int"),
                       GetSQLValueString($_POST['libNature'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['lastUpdate'], "date"),
                       GetSQLValueString($_POST['display'], "text"),
					   GetSQLValueString($_POST['sigleNature'], "text"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

  /*$insertGoTo = "list_nature.php";
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
?>