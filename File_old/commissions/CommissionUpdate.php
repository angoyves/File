<?php require('../CtrL/UserUpdateCtrl.php'); ?>
<?php require_once('../Connections/MyFileConnect.php');
	  require('../../includes/controler.php');
?>

<?php

$typecommissionIsEmpty = false;
$natureIsEmpty = false;
$localiteIsEmpty = false;

if (isset($_POST['type_commission_id']) && $_POST['type_commission_id'] == ""){
$typecommissionIsEmpty = true; }
if (isset($_POST['nature_id']) && $_POST['nature_id'] == ""){
$natureIsEmpty = true; }
if (isset($_POST['localite_id']) && $_POST['localite_id'] == ""){
$localiteIsEmpty = true; }

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

echo $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frm_commission_update")) {
  $updateSQL = sprintf("UPDATE commissions SET localite_id=%s, type_commission_id=%s, nature_id=%s, structure_id=%s, region_id=%s, departement_id=%s, user_id=%s, commission_lib=%s, commission_sigle=%s, commission_parent=%s, montant_cumul=%s, nombre_offre=%s, membre_insert=%s, dateCreation=%s, dateUpdate=%s, display=%s WHERE commission_id=%s",
                       GetSQLValueString($_POST['localite_id'], "int"),
                       GetSQLValueString($_POST['type_commission_id'], "int"),
                       GetSQLValueString($_POST['nature_id'], "int"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['region_id'], "int"),
					   GetSQLValueString($_POST['departement_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['commission_lib'], "text"),
					   GetSQLValueString($_POST['commission_sigle'], "text"),
                       GetSQLValueString($_POST['commission_parent'], "int"),
                       GetSQLValueString($_POST['montant_cumul'], "text"),
                       GetSQLValueString($_POST['nombre_offre'], "text"),
                       GetSQLValueString($_POST['membre_insert'], "text"),
                       GetSQLValueString($_POST['dateCreation'], "date"),
                       GetSQLValueString($date, "date"),
                       GetSQLValueString(isset($_POST['display']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['commission_id'], "int"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($updateSQL, $MyFileConnect) or die(mysql_error());
  
  /*$updateGoTo = "detail_commission.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));  
      echo "<script type='".text/javascript."' onLoad> 
		var form = document.frm_commission_update;
		form.bizRegNo =".$_POST['bizRegNo']."
		form.target = '_top';
		form.action = 'CommissionDetails.php';
		form.submit();
		</script>";*/
		
		$opts = array('http' =>array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $_POST['bizRegNo']));
		$context = stream_context_create($opts);
		$result = file_get_contents($editFormAction, false, $context);
}

$colname_updCommission = "-1";
if (isset($_POST['bizRegNo'])) {
  $colname_updCommission = $_POST['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
//$query_updCommission = sprintf("SELECT commissions.*, localite_lib, type_commission_lib, lib_nature, region_lib FROM commissions, localites, type_commissions, natures, structures, regions WHERE commissions.localite_id = localites.localite_id AND commissions.type_commission_id = type_commissions.type_commission_id AND commissions.nature_id = natures.nature_id AND commissions.structure_id = structures.structure_id AND commissions.region_id = regions.region_id AND commission_id = %s", GetSQLValueString($colname_updCommission, "int"));
$query_updCommission = sprintf("SELECT * FROM commissions WHERE commission_id = %s", GetSQLValueString($colname_updCommission, "int"));
$updCommission = mysql_query($query_updCommission, $MyFileConnect) or die(mysql_error());
$row_updCommission = mysql_fetch_assoc($updCommission);
$totalRows_updCommission = mysql_num_rows($updCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = "SELECT localite_id, localite_lib FROM localites WHERE display = '1' ORDER BY localite_lib ASC";
$rsLocalites = mysql_query($query_rsLocalites, $MyFileConnect) or die(mysql_error());
$row_rsLocalites = mysql_fetch_assoc($rsLocalites);
$totalRows_rsLocalites = mysql_num_rows($rsLocalites);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeCommission = "SELECT type_commission_id, type_commission_lib FROM type_commissions WHERE display = '1' ORDER BY type_commission_lib ASC";
$rsTypeCommission = mysql_query($query_rsTypeCommission, $MyFileConnect) or die(mysql_error());
$row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
$totalRows_rsTypeCommission = mysql_num_rows($rsTypeCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsNatureCommission = "SELECT nature_id, lib_nature FROM natures WHERE display = '1' ORDER BY lib_nature ASC";
$rsNatureCommission = mysql_query($query_rsNatureCommission, $MyFileConnect) or die(mysql_error());
$row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
$totalRows_rsNatureCommission = mysql_num_rows($rsNatureCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = "SELECT structure_id, code_structure, structure_lib FROM structures WHERE display = '1' ORDER BY code_structure ASC";
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsDepartement = "SELECT departement_id, departement_code, departement_lib FROM departements ORDER BY departement_lib ASC";
$rsDepartement = mysql_query($query_rsDepartement, $MyFileConnect) or die(mysql_error());
$row_Departement = mysql_fetch_assoc($rsDepartement);
$totalRows_Departement = mysql_num_rows($Departement);
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
		var form = document.frm_commission_update;
		util_trimRequiredValue(form);
		util_confirmAlert("Voulez-vous sauvegarder?","fn_submitSaveUser()");
		/*if(!validateFrm_user_update(form)){
			return;
		} else {
			if(!fn_chkPwDup()){
				return;
			}
			util_confirmAlert("Voulez-vous sauvegarder?","fn_submitSaveUser()");
		}*/
	}

	//Form Submit
	function fn_submitSaveUser(){
		var form = document.frm_commission_update;
	
		//처리중 이미지 만들기
		util_showExecutionImage();
	
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
	function fn_moveCommissionDetail(){
		var form = document.frm_commission_update;
		//form.isBack.value = "N";
		form.target = "_top";
		form.action = "CommissionDetails.php";
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
			<div id="language_select">	<ul class="horizontal_list">		<li><a href="/setLocale.do?lang=fr" target="_top">Fre</a></li>		<li><a href="/setLocale.do?lang=en" target="_top">Eng</a></li>		<li><a href="/setLocale.do?lang=ko" target="_top">Kor</a></li>	</ul></div>
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
				  <h1 class="h1_title"> Modifier la commission</h1>
				  <h2 class="bullet1">
					  Information de la commission</h2>
					<div class="tableTy1">
						<div class="dataArea">
                        <form id="frm_commission_update" name="frm_commission_update" method="post">
                          <table class="data"data"">
                          <caption>Information de l'Utilisateur</caption>
								  <colgroup>
									  <col style="width: 20%">
									  <col style="width: *">
								  </colgroup>
                              <tbody>
                                  <tr valign="baseline">
                                  <th align="right" valign="middle" >ID:</th>
                                  <td ><?php echo $row_updCommission['commission_id']; ?></td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle">Localite:</th>
                                  <td >
                                    <select name="localite_id">
                                      <?php
                            do {  
                            ?>
                                      <option value="<?php echo $row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], htmlentities($row_updCommission['localite_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']);?></option>
                                      <?php
                            } while ($row_rsLocalites = mysql_fetch_assoc($rsLocalites));
                              $rows = mysql_num_rows($rsLocalites);
                              if($rows > 0) {
                                  mysql_data_seek($rsLocalites, 0);
                                  $row_rsLocalites = mysql_fetch_assoc($rsLocalites);
                              }
                            ?>
                                    </select>
                                  </span></td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" >Type commission:</th>
                                  <td class="style1">
                                    <select name="type_commission_id">
                                      <?php
                            do {  
                            ?>
                                      <option value="<?php echo $row_rsTypeCommission['type_commission_id']?>"<?php if (!(strcmp($row_rsTypeCommission['type_commission_id'], $row_updCommission['type_commission_id']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsTypeCommission['type_commission_lib']);?></option>
                                      <?php
                            } while ($row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission));
                              $rows = mysql_num_rows($rsTypeCommission);
                              if($rows > 0) {
                                  mysql_data_seek($rsTypeCommission, 0);
                                  $row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
                              }
                            ?>
                                    </select>
                                  </span></td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" class="style10">Nature:</th>
                                  <td class="style1">
                                    <select name="nature_id">
                                      <?php
                            do {  
                            ?>
                                      <option value="<?php echo $row_rsNatureCommission['nature_id']?>"<?php if (!(strcmp($row_rsNatureCommission['nature_id'], $row_updCommission['nature_id']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsNatureCommission['lib_nature']);?></option>
                                      <?php
                            } while ($row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission));
                              $rows = mysql_num_rows($rsNatureCommission);
                              if($rows > 0) {
                                  mysql_data_seek($rsNatureCommission, 0);
                                  $row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
                              }
                            ?>
                                    </select>
                                  </span></td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" class="style10">Structure:</th>
                                  <td class="style1">
                                    <select name="structure_id">
                                      <?php
                            do {  
                            ?>
                                      <option value="<?php echo $row_rsStructures['structure_id']?>"<?php if (!(strcmp($row_rsStructures['structure_id'], htmlentities($row_updCommission['structure_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsStructures['code_structure']?></option>
                                      <?php
                            } while ($row_rsStructures = mysql_fetch_assoc($rsStructures));
                              $rows = mysql_num_rows($rsStructures);
                              if($rows > 0) {
                                  mysql_data_seek($rsStructures, 0);
                                  $row_rsStructures = mysql_fetch_assoc($rsStructures);
                              }
                            ?>
                                    </select>
                                  </span></td>
                                </tr>
                            
                            
                            
                            
                                <tr valign="baseline">
                                      <th align="right" valign="middle" class="style10">Departement:</th>
                                      <td class="style1"><span class="style6">
                                        <select name="departement_id" id="departement_id">
                                          <?php
                                            do {  
                                            ?>
                                                      <option value="<?php echo $row_rsDepartement['departement_id']?>"<?php if (!(strcmp($row_rsDepartement['departement_id'], htmlentities($row_updCommission['departement_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsDepartement['departement_lib']?></option>
                                                      <?php
                                            } while ($row_rsDepartement = mysql_fetch_assoc($rsDepartement));
                                              $rows = mysql_num_rows($rsDepartement);
                                              if($rows > 0) {
                                                  mysql_data_seek($rsDepartement, 0);
                                                  $row_rsDepartement = mysql_fetch_assoc($rsDepartement);
                                              }
                                        ?>
                                        </select>
                                  </span></td>
                                </tr>
                            
                            
                            
                            
                                <tr valign="baseline">
                                  <th align="right" valign="middle" class="style10">Region:</th>
                                  <td class="style1"><span class="style6">
                                    <select name="region_id">
                                      <?php
                            do {  
                            ?>
                                      <option value="<?php echo $row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], htmlentities($row_updCommission['region_id'], ENT_COMPAT, 'utf-8')))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
                                      <?php
                            } while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
                              $rows = mysql_num_rows($rsRegion);
                              if($rows > 0) {
                                  mysql_data_seek($rsRegion, 0);
                                  $row_rsRegion = mysql_fetch_assoc($rsRegion);
                              }
                            ?>
                                    </select>
                                  </span></td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" class="style10">Commission:</th>
                                  <td class="style1">
                                    <textarea name="commission_lib" cols="50" rows="4" ><?php echo $row_updCommission['commission_lib']; ?></textarea>
                                  </td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" class="style10">Sigle:</th>
                                  <td class="style1">
                                    <textarea name="commission_sigle" cols="50" rows="2" ><?php echo $row_updCommission['commission_sigle']; ?></textarea>
                                  </td>
                                </tr>
                                <tr valign="baseline">
                                  <th align="right" valign="middle" >Display:</th>
                                  <td><input name="display" type="checkbox" value=""  <?php if (!(strcmp($row_updCommission['display'],1))) {echo "checked=\"checked\"";} ?> /></td>
                                </tr>
                              </tbody>
                          </table>
                          <input type="hidden" name="user_id" value="<?php echo htmlentities($row_updCommission['user_id'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="commission_parent" value="<?php echo htmlentities($row_updCommission['commission_parent'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="montant_cumul" value="<?php echo htmlentities($row_updCommission['montant_cumul'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="nombre_offre" value="<?php echo htmlentities($row_updCommission['nombre_offre'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="membre_insert" value="<?php echo htmlentities($row_updCommission['membre_insert'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="dateCreation" value="<?php echo htmlentities($row_updCommission['dateCreation'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="dateUpdate" value="<?php echo htmlentities($row_updCommission['dateUpdate'], ENT_COMPAT, 'utf-8'); ?>" />
                          <input type="hidden" name="MM_update" value="frm_commission_update" />
                          <input type="hidden" name="commission_id" value="<?php echo $row_updCommission['commission_id']; ?>" />
                          <input type="hidden" name="bizRegNo" value="<?php echo $_POST['bizRegNo']; ?>" />
                        </form>
						</div>
					</div>
					<div class="fR pt10 mb20">
						<span class="btnTy21"><input type="button" class="btn" value="Sauvegarder" onClick="javascript:fn_saveUser();"></span> 
                        <span class="btnTy21"><input type="button" class="btn" value="Retour" onClick="javascript:fn_moveCommissionDetail();"></span>
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
		       location.href='http://179.18.0.96/'
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