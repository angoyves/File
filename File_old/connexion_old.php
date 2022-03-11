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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['userpassword'];
  $MM_fldUserAuthorization = "user_level";
  $MM_redirectLoginSuccess = "active.php";
  $MM_redirectLoginFailed = "inactive.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  	
  $LoginRS__query=sprintf("SELECT user_login, user_password, user_level FROM users WHERE user_login=%s AND user_password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $MyFileConnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'user_level');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>APPLICATION DE GESTION DES INDEMNITES DE SESSION</title>
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/structure.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/signin.css" type="text/css">
</head>
<title>Document sans titre</title>
</head>

<body>
<div id="container">
  <ul>
    <table border="0" align="center">
      <tr>
        <td width="213" align="left" scope="col"><img src="../images/img/logo_minmap.gif" alt="Connexion à AGESCOM" width="200" height="223" class="ps-staticimg" title="Connexion à AGIS" /></td>
        <td width="339" scope="col"><h1><a id="logo" href="">Application de Gestion des Commission de Passation de Marchés Publiques(AGESCOM)</h1></td>
      </tr>
    </table>
  </ul>
  <form class="wufoo" action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
    <ul>
      <li class="section">
        <h3></h3>
      </li>
      <li>
        <label class="desc">Compte utilisateur</label>
        <span>
        <input class="field text" name="user" size="32" value="<?php echo $_POST['user']; ?>"/>
        </span></li>
      <li>
        <label class="desc">Mot de passe</label>
        <span>
          <input name="userpassword" type="password" class="field text" size="32"/>
          <br/>
          <div class="error">
            <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        if (!$loginFoundUser)
                            echo "Login Invalide et/ou Mot de Passe";
							
                    }
            ?>
          </div>
        </span></li>
      <li class="ps_loginmessagelarge"><span class="ps_box-button">
        <input type="submit" name="Submit" title="Connexion" class="ps-button" value="Connexion" onclick="return onFormSubmit(document.login);" tabindex="3" />
      </span></li>
      <li class="section">
        <h3>Pas encore enregistré?</h3>
        <div>Créer votre compte en cliquant sur le lien suivant...<a href="new_user.php">Créer son compte</a></div>
      </li>
    </ul>
  </form>
</div>
</body>
</html>