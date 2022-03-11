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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Enregistrement d'Utilisateur</title>
<link rel="stylesheet" href="../css/common.css" media="all">
<style type="text/css"> 
	html {overflow:hidden;}  
</style>  
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
    var systime ="May 12, 2021 10:10:32";
    var systimeStr ="202105121010321032";
    var today ="20210512";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="12/05/2021";
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

    function validateFrm_user_insert(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateRequired(form) && validateMaxLength(form) && validateMask(form) && validateEmail(form); 
   } 

    function required () { 
     this.aa = new Array("userId", "ID d'Utilisateur", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "Service Emetteur", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("userAuth", "Autorisation Utilisateur", new Function ("varName", " return this[varName];"));
     this.af = new Array("addr", "Adresse", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("telNo", "N° de Téléphone", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ah = new Array("faxNo", "N° de Fax", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ai = new Array("eMail", "e-Mail", new Function ("varName", "this.maxlength='240';  return this[varName];"));
     this.aj = new Array("capAnswer", "CAPTCHA", new Function ("varName", "this.maxlength='10';  return this[varName];"));
    } 

    function maxlength () { 
     this.aa = new Array("userId", "ID d'Utilisateur can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe can not be greater than 6 characters(korean 3characters).", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe can not be greater than 6 characters(korean 3characters).", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "Service Emetteur can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("addr", "Adresse can not be greater than 250 characters(korean 3characters).", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.af = new Array("telNo", "N° de Téléphone can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("faxNo", "N° de Fax can not be greater than 20 characters(korean 3characters).", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ah = new Array("eMail", "e-Mail can not be greater than 40 characters(korean 3characters).", new Function ("varName", "this.maxlength='240';  return this[varName];"));
     this.ai = new Array("capAnswer", "CAPTCHA can not be greater than 40 characters(korean 3characters).", new Function ("varName", "this.maxlength='10';  return this[varName];"));
    } 

    function mask () { 
     this.aa = new Array("userId", "ID d'Utilisateur is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ab = new Array("userPw", "Mot de Passe is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ac = new Array("confirmPw", "Vérifier Mot de Passe is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='6'; this.mask=/^[0-9|A-Z|a-z| ]*$/;  return this[varName];"));
     this.ad = new Array("supplierNm", "Service Emetteur is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='200'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ae = new Array("addr", "Adresse is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='250'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.af = new Array("telNo", "N° de Téléphone is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
     this.ag = new Array("faxNo", "N° de Fax is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='20'; this.mask=/^[0-9|A-Z|a-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝| ]*$/;  return this[varName];"));
    } 

    function email () { 
     this.aa = new Array("eMail", "e-Mail is an invalid e-mail address.", new Function ("varName", "this.maxlength='240';  return this[varName];"));
    } 


</script>


<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/alertExms.js"></script>
<script type="text/javascript" src="../js/common/validation.js" ></script>
<script type="text/javascript" src="../js/common/frame.js" ></script>
<script type="text/javascript" src="../js/common/ajax.js" ></script>
<script type="text/javascript" src="../js/common/string.js" ></script>
<script type="text/javascript" src="../js/common/event.js" ></script>
<script type="text/javaScript" language="javascript">
	
	
	
	//작성 내용 저장 :: Save Information
	function fn_insertUser(){
		
		var form = document.frm_user_insert;

		util_trimRequiredValue(form);
		
		if(!validateFrm_user_insert(form)){
			return;
		} else {
			if(!fn_chkPwDup()){
				return;
			} 
	
			if(form.idRegisted.value == 'Y'){
				util_messageAlertOnPopup("Le nom d'utilisateur n'est pas disponible.");
				form.userId.focus();
				return;
			}
	
			/*if(form.idChanged.value == 'N'){
				util_confirmAlertOnPopup("Voulez-vous enregistrer?", 'fn_submitInsertUser()');
			}else{
				util_confirmAlertOnPopup("Valeur d'ID a été modifié. Veuillez confirmer.");
			} */
			util_confirmAlertOnPopup("Voulez-vous enregistrer?", 'fn_submitInsertUser()');
		}
	 }
	
	//Form Submit
	function fn_submitInsertUser(){
		var form = document.frm_user_insert;
		//form.action = "../Ctrl/UserRegCtrl.php";
		form.action = "<?php echo $editFormAction; ?>";
		
		form.target = "ResultFrame";
		form.submit();
	}
	
	//특수문자체크
	function isValid(str){
		 return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\:<>\?]/g.test(str);
	}
	
	//ID 중복체크 :: check ID duplicate
	function fn_chkIdDuplicate(){
		var form = document.frm_user_insert;
		form.idChanged.value="Y";
		if(form.userId.value == ''){
			util_messageAlertOnPopup("Saisissez l'ID.");
			form.userId.focus();
			return;
		}else if (!isValid(form.userId.value)){
			util_messageAlertOnPopup("Cette valeur contient des caractères spéciaux. Veuillez utiliser des chiffres et les lettres.");
			form.userId.value="";
			return;
		}
	
		util_trimRequiredValue(form);
	
		var url = "/ed/user/checkUserDuplicate.do" + "?userId=" + form.userId.value;
	    AutoComplete.ContentLoader(url, fn_checkDupResult);
	}
	
	//중복 처리 결과확인 :: check duplicate result
	function fn_checkDupResult(){
		if(AutoComplete.getState()){
			var form = document.frm_user_insert;
			var result = xmlHttp.responseText;
			if(result == "success"){
				form.checkResult.value = "Le nom d'utilisateur choisi est disponible.";	//사용 가능한 아이디입니다.
				form.idRegisted.value="N";
				form.idChanged.value="N";
			}else{
				form.checkResult.value = "Ce nom d'utilisateur est deja utilisé"; //중복된 아이디입니다.
				form.idRegisted.value="Y";
				form.idChanged.value="N";
			}
		}
	}
	
	
	//패스워드 확인 체크 :: Check password Confirm
	function fn_chkPwDup(){
		var form = document.frm_user_insert;
		var pwVar = form.userPw.value;
		var confVar = form.confirmPw.value;
	
		if(pwVar != confVar){
			util_messageAlertOnPopup("Le mot de passe n'est pas identique.");
			form.userPw.value='';
			form.confirmPw.value='';
			form.userPw.focus();
			return false;
		}
		return true;
	}
	
</script>
</head>

<body>
<div id="popup_main">
<div id="popWrap">
	<!-- Layout : header Area -->
	<div id="pop_header" class="popHeader">
		<h1 class="title">Enregistrement d'Utilisateur</h1>
		<button class="Close" title="Fermer"	onclick="window.close();">
			Fermer
	  </button>
	</div>
	<!-- //Layout : header Area -->

	<!-- Layout : container Area -->
	<div id="popup_contents" class="popContainer"> 
		<div class="tableTy2">
			<div class="dataArea">
				<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
				<form id="frm_user_insert" name="frm_user_insert" method="post">
					<input type="hidden" name="searchConditions" value="">
					<input type="hidden" name="currentPageNo" value="1">
					<input type="hidden" name="isBack" value="">
					<input type="hidden" name="idChanged">
					<input type="hidden" name="idRegisted">
                    <input type="hidden" name="user_groupe_id" value="2">
                    <input type="hidden" name="structure_id" value="894">
                    <input type="hidden" name="compteur" value="0">
					<input type="hidden" name="MM_insert" value="frm_user_insert">
				  <table class="data">
						<colgroup>
							<col style="width: 25%">
							<col style="width: *">
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="userId">ID d'Utilisateur</label></th>
								<td>
									<input type="text" class="text"  id="userId" style="width: 30%" name="userId" maxlength="20">&nbsp;<span class="btnTy3">
									<input type="button" class="btn" value="Verifier la Disponibilité" onClick="javascript:fn_chkIdDuplicate();"></span> <input type="text" id="checkResult" readonly="readonly" style="font-weight: bold; border: 0; width: 40%;">
								</td>
							</tr>
							<tr>
								<th scope="row">Nom
							    <label for="userPw"></label></th>
								<td><input type="text" class="text"  id="user_name" style="width: 50%" name="user_name" maxlength="50"></td>
							</tr>
							<tr>
								<th scope="row"><label for="userPw">Prenom</label></th>
							  <td><input type="text" class="text"  id="user_lastname" style="width: 50%" name="user_lastname" maxlength="50"></td>
							</tr>
                            							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="userPw">Mot de Passe</label></th>
								<td><input type="password" class="text"  id="userPw" style="width: 50%" name="userPw" maxlength="6"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2" >*</em><label for="confirmPw">Vérifiez mot de passe.</label></th>
								<td><input type="password" class="text"  id="confirmPw" style="width: 50%" name="confirmPw" maxlength="6"><?php //echo $_SERVER['PHP_SELF'] ?></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="supplierNm">Service Emetteur</label></th>
								<td><input type="text" class="text"  id="supplierNm" style="width: 70%" name="supplierNm" maxlength="200"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="user_cl_nm">Groupe d'utilisateurs</label></th>
								<td>
									<select id="userAuth" name="userAuth" onChange="" class="selectbox">
										<option value="">::: Sélection</option>
							  			
							  				<option value="U">Utilisateur</option>
							  				<option value="A">Administrateur</option>
							  			
									</select> 	
								</td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="addr">Adresse</label></th>
								<td><input type="text" class="text"  id="addr" style="width: 80%" name="addr" maxlength="250"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="telNo">Numéro de Téléphone</label></th>
								<td><input type="text" class="text"  id="telNo" style="width: 50%" name="telNo" maxlength="20" onKeyDown="javascript:util_checkNumberWithSome(this, event)"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="faxNo">Numéro de Fax</label></th>
								<td><input type="text" class="text"  id="faxNo" style="width: 50%" name="faxNo" maxlength="20" onKeyDown="javascript:util_checkNumberWithSome(this, event)"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em><label for="eMail">e-Mail</label></th>
								<td><input type="text" class="text"  id="eMail" style="width: 60%" name="eMail" maxlength="40"
													onblur="javascript:util_checkEmailObj(this); javascript:util_checkLength(this, 40);"></td>
							</tr>
							<tr>
								<th scope="row"><em class="pointTxt2">*</em>Question Secrete</th>
								<td>
								  <select name="user_question" id="select" class="selectbox">
								    <option value="">::: Sélection</option>
								    <option value="Le prenom de votre compagne">Le prenom de votre compagne</option>
								    <option value="Le prenom de votre premier enfant">Le prenom de votre premier enfant</option>
								    <option value="Le prenom de votre grande mere">Le prenom de votre grande mere</option>
								    <option value="Votre mot de passe mail">Votre mot de passe yahoo.mail</option>
								    <option value="Le code de votre smart phone">Le code de votre smart phone</option>
						      </select></td>
							</tr>
                            <tr>
								<th scope="row"><em class="pointTxt2">*</em>Reponse</th>
								<td>
									<input type="password" id="user_answer" name="user_answer" align="middle">
							  </td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
  </div>
		<!-- //입력폼 끝 -->
		<!-- //Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><input type="button" class="btn" value="Demander Inscription" onClick="javascript:fn_insertUser();"></span> <span class="btnTy4"><button class="btn" onClick="window.close();">Fermer</button>
			</span>
		</div>
		<!-- //Layout : Button Area -->
	</div>
</div>
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div>
</body>
</html>