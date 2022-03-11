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

$colname_Recordset = "-1";
if (isset($_POST['userId'])) {
  $colname_Recordset = $_POST['userId'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM users WHERE user_id = %s", GetSQLValueString($colname_Recordset, "int"));
$Recordset = mysql_query($query_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
?>
<html lang="ko"><head>
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
    var systime ="May 11, 2021 19:14:39";
    var systimeStr ="202105111914391439";
    var today ="20210511";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="11/05/2021";
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


<script type="text/javascript" src="/js/common/font.js"></script>
<script type="text/javascript" src="/js/common/alert.js"></script>
<script type="text/javascript" src="/js/common/alertExms.js"></script>

<script type="text/javascript" src="/js/common/pagination.js"></script>
<script type="text/javascript" src="/js/common/string.js"></script>
<script type="text/javascript" src="/js/common/prototype.js"></script>
<script type="text/javascript" src="/js/common/calendar.js"></script>
<script type="text/javascript" src="/js/common/event.js"></script>
<script type="text/javascript" src="/js/common/ajax.js"></script>
<script type="text/javascript" src="/js/common/validation.js"></script>
<script type="text/javaScript" language="javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}

	//사용자 승인
	function fn_acceptY(){
		util_confirmAlert("Voulez-vous valider?","fn_acceptYsubmit()");
	}
	
	//사용자 승인 submit
	function fn_acceptYsubmit(){
		var form = document.frm_user_detail;
		 util_showExecutionImage();
		
		 form.acceptYn.value="Y";
		 form.action = "../Ctrl/UserAcceptYnCtrl.php";
		 form.target = "ResultFrame";
		 form.submit();
	}
	
	//사용자 반려
	function fn_acceptN(){
		util_confirmAlert("Voulez-vous renvoyer?","fn_acceptNsubmit()");
	}
	
	//사용자 반려 submit
	function fn_acceptNsubmit(){
		var form = document.frm_user_detail;

		 util_showExecutionImage();
		 
		 form.acceptYn.value="N";
		 form.action = "../Ctrl/UserAcceptYnCtrl.php";
		 //form.target = "ResultFrame";	
		 form.submit();
	}

	//리스트 화면 처리 함수 :: List processing functions, screen
	function fn_moveUserList(){
		var form = document.frm_user_detail;
		form.isBack.value = "Y";
		form.target = "_top";
		form.action = "../user/UsersReg.php";
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
<body id="body_admin" data-new-gr-c-s-check-loaded="14.1010.0" data-gr-ext-installed="">
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
							
							<li class="depth2_on"><p class="bullet"><a href="UsersReg.php">Utilisateurs</a></li>
							
							<li class="depth2"><a href="UserDetails.php">Mes Informations</a></li>
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
				<h1 class="h1_title">
					Détails
				</h1>
				<h2 class="bullet1">
					Information de l'Utilisateur
				</h2>
				<form id="UserSVO" name="frm_user_detail"  method="post">
					<div class="tableTy1">
						<div class="dataArea">
							<input type="hidden" name="searchConditions" value="">
							<input type="hidden" name="currentPageNo" value="1">
						  	<input type="hidden" name="userAuth" value="<?php echo $row_Recordset['userAuth']; ?>">
						  	<input type="hidden" name="acceptYn" value="<?php echo $row_Recordset['acceptYn']; ?>">
						  	<input type="hidden" name="userId" value="<?php echo $row_Recordset['user_login']; ?>">
					  	  <input type="hidden" name="userPw" value="<?php echo $row_Recordset['user_password']; ?>">
							<input type="hidden" name="isBack" value="<?php echo $row_Recordset['isBack']; ?>">
							<input type="hidden" name="exDocType">
							<input type="hidden" name="MM_update" value="frm_user_detail">
							<table class="data">
				        <caption>Information de l'Utilisateur</caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: 30%">
									<col style="width: 18%">
									<col style="width: 32%">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL">ID d'Utilisateur</th>
										<td colspan="3"><?php echo $row_Recordset['user_login']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Service Emetteur</th>
										<td colspan="3"><?php echo $row_Recordset['structure_id']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Groupe d'utilisateurs</th>
										<td colspan="3"><?php echo $row_Recordset['userAuthNm']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Adresse</th>
										<td colspan="3"><?php echo $row_Recordset['addr']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">N° de Téléphone</th>
										<td><?php echo $row_Recordset['telNo']; ?></td>
										<th scope="row" class="noLine tL">N° de Fax</th>
										<td><?php echo $row_Recordset['faxNo']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">e-Mail</th>
										<td><?php echo $row_Recordset['acceptYn']; ?></td>
										<th scope="row" class="noLine tL">Date et Heure de Demande de Validation</th>
										<td><?php echo $row_Recordset['dateCreation']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<h2 class="bullet1 mt20">
						Information de Validation
					</h2>
					<div class="tableTy1">
						<table class="data">
							<caption>Information de Validation</caption>
							<colgroup>
								<col style="width: 20%">
								<col style="width: 30%">
								<col style="width: 18%">
								<col style="width: 32%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row" class="noLine tL">Validation</th>
								  <td>
                                    			<?php if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='Y'){ ?>
                                                    Validé
                                                <?php }  else if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='N'){ ?>
                                                    Renvoyé
                                                <?php } else if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='R'){ ?>
                                                    <span class="bold"><font color="F15F5F">Validation Demandée</font></span>
                                                <?php } ?>
									</td>
									<th scope="row" class="noLine tL">Date et Heure de Validation</th>
									<td><?php echo $row_Recordset['acceptDt']; ?></td>
								</tr>
								<tr>
									<th scope="row" class="noLine tL">ID du Valideur</th>
									<td><?php echo $row_Recordset['acceptId']; ?>
										
										
										
									</td>
									<th scope="row" class="noLine tL">Valideur</th>
                                    			<?php if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='Y'){ 
                                                    echo $row_Recordset['acceptNm']; 
                                                	 } ?>
									<td>
										
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
				<div class="fR pt10 mb20">
					
				<?php if ((isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='Y') || (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='N')){ ?>
                         	<span class="btnTy21">
								<input type="button" class="btn" value="Retour" onClick="javascript:fn_moveUserList();">
							</span>
                            
							<?php } else { ?>		
						
							<span class="btnTy21">
								<input type="button" class="btn" value="Valider" onClick="javascript:fn_acceptY();">
							</span>
                            <span class="btnTy21">
								<input type="button" class="btn" value="Renvoyer" onClick="javascript:fn_acceptN();">
							</span>
							<span class="btnTy21">
								<input type="button" class="btn" value="Retour" onClick="javascript:fn_moveUserList();">
							</span>
						<?php } ?>
					
				</div>
			</div><!-- //content END -->
	    <div id="copy_w">
        <p class="fL">&nbsp;</p>
        <p class="fL ml20">&nbsp;</p>
        <p class="fR mt15"><img src="../images/main/copylight.gif" alt="Copyright (C) 2014 Soft I Tech. All Rights Reserved."></p>
    </div>
<script type="text/javaScript" language="javascript">

    if ((navigator.userAgent.indexOf('MSIE 6')>0) && (navigator.userAgent.indexOf('MSIE 7')==-1)){

        util_messageAlertWithExec("Il se peut que les pages ne fonctionnent pas correctement sous l'environnement Internet Explorer 6 et 7. Veuillez mettre à jour votre navigateur au dessus d’IE 8 ou utiliser d'autres navigateurs tels que Chrome, Firefox.", "fn_moveMain()");

		   function fn_moveMain(){
		       location.href='http://179.18.0.96/'
		   }
    }

</script>

		</div>
	  <?php //echo $row_Recordset['userAuthNm']; ?>
	  <!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div><!-- //main END -->

</body></html>
<?php
mysql_free_result($Recordset);
?>
