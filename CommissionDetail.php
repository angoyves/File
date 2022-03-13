<?php require_once('Connections/MyFileConnect.php'); ?>
<?php 
	require('includes/inc/db.php');
	require("inc/biblio.inc.php");
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

$colname_Recordset = "-1";
if (isset($_GET['bizRegNo'])) {
  $colname_Recordset = $_GET['bizRegNo'];
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_id = %s", GetSQLValueString($colname_Recordset, "int"));
$Recordset = mysql_query($query_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

$colname_rsMembresCommission = "-1";
if (isset($_GET['bizRegNo'])) {
  $colname_rsMembresCommission = $_GET['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsMembresCommission = sprintf("SELECT personne_id, personne_nom, personne_prenom, fonctions_fonction_id, fonction_lib, personnes.structure_id, personne_telephone   FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", GetSQLValueString($colname_rsMembresCommission, "int"));
$rsMembresCommission = mysql_query($query_rsMembresCommission, $MyFileConnect) or die(mysql_error());
$row_rsMembresCommission = mysql_fetch_assoc($rsMembresCommission);
$totalRows_rsMembresCommission = mysql_num_rows($rsMembresCommission);

$colname_Recordset1 = "-1";
if (isset($_GET['bizRegNo'])) {
  $colname_Recordset1 = $_GET['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset1 = sprintf("SELECT * FROM fichiers WHERE commissions_commission_id = %s ORDER BY fichierID DESC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $MyFileConnect) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Details Commission</title>
<link rel="stylesheet" href="css/common.css" media="all">
<style type="text/css"> 
	html {overflow:hidden;}  
</style>  
<script type="text/javaScript" src="js/common/font.js"></script>
<script type="text/javaScript" src="js/common/alert.js"></script>
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


<script type="text/javascript" src="js/common/font.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/alertExms.js"></script>
<script type="text/javascript" src="js/common/validation.js" ></script>
<script type="text/javascript" src="js/common/frame.js" ></script>
<script type="text/javascript" src="js/common/ajax.js" ></script>
<script type="text/javascript" src="js/common/string.js" ></script>
<script type="text/javascript" src="js/common/event.js" ></script>
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
		form.action = "../Ctrl/UserRegCtrl.php";
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
	function fn_Print(exParaType){
		var form = document.frm_pubCommission_detail;
		form.target = "_top";
		form.action = "etats/commissionPrint.php";
		//form.action = "etats/Test.php";
		form.submit();
	}	
</script>
</head>

<body>
<div id="popup_main">
<div id="popWrap">
	<!-- Layout : header Area -->
	<div id="pop_header" class="popHeader">
		<h1 class="title">Details Commissions</h1>
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
	  <form name="frm_pubCommission_detail" method="post">
					<div class="tableTy1">
					  <div class="dataArea">
							<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
							<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
							<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
							<input type="hidden" name="bidNo" value="${RcvSVO.bidNo}">
						  <input type="hidden" name="exDocType" />
                            <input type="hidden" name="bizRegNo" value="<?php echo $_GET['bizRegNo'] ?>"/>
                            
						  <h2 class="bullet1 mt20">Information sur la commission de passation des marches&nbsp;</h2><table class="data">
							  <caption><?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='1stSubtitle'); ?></caption>
							  <colgroup>
								  <col style="width: 20%">
								  <col style="width: 80%">
							  </colgroup>
							  <tbody>
								  <tr>
									  <th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='bidNo'); ?>Sigle</th>
									  <td><?php echo strtoupper($row_Recordset['commission_sigle']); ?></td>
								  </tr>
								  <tr>
									  <th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='bidNm'); ?>Designation</th>
									  <td><?php echo strtoupper($row_Recordset['commission_lib']); ?></td>
								  </tr>
							  </tbody>
						  </table>
						</div>
					</div>
                    <h2 class="bullet1 mt20">Membres&nbsp;</h2>
                  <div class="tableTy1">
                   
  <table class="data">
    <caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></caption>
    <colgroup>
      <col style="width: 40%">
      <col style="width: 35%">
      <col style="width: *%">
      </colgroup>
    <thead>
      <tr>
        <th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='rowNum'); ?>Noms et prenoms</th>
        <th scope="col">Fonction<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypeNm'); ?></th>
        <th scope="col">Contact</th>
        </tr>
    </thead>
    <tbody>
      <?php do { ?>
  <tr>
    <td nowrap><img src="images/icons/young-user-icon.jpg" width="18" height="16">&nbsp;<?php echo strtoupper($row_rsMembresCommission['personne_nom']) .' '. strtoupper($row_rsMembresCommission['personne_prenom']); ?></td>
    <td><?php echo $row_rsMembresCommission['fonction_lib']; ?></td>
    <td><a href="#" onClick="javascript:util_downloadFileByFullPath(); return false;"></a>
      <iframe name="attachFileFrame" width="0" height="0" frameborder="0"></iframe><?php echo $row_rsMembresCommission['personne_telephone']; ?></td>
  </tr>
<?php } while ($row_rsMembresCommission = mysql_fetch_assoc($rsMembresCommission)); ?> 
 <?php if ($totalRows_rsMembresCommission == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="3" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId='common_no_result_msg'); ?></td>
      </tr>
     <?php } // Show if recordset empty ?>
    </tbody>
  </table>
  
<p>&nbsp;</p>
                  </div>
					<h2 class="bullet1 mt20"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></h2>
					<div class="tableTy1">
						<table class="data">
							<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></caption>
							<colgroup>
								<col style="width: 15%">
								<col style="width: 35%">
								<col style="width: 50%">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='rowNum'); ?>Numero</th>
									<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypeNm'); ?>Nom document</th>
									<th scope="col">Fichier<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypePath'); ?></th>
								</tr>
							</thead>
							<tbody>
								
                                    <?php $i=0; do { ?>
                                        <?php if ($totalRows_Recordset1 > 0) { $i++;// Show if recordset not empty ?>
                                          <tr>
                                            <td class="tC"><?php echo $i; //$row_Recordset1['fichierID']; ?></td>
                                            <td class="tC"><?php echo $row_Recordset1['nomFichier']; ?></td>
                                            <td class="tC">
                                            <a href="#" onClick="<?php popup(htmlentities($row_Recordset1['url']), "710", "650"); ?>"; return false;">
                                            <img src="images/img/b_pdfdoc.png" width="16" height="16" />
                                            </a>
            								<a href="#" onClick="javascript:util_downloadFileByFullPath('C:/wamp/www/Portal/AGesCom/file', <?php echo $row_Recordset1['url']; ?>, 'MyName'); return false;>
                                              <iframe name="attachFileFrame" width="0" height="0" frameborder="0"></iframe>
                                            </a></td>
                                          </tr>
                                          <?php } // Show if recordset not empty ?>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="3" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId='common_no_result_msg'); ?></td>
  </tr>
  <?php } // Show if recordset empty ?>
                            </tbody>
						</table>
				  </div>
				</form>
			</div>
  </div>
		<!-- //입력폼 끝 -->
		<!-- //Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter"><span class="btnTy4"><button class="btn" onClick="javascript:fn_Print();">Imprimer</button>
        
			</span><span class="btnTy4"><button class="btn" onClick="window.close();">Fermer</button>
        
			</span>
		</div>
		<!-- //Layout : Button Area -->
	</div>
</div>
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div>
</body>
</html>