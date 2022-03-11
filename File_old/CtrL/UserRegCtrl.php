<?php require_once('../Connections/MyFileConnect.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frm_user_insert")) {
  //$insertSQL = sprintf("INSERT INTO users (user_id, user_name, user_lastname, user_login, user_password, user_groupe_id, structure_id, display, date_last_login, dateCreation, dateUpdate, compteur, user_connected, user_question, user_answer, display_agescom, personne_id, user_level, supplierNm, telNo, eMail, acceptYn, regDt, acceptDt, userAuthNm, addr, faxNo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
																																																																																												
$date = date('Y-m-d H:i:s');																																																																																												$insertSQL = sprintf("INSERT INTO users (user_login, user_name, user_lastname, user_password, user_groupe_id, structure_id, display, date_last_login, dateCreation, dateUpdate, compteur, user_connected, user_question, user_answer, display_agescom, personne_id, user_level, supplierNm, telNo, eMail, acceptYn, regDt, acceptDt, userAuth, addr, faxNo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['userId'], "text"),
                       GetSQLValueString($_POST['user_name'], "text"),
					   GetSQLValueString($_POST['user_lastname'], "text"),
					   GetSQLValueString(md5($_POST['userPw']), "text"),
                       GetSQLValueString($_POST['user_groupe_id'], "int"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['display'], "text"),
                       GetSQLValueString($_POST['date_last_login'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($_POST['compteur'], "int"),
                       GetSQLValueString($_POST['user_connected'], "text"),
                       GetSQLValueString($_POST['user_question'], "text"),
                       GetSQLValueString($_POST['user_answer'], "text"),
                       GetSQLValueString($_POST['display_agescom'], "text"),
                       GetSQLValueString($_POST['personne_id'], "int"),
                       GetSQLValueString($_POST['user_level'], "text"),
                       GetSQLValueString($_POST['supplierNm'], "text"),
                       GetSQLValueString($_POST['telNo'], "text"),
                       GetSQLValueString($_POST['eMail'], "text"),
                       GetSQLValueString($_POST['acceptYn'], "text"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['acceptDt'], "date"),
                       GetSQLValueString($_POST['userAuth'], "text"),
                       GetSQLValueString($_POST['addr'], "text"),
                       GetSQLValueString($_POST['faxNo'], "text"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

 /* $insertGoTo = "login.php";
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