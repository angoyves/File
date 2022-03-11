<?php //require('../CtrL/UserUpdateCtrl.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_user_update")) {
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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
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
    var systime ="May 10, 2021 21:49:31";
    var systimeStr ="202105102149314931";
    var today ="20210510";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="10/05/2021";
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
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javascript" src="../js/common/frame.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javaScript" language="javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}

	//작성 내용 저장 :: Save Information
	function fn_saveUser(){
		var form = document.frm_user_update;
		util_trimRequiredValue(form);
		if(!validateFrm_user_update(form)){
			return;
		} else {
			if(!fn_chkPwDup()){
				return;
			}
			util_confirmAlert("Voulez-vous sauvegarder?","fn_submitSaveUser()");
		}
	}

	//Form Submit
	function fn_submitSaveUser(){
		var form = document.frm_user_update;
	
		//처리중 이미지 만들기
		//util_showExecutionImage();
	
		form.action = "<?php echo $editFormAction; ?>";
		form.target = "ResultFrame";
		form.submit();
	}

	//패스워드 자리수 체크 :: Check password length
	function fn_chkPwLen(){
		var form = document.frm_user_update;
		var len = form.userPw.value.length;
		if( len < 4 && len > 0 ){
			util_messageAlert("null");
			form.userPw.focus();
		}
	}

	//패스워드 확인 체크 :: Check password Confirm
	function fn_chkPwDup(){
		var form = document.frm_user_update;
		var pwVar = form.userPw.value;
		var confVar = form.confirmPw.value;
		if(pwVar != confVar){
			util_messageAlert("null");
			form.userPw.value='';
			form.confirmPw.value='';
			form.userPw.focus();
			return false;
		}
		return true;
	}

	//상세조회화면으로 이동
	function fn_moveUserDetail(){
		var form = document.frm_user_update;
		//form.isBack.value = "N";
		form.target = "_top";
		form.action = "UserDetails.php";
		form.submit();
	}

	function fn_goPage(exDocType) {

		var form = document.frm_user_update;
		
		form.exDocType.value = exDocType;
		
		form.action = "/ed/rcv/moveCtDocList.do";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body  id="body_admin">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
		<div class="top">
			<img src="../images/admin_top_agescom.jpg" alt="top">
		</div>
		<div class="gnb">
			<div id="language_select">	<ul class="horizontal_list">		<li><a href="/setLocale.do?lang=fr" target="_top">Fre</a></li>		<li><a href="/setLocale.do?lang=en" target="_top">Eng</a></li>			</ul></div>
		</div>
		<div class="con_wrap">
			<div class="menu">
				<ul>
					<li class="depth1_on"><p class="sline">Gestion d'Utilisateur</p> 
						<ul>
							<li class="depth2"><a href="javascript:fn_logOut();">Déconnexion</a></li>
							
							<li class="depth2"><a href="UsersReg.php">Utilisateurs</a></li>
							
							<li class="depth2_on"><p class="bullet"><a href="UserDetails.php">Mes Informations</a></p></li>
						</ul>
					</li>
					
					
					
					
					<!--<li class="depth1_none"><p class="sline">Gestion d'Information Master</p>
						<ul>
							<li class="depth2"><a href="/ed/master/moveLangList.do">Gestion des langues</a></li>
							<li class="depth2"><a href="/ed/master/moveMappingInfoList.do">Mapping d'Informations</a></li>
							<li class="depth2"><a href="/ed/master/moveCodeTypeList.do">Classification des Codes</a></li>
							<li class="depth2"><a href="/ed/master/moveCodeList.do">Gestion des codes</a></li>
						</ul>
					</li>-->
					
				</ul>
			</div><!-- //menu END -->
			
			<div class="content" id="contents">
				<div id="layout_form">
				  <h1 class="h1_title"> Modifier Mes Informations </h1>
				  <h2 class="bullet1">
					  Information de l'Utilisateur
					</h2>
					<div class="tableTy1">
						<div class="dataArea">
					  <form id="frm_user_update" name="frm_user_update" method="post">
								<input type="hidden" name="searchConditions" value="">
								<input type="hidden" name="currentPageNo" value="0">
								<input type="hidden" name="isBack" value="">
								<input type="hidden" name="userAuth" value="A">
								<input type="hidden" name="acceptYn" value="N">
								<input type="hidden" name="userId" value="administrator">
							  	<input type="hidden" name="isFlag" value="">
								<input type="hidden" name="exDocType">
                                <input type="hidden" name="MM_update" value="frm_user_update">
  <table class="data">
								  <caption>Information de l'Utilisateur</caption>
								  <colgroup>
									  <col style="width: 20%">
									  <col style="width: *">
								  </colgroup>
									<tbody>
                                      
                                      
                                
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">User_login:</th>
                  <td><?php echo htmlentities($row_Recordset['user_login'], ENT_COMPAT, 'utf-8'); ?></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL"><em class="pointTxt2" >*</em>Mot de passe</th>
                  <td><input type="hidden" name="user_password" value="<?php echo htmlentities($row_Recordset['user_password'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
                  <input type="password" id="userPw" name="userPw" value="" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL"><em class="pointTxt2" >*</em>Verifier mot de passe</th>
                  <td><input type="password" id="confirmPw" name="confirmPw" value="" size="32" /></td>
                </tr>
                
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">Service Emetteur</th>
                  <td><input type="text" name="supplierNm" value="<?php echo htmlentities($row_Recordset['supplierNm'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">N° de téléphone</th>
                  <td><input type="text" name="telNo" value="<?php echo htmlentities($row_Recordset['telNo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">e-Mail</th>
                  <td><input type="text" name="eMail" value="<?php echo htmlentities($row_Recordset['eMail'], ENT_COMPAT, 'utf-8'); ?>" size="32" maxlength="40" onBlur="javascript:util_checkValidation(this, '^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$',50)" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">Addr</th>
                  <td><input type="text" name="addr" value="<?php echo htmlentities($row_Recordset['addr'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">FaxNo</th>
                  <td><input type="text" name="faxNo" value="<?php echo htmlentities($row_Recordset['faxNo'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                  <th scope="row" class="noLine tL">Question secrete</th>
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
                  <th scope="row" class="noLine tL">Reponse question secrete </th>
                  <td><input type="password" name="user_answer" value="<?php echo htmlentities($row_Recordset['user_answer'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                                      
                                      
									</tbody>
							  </table>
						  </form>
						</div>
					</div>
					<div class="fR pt10 mb20">
						<span class="btnTy21"><input type="button" class="btn" value="Sauvegarder" onClick="javascript:fn_saveUser();"></span> <span class="btnTy21"><input type="button" class="btn" value="Retour" onClick="javascript:fn_moveUserDetail();"></span>
					</div>
			  </div>
			</div><!-- //content END -->
			    <div id="copy_w">
        <p class="fL">&nbsp;</p>
        <p class="fL ml20">&nbsp;</p>
        <p class="fR mt15">&nbsp;</p>
    </div>
<script type="text/javaScript" language="javascript">

    if ((navigator.userAgent.indexOf('MSIE 6')>0) && (navigator.userAgent.indexOf('MSIE 7')==-1)){

        util_messageAlertWithExec("Il se peut que les pages ne fonctionnent pas correctement sous l'environnement Internet Explorer 6 et 7. Veuillez mettre à jour votre navigateur au dessus d’IE 8 ou utiliser d'autres navigateurs tels que Chrome, Firefox.", "fn_moveMain()");

		   function fn_moveMain(){
		       location.href='http://178.18.0.96/'
		   } 	
    }

</script>

		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div><!-- //main END -->
</body>
</html>