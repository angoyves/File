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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Application de Gestion des Commissions</title>
<link rel="stylesheet" href="../css/common.css" media="all">
<script type="text/javaScript" src="../js/common/font.js"></script>
<script type="text/javaScript" src="../js/common/alert.js"></script>
<script type="text/javaScript" language="javascript">
    
    // mask String
    var validateTokenNumber="Chiffre";
    var validateTokenKorean="Caractère coréen";
    var validateTokenUpperEnglish="Majuscule";
    var validateTokenLowerEnglish="Minuscule";
    var validateTokenNewline="Saut de ligne";
    var validateTokenUnderBar="Barre de soulignement";
    var validateTokenComma="Virgule";
    var validateTokenDot="Point";
    var validateTokenDash="Tiret";
    var validateTokenSpace="Espace";
    var validateTokenParentheses ="Parenthèses";

    // required message
    var requiredMessage="Veuillez remplir les champs obligatoires.";

    // calrendar.js에서 사용 	
    var systime ="May 3, 2021 08:08:04";
    var systimeStr ="2021050308080484";
    var today ="20210503";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="03/05/2021";
    // contextPath
    var contextPath = "/";
    // 현재언어
    var langCode = "fr";
     // 날짜포맷
    var dateFormat = "dd/MM/yyyy";
     // 날짜구분타입
    var dateSeparater = "/";
     // 시간구분타입
    var timeSeparater = ":";
     // 화폐구분타입
    var caliberSeparater = ".";
     // 화폐구분단위
    var caliberDigits = 3;
     // 소수점 구분
    var caliberPoint = ",";
     // 입찰, 계약 자리수 구분 메세지
     var invalidDigitMessage = "Possible de saisir un nombre entier avec {0} chiffre et un décimal avec {1} chiffres";
     // 금액 체크 메세지
     var invalidMoneyMessage = "Entrée invalide.";
     // 수량 체크 메세지
     var invalidQuantityMessage = "Entrée inalide.";
     // 소수점 체크 메세지
     var invalidDecimalMessage = "Possible de saisir jusqu'à {1} chiffres après la virgule";
     // 확인 메세지
     var confirmStr = "Confirmer";
     // 취소 메세지
     var cancelStr = "Annuler";
     // 정수 범위 메세지
     var intRangeStr = "Nombre entier peut consister 14 chiffres au plus.";
 
	function noEvent() {
		if (event.keyCode == 116) {
			event.keyCode= 2;
			return false;
		}
	}
	document.onkeydown = noEvent;
	
</script>

