<?php require_once('../../Connections/MyFileConnect.php'); ?>
<?php require('../CtrL/UserAuthorisationCtrl.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET user_password=%s, user_groupe_id=%s, structure_id=%s, display=%s, dateUpdate=%s, compteur=%s, user_connected=%s, user_question=%s, user_answer=%s, display_agescom=%s, personne_id=%s, user_level=%s, supplierNm=%s, telNo=%s, eMail=%s, acceptYn=%s, regDt=%s, userAuthNm=%s, addr=%s, faxNo=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['user_password'], "text"),
                       GetSQLValueString($_POST['user_groupe_id'], "int"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($_POST['compteur'], "int"),
                       GetSQLValueString($_POST['user_connected'], "text"),
                       GetSQLValueString($_POST['user_question'], "text"),
                       GetSQLValueString($_POST['user_answer'], "text"),
                       GetSQLValueString(isset($_POST['display_agescom']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['personne_id'], "int"),
                       GetSQLValueString($_POST['user_level'], "text"),
                       GetSQLValueString($_POST['supplierNm'], "text"),
                       GetSQLValueString($_POST['telNo'], "text"),
                       GetSQLValueString($_POST['eMail'], "text"),
                       GetSQLValueString($_POST['acceptYn'], "text"),
                       GetSQLValueString($_POST['regDt'], "date"),
                       GetSQLValueString($_POST['userAuthNm'], "text"),
                       GetSQLValueString($_POST['addr'], "text"),
                       GetSQLValueString($_POST['faxNo'], "text"),
                       GetSQLValueString($_SESSION['MM_UserID'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());

  $updateGoTo = "UserDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_Recordset = $_SESSION['MM_UserID'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM users WHERE user_id = %s", GetSQLValueString($colname_Recordset, "int"));
$Recordset = mysql_query($query_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset1 = "SELECT groupe_id, groupe_lib FROM groupes WHERE display = '1'";
$Recordset1 = mysql_query($query_Recordset1, $MyFileConnect) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset2 = "SELECT structure_id, structure_lib FROM structures WHERE display_agescom = '1' ORDER BY structure_id DESC";
$Recordset2 = mysql_query($query_Recordset2, $MyFileConnect) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset3 = "SELECT DISTINCT(user_question) FROM users ORDER BY user_question DESC";
$Recordset3 = mysql_query($query_Recordset3, $MyFileConnect) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>