<html lang="fr"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Enregistrement d'Utilisateur</title>
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
    var systime ="May 11, 2021 05:52:05";
    var systimeStr ="20210511055205525";
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

    function validateFrm_user(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateMaxLength(form); 
   } 

    function maxlength () { 
     this.aa = new Array("userId", "20 can not be greater than {1} characters(korean 3characters).", new Function ("varName", "this.maxlength='20';  return this[varName];"));
     this.ab = new Array("supplierNm", "200 can not be greater than {1} characters(korean 3characters).", new Function ("varName", "this.maxlength='200';  return this[varName];"));
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
<script type="text/javascript" src="../js/common/date.js"></script>
<script type="text/javaScript" language="javascript">

	//로그아웃 :: Logout
	function fn_logOut() {
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout() {
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}

	//화면 로드 시 :: On load
	function fn_onLoad() {
		fn_selectListPageUser();
	}

	//조회 처리 함수 :: Query processing function
	function fn_selectListPageUser() {
		var form = document.frm_user;

		//util_showExecutionImage();

		//상세, 수정에서 온 경우
		if (form.isBack.value == "Y") {
			util_initFormValue(form.childNodes, form.searchConditions.value);
		} else {
			form.currentPageNo.value = 1;
		}
		//trim 처리
		form.userId.value = form.userIdTemp.value.trim();
		form.action = "UserFrame.php";
		form.target = "UserFrame";

		if (!validateFrm_user(form)) {
			return;
		} else {
			form.submit();
		}
	}
	
	function fn_goPage(exDocType) {

		var form = document.frm_user;
		
		form.exDocType.value = exDocType;
		
		form.action = "/ed/rcv/moveCtDocList.do";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body id="body_admin" onLoad="javascript:fn_onLoad()" data-new-gr-c-s-check-loaded="14.1008.0" data-gr-ext-installed="">
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
							
							<li class="depth2_on"><p class="bullet"><a href="UsersReg.php">Utilisateurs</a></p></li>
							
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
					Enregistrement d'Utilisateur
				</h1>
				<form id="frm_user" name="frm_user" method="post">
					<div class="tableTy2">
						<div class="dataArea">
							<input type="hidden" name="searchConditions" value="[sep]isBack[sep][sep]userId[sep][sep]exDocType[sep][sep]userIdTemp[sep][sep]supplierNm[sep][sep]startDateStr[sep]11/02/2021[sep]startDate[sep]20210211[sep]endDateStr[sep]11/05/2021[sep]endDate[sep]20210511[sep]acceptYn[sep][sep]recordCountPerPage[sep]10">
							<input type="hidden" name="currentPageNo" value="1">
							<input type="hidden" name="isBack" value="">
							<input type="hidden" name="userId" value="">
							<input type="hidden" name="exDocType">
							<table class="data">
								<caption>Enregistrement d'Utilisateur</caption>
								<colgroup>
									<col style="width: 18%">
									<col style="width: *">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine"><label for="userIdTemp">ID d'Utilisateur</label></th>
										<td>
											<input type="text" class="text" maxlength="20" name="userIdTemp" value="" id="userIdTemp" onBlur="javascript:util_checkValidation(this, '^[^<>]*$',14); " size="70%">
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine"><label for="supplierNm"> Service Emetteur </label></th>
										<td>
											<input type="text" class="text" maxlength="200" name="supplierNm" value="" id="supplierNm" onBlur="javascript:util_checkValidation(this, '^[^<>]*$',14); " size="70%">
										</td>
									</tr>
										<tr>
											<th scope="row" class="noLine"><label for="startDateStr"> Date de Demande </label></th>
											<td class="period">
												<input type="text" name="startDateStr" id="startDateStr" class="article100_text" maxlength="8" style="width:65px" value="11/02/2021" onKeyDown="javascript:util_checkNumber(this, event)" onFocus="javascript:util_setDateFormat(this)" onBlur="javascript:util_checkDateFormat(this, valiDateMsg);
																	util_checkObjDayWithHidden(this, document.frm_user.startDate, document.frm_user.endDateStr, 'before', valiNoMatchDateMsg)">
												<input type="hidden" name="startDate" id="startDate" value="20210211"> <a href="#"><img src="../images/common/ico_calendar.gif" class="pl5 vM" onClick="javascript:Calendar_D(document.frm_user.startDateStr, document.frm_user.startDate);return false;" alt="calendar"></a>
												~
												<input type="text" name="endDateStr" id="endDateStr" class="article100_text" maxlength="8" style="width:65px" value="11/05/2021" onFocus="javascript:util_setDateFormat(this)" onBlur="javascript:util_checkDateFormat(this, valiDateMsg);
																	util_checkObjDayWithHidden(this, document.frm_user.endDate, document.frm_user.startDateStr, 'after', valiNoMatchDateMsg)">
												<input type="hidden" name="endDate" id="endDate" value="20210511">  <a href="#"><img src="../images/common/ico_calendar.gif" class="pl5 vM" onClick="javascript:Calendar_D(document.frm_user.endDateStr, document.frm_user.endDate);return false;" alt="calendar"></a>
											</td>
										</tr>
									<tr>
										<th>Statut</th>
										<td><select name="acceptYn" style="width: 100px">
												<option value="">::: Tout</option>
												<option value="R">Validation Demandée</option>
												<option value="Y">Validé</option>
												<option value="N">Renvoyé</option>
										</select></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="fR mt15 mb20">
						<select id="recordCountPerPage" name="recordCountPerPage" class="article_selectbox">
							<option value="10" selected="selected">
								10 résultats
							</option>
							<option value="20">
								20 résultats
							</option>
							<option value="30">
								30 résultats
							</option>
							<option value="50">
								50 résultats
							</option>
						</select>
						<span class="btnTy3"> <input type="button" class="btn" value="Rechercher" onClick="javascript:fn_selectListPageUser();"> </span>
					</div>
					<iframe name="UserFrame" id="UserFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
				</form>
			</div><!-- //content END -->
			    <div id="copy_w">
			      <p class="fL ml20">&nbsp;</p>
        <p class="fR mt15"><img src="../images/main/copylight.gif" alt="Copyright (C) 2014 Soft I Tech. All Rights Reserved."></p>
    </div>
<script type="text/javaScript" language="javascript">

    if ((navigator.userAgent.indexOf('MSIE 6')>0) && (navigator.userAgent.indexOf('MSIE 7')==-1)){

        util_messageAlertWithExec("Il se peut que les pages ne fonctionnent pas correctement sous l'environnement Internet Explorer 6 et 7. Veuillez mettre à jour votre navigateur au dessus d’IE 8 ou utiliser d'autres navigateurs tels que Chrome, Firefox.", "fn_moveMain()");

		   function fn_moveMain(){
		       location.href='http://localhost:8080/AGesCom/file/';
		   }
    }

</script>

		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->

</body></html>