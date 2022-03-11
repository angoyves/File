<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>#AGESCOM System</title>

<link rel="stylesheet" href="css/login.css" media="all">
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
    var systime ="April 27, 2021 20:12:32";
    var systimeStr ="202104272012321232";
    var today ="20210427";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="27/04/2021";
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

<script type="text/javascript" src="js/common/validation.js"></script>
<script type="text/javascript" src="js/common/event.js"></script>
<script type="text/javascript" src="js/common/file.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/alertExms.js"></script>

<script type="text/javaScript" language="javascript">

	/* ********************************************************
	 * 로그인 처리 함수 :: Login
	 ******************************************************** */
	function fn_login() {
		var form = document.frm_login;
		var id = form.userId;
		var pw = form.userPw;

		if (id.value == null || id.value == '') {
			alert("Entrez l'ID", id);
			id.focus();
			return;
		} else if (pw.value == null || pw.value == '') {
			alert("Entrez le mot de passe");
			pw.focus();
			return;
		} 
		
		if (pw.value != '') {
			form.action = "CtrL/ConnectUserCtrl.php";
			//form.target = "ResultFrame";
			form.submit();
		}
	}

	function fn_loginId() {
		if("" != ''){
			parent.location.href = "/ed/rcv/movePubPaymentList.do";
		}
	}


	//회원등록 팝업
	function fn_userRegist(){
		var openParam = "width=800px,height=650px,toolbar=no,menubar=no,resizable=no,scrollbars=no,copyhistory=no,location=no";
		var url = "user/UserRegPopup_test.php";

		window.open(url, 'UserInsert', openParam);
	}
	
</script>

</head>


<body onLoad="javascript:fn_loginId();">
<!-- loginwrap START // --> 
<div id="loginwrap">
    <div class="loginbox">
    	<div class="login">
       		<form id="UserSVO" name="frm_login" method="post">
	        	<ul>
	            	<li><p class="fL mr72 pt10"><img src="images/id.gif" alt="id"></p><p class="fL"><input type="text" id="userId" class="input_Ty" name="userId"  tabindex="1"></p></li>
	                <li><p class="fL mr72 pt10"><img src="images/pw.gif" alt="pw"></p><p class="fL"><input type="password" id="userPw" maxlength="6" class="input_Ty"  style="height:27px;" name="userPw" tabindex="2"
	                			onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_login()', '^[0-9|A-Z|a-z| ]*$', 10, document.frm_login.userId)"></p></li>
	        	</ul>
            </form>
            <p><a href="#"><img src="images/login_btn.gif" alt="login" onClick="javascript:fn_login();"></a></p>
            <p class="user"><a href="#"><img src="images/register_btn.png" alt="user register" onClick="javascript:fn_userRegist();"></a></p>
        </div>
    </div>
    <div class="copylight">Copyright (C) . All Rights Reserved.</div>
</div>
	<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
<!-- //loginwrap END -->
</body>
</html>