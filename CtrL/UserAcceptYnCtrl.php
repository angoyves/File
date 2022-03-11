<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require('UserAuthorisationCtrl.php'); ?>
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

$date = date('Y/m/d H:i');
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_user_detail")) {
  $updateSQL = sprintf("UPDATE users SET dateUpdate=%s, acceptYn=%s, acceptDt=%s, acceptId=%s, acceptNm=%s WHERE user_id=%s",
                       GetSQLValueString($date, "date"),                      
                       GetSQLValueString($_POST['acceptYn'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_SESSION['MM_UserID'], "text"),
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());

  $updateGoTo = "../user/UsersReg.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  
  header(sprintf("Location: %s", $updateGoTo));
}

?>