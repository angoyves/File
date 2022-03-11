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
		form.action = "/ed/user/moveUserUpdate.do";
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
			<img src="../images/admin_top.jpg" alt="top">
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
							
							<li class="depth2_on"><p class="bullet"><a href="UserDetails.php">Mes Informations</a></p></li>
						</ul>
					</li>
					
					<li class="depth1_on"><p class="sline">Acquisition des DAO</p> 
						<ul>
							<li class="depth2"><a href="/ed/rcv/movePubPaymentList.do">Quittances du Frais d'Acquisition du DAO </a></li>
						</ul>
					</li>
					
					
					
					<li class="depth1_none"><p class="sline">Liste des Pièces Soumises </p>
						<ul>
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
								
							
								
									
									
									
									
									
									
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('ETC')">Autres</a></li>
									
								
							
						</ul>
					</li>
					
					
				</ul>
			</div><!-- //menu END -->
			
			<div class="content" id="contents">
				<h1 class="h1_title">
					Mes Informations
				</h1>
			<form id="UserSVO" name="frm_user_detail" action="/ed/user/moveUserDetail.do" method="post">
				<div class="tableTy1">
					<div class="dataArea">
							<input type="hidden" name="searchConditions" value="">
							<input type="hidden" name="currentPageNo" value="0">
							<input type="hidden" name="isBack" value="">
							<input type="hidden" name="userAuth" value="M">
							<input type="hidden" name="acceptYn" value="Y">
							<input type="hidden" name="userId" value="MINFI">
							<input type="hidden" name="userPw" value="96E79218965EB72C92A549DD5A330112">
							<input type="hidden" name="exDocType">
							<table class="data">
								<caption>Mes Informations</caption>
								<colgroup>
									<col style="width: 18%">
									<col style="width: 32%">
									<col style="width: 18%">
									<col style="width: 32%">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL">Mes Informations</th>
										<td colspan="3">MINFI</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Autorité</th>
										<td>
											
												
												
													Utilisateur
												
											
										</td>
										<th scope="row" class="noLine tL">Date et Heure de Demande de Validation</th>
										<td>09/02/2017 00:00</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Service Emetteur</th>
										<td colspan="3">
											
											
											MINFI
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Adresse</th>
										<td colspan="3">
											
											
											¿¿¿
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">N° de Téléphone</th>
										<td>
											
											
											1122121
										</td>
										<th scope="row" class="noLine tL">N° de Fax</th>
										<td>
											
											
											1212121
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">e-Mail</th>
										<td colspan="3">
											
											
											minfi@admin.com
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">Validation</th>
										<td>
										
											
                        						Validé
                        					
											
										
										</td>
										<th scope="row" class="noLine tL">Date et Heure de Validation</th>
										<td>09/02/2017 00:00</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL">ID du Valideur</th>
										<td>
											
											
											administrator
										</td>
										<th scope="row" class="noLine tL">Valideur</th>
										<td>
											Administrateur
										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
			</form>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="Modifier" onclick="javascript:fn_moveUserUpdate();"></span>
				</div>
			</div><!-- //content END -->
			    <div id="copy_w">
        <p class="fL"><img src="../images/main/coylogo.gif" alt="koica loge"></p>
        <p class="fL ml20"><img src="../images/main/coylogo2.gif" alt="softitech logo"></p>
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

		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->

</body></html>