<script type="text/javascript"> 

     var bCancel = false; 

    function validateFrm_user_update(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateRequired(form) && validateMaxLength(form) && validateMask(form) && validateEmail(form); 
   } 

    function required () { 
     this.aa = new Array("userId", "frm_user_update.userId", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "frm_user_update.supplierNm", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("addr", "Adresse", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.af = new Array("telNo", "N° de Téléphone", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("faxNo", "N° de Fax", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ah = new Array("eMail", "e-Mail", new Function ("varName", "this.maxlength='240';  return this[varName];"));
    } 

    function maxlength () { 
     this.aa = new Array("userId", "frm_user_update.userId can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe can not be greater than 6 characters(korean 3characters).", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe can not be greater than 6 characters(korean 3characters).", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "frm_user_update.supplierNm can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("addr", "Adresse can not be greater than 250 characters(korean 3characters).", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.af = new Array("telNo", "N° de Téléphone can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("faxNo", "N° de Fax can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ah = new Array("eMail", "e-Mail can not be greater than 40 characters(korean 3characters).", new Function ("varName", "this.maxlength='240';  return this[varName];"));
    } 

    function mask () { 
     this.aa = new Array("userId", "frm_user_update.userId is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "frm_user_update.supplierNm is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("addr", "Adresse is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.af = new Array("telNo", "N° de Téléphone is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("faxNo", "N° de Fax is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
    } 

    function email () { 
     this.aa = new Array("eMail", "e-Mail is an invalid e-mail address.", new Function ("varName", "this.maxlength='240';  return this[varName];"));
    } 


</script>


<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/alertExms.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/prototype.js"></script>
<script type="text/javascript" src="../js/common/calendar.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javaScript" language="javascript">

	// 로그아웃
	function fn_logOut(){
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}

	//수정화면 이동 처리 함수 :: More screen-handling functions
	function fn_moveUserUpdate(){
		var form = document.frm_user_detail;
		form.target = "_top";
		form.action = "UserUpdate.php";
		form.submit();
	}

	//리스트 화면 처리 함수 :: List processing functions, screen
	function fn_moveUserList(){
		var form = document.frm_user_detail;
		form.target = "_top";
		form.action = "/ed/user/moveUser.do";
		form.submit();
	}
	
	function fn_goPage(exDocType) {

		var form = document.frm_user_detail;
		
		form.exDocType.value = exDocType;
		
		form.action = "/ed/rcv/moveCtDocList.do";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body id="body_admin" data-new-gr-c-s-check-loaded="14.1008.0" data-gr-ext-installed="">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
		<div class="top">
			<img src=".../images/admin_top.jpg" alt="top">
		</div>
	  <div class="gnb">
			<div id="language_select">	<ul class="horizontal_list">		<li><a href="/setLocale.do?lang=fr" target="_top">Fre</a></li>		<li><a href="/setLocale.do?lang=en" target="_top">Eng</a></li>	
			</ul></div>
		</div>
	  <div class="con_wrap">
			<div class="menu">
				<ul>
					 
					<ul>
						<li class="depth2">Gestion d'Utilisateur</li>
							
						<ul>
							  <li><a href="javascript:fn_logOut();">Déconnexion</a></li>
							  <li><a href="/ed/user/moveUserDetail.do" class="bullet">Mes Informations</a></li>
					  </ul>
					  
						<li class="depth2">
							  <p class="sline">Acquisition des DAO</p>
							  <ul>
							    <li><a href="/ed/rcv/movePubPaymentList.do">Quittances du Frais d'Acquisition du DAO </a></li>
					      </ul>
					    </li>
							<li>Liste des Pièces Soumises 
							  <ul>
							    <li><a href="#" onClick="javascript:fn_goPage('ETC')">Autres</a></li>
						      </ul>
							</li>
				    </ul>
			    </ul>
			</div><!-- //menu END -->
			
			<div class="content" id="contents">
			  <blockquote>
			    <h1 class="h1_title">
			      Modifier Mes Informations
		        </h1>
		      </blockquote>
            <form action="<?php echo $editFormAction; ?>" method="post" name="frm_user_update" id="frm_user_update">
			<table class="data">
								<caption>Mes Informations</caption>
								<colgroup>
									<col style="width: 18%">
									<col style="width: *%">
								</colgroup>
			 <tbody>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">ID Utilisateur</td>
                  <td><?php echo htmlentities($row_Recordset['user_name'], ENT_COMPAT, 'utf-8'); ?><?php echo htmlentities($row_Recordset['user_lastname'], ENT_COMPAT, 'utf-8'); ?></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">User_login:</td>
                  <td><?php echo htmlentities($row_Recordset['user_login'], ENT_COMPAT, 'utf-8'); ?></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Mot de passe</td>
                  <td><input type="hidden" name="user_password" value="<?php echo htmlentities($row_Recordset['user_password'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
                  <input type="text" name="user_password2" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Verifier mot de passe</td>
                  <td><input type="text" name="user_password3" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Groupe:</td>
                  <td><select name="user_groupe_id">
                    <?php
            do {  
            ?>
                    <option value="<?php echo $row_Recordset1['groupe_id']?>"<?php if (!(strcmp($row_Recordset1['groupe_id'], htmlentities($row_Recordset['user_groupe_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['groupe_lib']?></option>
                    <?php
            } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
              $rows = mysql_num_rows($Recordset1);
              if($rows > 0) {
                  mysql_data_seek($Recordset1, 0);
                  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
              }
            ?>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Service Emetteur</td>
                  <td><select name="structure_id">
                    <?php
            do {  
            ?>
                    <option value="<?php echo $row_Recordset2['structure_id']?>"<?php if (!(strcmp($row_Recordset2['structure_id'], htmlentities($row_Recordset['structure_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['structure_lib']?></option>
                    <?php
            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
              $rows = mysql_num_rows($Recordset2);
              if($rows > 0) {
                  mysql_data_seek($Recordset2, 0);
                  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
              }
            ?>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Question scerete</td>
                  <td><select name="user_question">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Recordset3['user_question']?>"<?php if (!(strcmp($row_Recordset3['user_question'], $row_Recordset['user_question']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset3['user_question']?></option>
                    <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Reponse question secrete </td>
                  <td><input type="text" name="user_answer" value="<?php echo htmlentities($row_Recordset['user_answer'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Active?</td>
                  <td><input type="checkbox" name="display_agescom" value=""  <?php if (!(strcmp(htmlentities($row_Recordset['display_agescom'], ENT_COMPAT, 'utf-8'),1))) {echo "checked=\"checked\"";} ?> /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Validateur</td>
                  <td><input type="text" name="personne_id" value="<?php echo htmlentities($row_Recordset['personne_id'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Maitre d'Ouvrage</td>
                  <td><input type="text" name="supplierNm" value="<?php echo htmlentities($row_Recordset['supplierNm'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">N° de téléphone</td>
                  <td><input type="text" name="telNo" value="<?php echo htmlentities($row_Recordset['telNo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">e-Mail:</td>
                  <td><input type="text" name="eMail" value="<?php echo htmlentities($row_Recordset['eMail'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">AcceptYn:</td>
                  <td><select name="acceptYn">
                    <?php
            do {  
            ?>
                    <option value="<?php echo $row_Recordset1['groupe_id']?>"<?php if (!(strcmp($row_Recordset1['groupe_id'], htmlentities($row_Recordset['acceptYn'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['groupe_lib']?></option>
                    <?php
            } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
              $rows = mysql_num_rows($Recordset1);
              if($rows > 0) {
                  mysql_data_seek($Recordset1, 0);
                  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
              }
            ?>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">UserAuthNm:</td>
                  <td><select name="userAuthNm">
                    <?php
            do {  
            ?>
                    <option value="<?php echo $row_Recordset2['structure_id']?>"<?php if (!(strcmp($row_Recordset2['structure_id'], htmlentities($row_Recordset['userAuthNm'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['structure_lib']?></option>
                    <?php
            } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
              $rows = mysql_num_rows($Recordset2);
              if($rows > 0) {
                  mysql_data_seek($Recordset2, 0);
                  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
              }
            ?>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Addr:</td>
                  <td><input type="text" name="addr" value="<?php echo htmlentities($row_Recordset['addr'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">FaxNo:</td>
                  <td><input type="text" name="faxNo" value="<?php echo htmlentities($row_Recordset['faxNo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Mettre &agrave; jour l'enregistrement" /></td>
                </tr>
              </table>
              <blockquote>
                <p>
                  <input type="hidden" name="dateUpdate" value="<?php echo htmlentities($row_Recordset['dateUpdate'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="compteur" value="<?php echo htmlentities($row_Recordset['compteur'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="user_connected" value="<?php echo htmlentities($row_Recordset['user_connected'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="regDt" value="<?php echo htmlentities($row_Recordset['regDt'], ENT_COMPAT, 'utf-8'); ?>" />
                  <input type="hidden" name="MM_update" value="form1" />
                  <input type="hidden" name="user_id" value="<?php echo $row_Recordset['user_id']; ?>" />
                </p>
              </blockquote>
            </form>
				<div class="fR pt10 mb20">
					<blockquote>
					  <p><span class="btnTy21"><input type="button" class="btn" value="Modifier" onClick="javascript:fn_moveUserUpdate();"></span>
				      </p>
				  </blockquote>
				</div>
			</div><!-- //content END -->
	    <div id="copy_w">
          <blockquote>
            <p class="fL">&nbsp;</p>
            <p class="fL ml20">&nbsp;</p>
            <p class="fR mt15">&nbsp;</p>
          </blockquote>
        </div>
<script type="text/javaScript" language="javascript">

    if ((navigator.userAgent.indexOf('MSIE 6')>0) && (navigator.userAgent.indexOf('MSIE 7')==-1)){

        util_messageAlertWithExec("Il se peut que les pages ne fonctionnent pas correctement sous l'environnement Internet Explorer 6 et 7. Veuillez mettre à jour votre navigateur au dessus d’IE 8 ou utiliser d'autres navigateurs tels que Chrome, Firefox.", "fn_moveMain()");

		   function fn_moveMain(){
		       location.href='http://179.18.0.96/'
		   }
    }

</script>

		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->

</body>
</html>

<?php
mysql_free_result($Recordset);

mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
