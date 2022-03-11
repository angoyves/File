<?php 
	/*$hostname_MyFileConnect = "localhost";
	$database_MyFileConnect = "fichier_db8";
	$username_MyFileConnect = "root";
	$password_MyFileConnect = "";
	$MM_redirectLoginEchec = "error_data.php";
	//$MyFileConnect = mysql_pconnect($hostname_MyFileConnect, $username_MyFileConnect, $password_MyFileConnect) or header("Location: " . $MM_redirectLoginEchec ); */
	require_once('../Connections/MyFileConnect.php');
	require_once('../includes2/db.php');
    require_once('../../include/fonction_db.php');
	require('../../includes/MyFonction.php');
?>

<?php
// *** Validate request to login to this site.
if (!isset($_SESSION))
  session_start();


$loginFormAction = $_SERVER['PHP_SELF'];
//$loginFormAction = "myconnexions.php";
if (isset($_GET['accesscheck']))
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];


if (isset($_POST['answer'])) {
  $loginUsername = $_SESSION['MM_Username'];
  $password= $_SESSION['MM_UserPass'];
  $userAnswer = $_POST['answer'];
  $userID=$_SESSION['MM_UserID'];
  $MM_fldUserAuthorization = "user_groupe_id";
  $MM_redirectLoginSuccess = "logIn.php";
  $MM_redirectLoginFailed = "UserAlterConnexion.php?uID=".$userID;
  $MM_redirectLoginIsConnected = "UserConnected.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  	
  $LoginRS__query=sprintf("SELECT * FROM users WHERE user_login=%s AND user_answer=%s AND display_agescom='1'",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($userAnswer, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $MyFileConnect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $UserConnect  = mysql_result($LoginRS,0,'user_connected');
	if ($UserConnect==1){
	MinmapDB::getInstance()->update_users_connected('0', $_SESSION['MM_UserID']);
    header("Location: " . $MM_redirectLoginSuccess );
	}
  }  else {
	$insertSQL = sprintf("INSERT INTO listing_action (UserId, PageLink, ModificationType, DateUpdate) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($loginUsername, "int"),
                       GetSQLValueString('connexions.php', "text"),
                       GetSQLValueString('Echec de connexion a AGESCOM - '.$_POST['user'].' et mot de passe '.$_POST['userpassword'], "text"),
                       GetSQLValueString(date('Y-m-d H:i:s'), "date"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result3 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());
    //header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AGESCOM</title>
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/structure.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/signin.css" type="text/css">
<style type="text/css">
a {
	font-size: 200%;
}
</style>
</head>

<body>
<div id="container">
  
  <ul>
    <table border="0" align="center">
      <tr>
        <td width="213" align="left" scope="col">
          <img src="../../images/img/logo_minmap.gif" alt="Connexion à AGESCOM" width="200" height="223" class="ps-staticimg" title="Connexion à AGESCOM" />
        </td>
        <td width="339" scope="col"><h1><a id="logo" href="logIn.php">Retour à la boite de connexion</h1></td>
      </tr>
    </table>
  </ul>
  <form class="wufoo" action="<?php echo $loginFormAction .'?uID=' . $userID; ?>" method="POST" name="form1" id="form1">
    <ul>
      <li class="section">
        <h3></h3>
      </li>
      <li>
        <label class="desc"><?php echo strtoupper($_SESSION['MM_Username']); ?></label>
      </li>
      <li>
        <label class="desc"><?php echo MinmapDB2::getInstance()->get_1_col_lib_by_id(users, user_question, user_id, ((isset($_GET['uID']) && $_GET['uID'] =='')?$userID:$_GET['uID'])); ?></label>
        <span>
        <input class="field text" type="password" name="answer" size="32" value=""/>
          <br/>
          <div class="error">
            <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        if (!$loginFoundUser)
                            echo "Reponse de la question secrete incorrect";
							
                    }
            ?>
          </div>
        </span></li>
      <li class="ps_loginmessagelarge"><span class="ps_box-button">
        <input type="submit" name="Submit" title="Fermer la session active" class="ps-button" value="Fermer la session active" onclick="return onFormSubmit(document.login);" tabindex="3" />
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