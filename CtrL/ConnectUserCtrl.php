<?php 
	/*$hostname_MyFileConnect = "localhost";
	$database_MyFileConnect = "fichier_db8";
	$username_MyFileConnect = "root";
	$password_MyFileConnect = "";
	$MM_redirectLoginEchec = "error_data.php";
	//$MyFileConnect = mysql_pconnect($hostname_MyFileConnect, $username_MyFileConnect, $password_MyFileConnect) or header("Location: " . $MM_redirectLoginEchec ); */
	require_once('../Connections/MyFileConnect.php');
	require_once('../includes2/db.php');
?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
//$loginFormAction = "connexions.php";
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['userId'])) {
  $loginUsername=$_POST['userId'];
  $password=md5($_POST['userPw']);
  $MM_fldUserAuthorization = "user_groupe_id";
  $MM_redirectLoginSuccess = "../user/UserDetails.php";
  //$MM_redirectLoginFailed = "../user/logIn.php";
  $MM_redirectLoginFailed = "../connexion.php";
  $MM_redirectLoginIsConnected = "../user/UserConnected.php";
  $MM_redirectQuestionIsNull = "../user/UserUpdate.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  	
  $LoginRS__query=sprintf("SELECT * FROM users WHERE user_login=%s AND user_password=%s AND display_agescom=1",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $MyFileConnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $UserConnect  = mysql_result($LoginRS,0,'user_connected');
	if ($UserConnect==0){
	$loginStrGroup  = mysql_result($LoginRS,0,'user_groupe_id');
	$userStrQuestion  = mysql_result($LoginRS,0,'user_question');
    
    //declare four session variables and assign them
	$_SESSION['MM_UserID'] = (MinmapDB::getInstance()->get_user_id_by_name($_POST['userId']));
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['MM_UserGroupName'] = (MinmapDB::getInstance()->get_user_groupe($loginStrGroup));
	$_SESSION['MM_NomPrenom'] = (MinmapDB::getInstance()->get_user_name($_SESSION['MM_UserID']));

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
		$date = date('Y-m-d H:i:s');
	  	$updateSQL = sprintf("UPDATE users SET date_last_login=%s WHERE user_login=%s",
                       GetSQLValueString($date, "date"),
					   GetSQLValueString($_SESSION['MM_Username'], "text"));

	  	mysql_select_db($database_MyFileConnect, $MyFileConnect);
	  	$Result = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
	
	    MinmapDB::getInstance()->update_users_connected('1', $_SESSION['MM_UserID']);
	
	if ($userStrQuestion==NULL){
	header("Location: " . $MM_redirectQuestionIsNull);
	} else {
    header("Location: " . $MM_redirectLoginSuccess );
	}
	
	} else{
		
	$_SESSION['MM_UserID'] = (MinmapDB::getInstance()->get_user_id_by_name($_POST['userId']));
    $_SESSION['MM_Username'] = $loginUsername;
	$_SESSION['MM_UserPass'] = $password;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['MM_taux'] = 0.8;
	$_SESSION['MM_UserGroupName'] = (MinmapDB::getInstance()->get_user_groupe($loginStrGroup));
	$_SESSION['MM_NomPrenom'] = (MinmapDB::getInstance()->get_user_name($_SESSION['MM_UserID']));
	
	header("Location: " . $MM_redirectLoginIsConnected . "?uID=" . $_SESSION['MM_UserID']);	
	//header("Location: " . $MM_redirectLoginIsConnected );	
	}
	
  }  else {
	$insertSQL = sprintf("INSERT INTO listing_action (UserId, PageLink, ModificationType, DateUpdate) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['userId'], "int"),
                       GetSQLValueString('connexions.php', "text"),
                       GetSQLValueString('Echec de connexion a AGESCOM - '.$_POST['userId'].' et mot de passe '.$_POST['userPw'], "text"),
                       GetSQLValueString(date('Y-m-d H:i:s'), "date"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result3 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
  header("Location: ". $MM_redirectLoginFailed );
  }
}
?>