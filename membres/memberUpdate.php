<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
	  require("../inc/biblio.inc.php");
	  require("../includes/DW_Fonctions.php");
	  require("../includes/controler.php");
	  require("../includes/fonction_db.php");
	  //require("src/inc/mysql_biblio.inc.php");
?><?php

$colname1_rsUpdPersonne = "-1";
if (isset($_GET['perID'])) {
  $colname1_rsUpdPersonne = (get_magic_quotes_gpc()) ? $_GET['perID'] : addslashes($_GET['perID']);
}
$colname_rsUpdPersonne = "-1";
if (isset($_GET['comID'])) {
  $colname_rsUpdPersonne = (get_magic_quotes_gpc()) ? $_GET['comID'] : addslashes($_GET['comID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsUpdPersonne = sprintf("SELECT membres.*, commission_lib, personne_id, personne_nom, personne_prenom, personne_telephone, sexe FROM membres, personnes, commissions  WHERE commissions_commission_id = commission_id  AND personnes_personne_id = personne_id AND commissions_commission_id = %s  AND personnes_personne_id = %s AND membres.display_agescom = 1", $colname_rsUpdPersonne,$colname1_rsUpdPersonne);
$rsUpdPersonne = mysql_query($query_rsUpdPersonne, $MyFileConnect) or die(mysql_error());
$row_rsUpdPersonne = mysql_fetch_assoc($rsUpdPersonne);
$totalRows_rsUpdPersonne = mysql_num_rows($rsUpdPersonne);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsFonctions = "SELECT fonction_id, fonction_lib FROM fonctions WHERE groupe_fonction_id =3 AND display = '1' ORDER BY fonction_lib ASC";
$rsFonctions = mysql_query($query_rsFonctions, $MyFileConnect) or die(mysql_error());
$row_rsFonctions = mysql_fetch_assoc($rsFonctions);
$totalRows_rsFonctions = mysql_num_rows($rsFonctions);
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
	function fn_saveMember(){
		//var form = document.form_Member_update;
		//util_trimRequiredValue(form);
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
		var form = document.frm_member_update;
	
		//처리중 이미지 만들기
		util_showExecutionImage();
	
		//form.action = "<?php //echo $editFormAction; ?>";
		//form.target = "ResultFrame";
		//form.exDocType.value = exDocType;
		
		form.action = "../CtrL/MemberUpdateCtrl.php";
		form.target = "_top";
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
		form.action = "commissions/CommissionDetails.php";
		form.submit();
	}
	function fn_moveList(comId){
		var form = document.frm_member_update;
		//form.isBack.value ="Y";
		form.bizRegNo.value = comId;
		form.action = "../commissions/CommissionDetails.php";
		form.target = "_top";
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
							
							<li class="depth2"><a href="../user/UsersReg.php">Utilisateurs</a></li>
							
							<li class="depth2_on"><p class="bullet"><a href="../user/UserDetails.php">Modifier les Informations</a></p></li>
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
				  <h1 class="h1_title"> Modifier les Informations d'un Membre</h1>
				  <h2 class="bullet1">
					  Information de l'Utilisateur
					</h2>
					<div class="tableTy1">
						<div class="dataArea">
                          
                      <form id="frm_member_update" method="post" name="frm_member_update">
                      <input type="hidden" name="bizRegNo">
                      <table class="data">
								  <caption>Information de l'Utilisateur</caption>
								  <colgroup>
									  <col style="width: 20%">
									  <col style="width: *">
								  </colgroup>
						<tbody>
                        <tr valign="baseline">
                          <th width="24%" align="right" valign="middle"><span class="style6">Commissions:</span></th>
                          <td colspan="3"><span class="style6"><?php echo $row_rsUpdPersonne['commissions_commission_id']; ?></span></td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle" ><span class="style6">Noms et Prenoms :</span></th>
                          <td colspan="3" ><span class="style6">
                            <input type="hidden" name="personnes_personne_id" value="<?php echo $row_rsUpdPersonne['personnes_personne_id']; ?>" size="32" />
                            <?php echo strtoupper($row_rsUpdPersonne['personne_nom'].' '.$row_rsUpdPersonne['personne_prenom']); ?></span></td>
                        </tr>
                        
                        <tr valign="baseline">
                          <th align="right" valign="middle"><span class="style6">Fonction:</span></th>
                          <td colspan="3"><span class="style6">
                            <select name="fonctions_fonction_id">
                              <?php
                    do {  
                    ?>
                              <option value="<?php echo $row_rsFonctions['fonction_id']?>"<?php if (!(strcmp($row_rsFonctions['fonction_id'], $row_rsUpdPersonne['fonctions_fonction_id']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsFonctions['fonction_lib']); ?></option>
                              <?php
                    } while ($row_rsFonctions = mysql_fetch_assoc($rsFonctions));
                      $rows = mysql_num_rows($rsFonctions);
                      if($rows > 0) {
                          mysql_data_seek($rsFonctions, 0);
                          $row_rsFonctions = mysql_fetch_assoc($rsFonctions);
                      }
                    ?>
                            </select>
                          </span> </td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle" >Contact :</th>
                          <td colspan="3" ><span class="style6">
                            <input name="personne_telephone" type="text"  value="<?php echo $row_rsUpdPersonne['personne_telephone']; ?>" size="32" />
                          </span></td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle"><span class="style6">Date Designation:</span></th>
                          <td colspan="3">
                            <span class="style6">
                          <input name="date_designation" type="date" class="article100_text"  value="<?php echo $row_rsUpdPersonne['date_designation']; ?>" size="32"> 
                          ex: 12/12/2012 </span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle"><span class="style6">Date Constation:</span></th>
                          <td colspan="3">
                            <span class="style6">
                          <input name="date_constation" type="date"  value="<?php echo $row_rsUpdPersonne['date_constation']; ?>" size="32"> 
                          ex: 12/12/2012 </span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <th valign="baseline" nowrap class="style4">Etat:</th>
                          <td width="33%" valign="baseline"><p>
                            <label>
                              <input type="radio" name="State" value="A" <?php if (!(strcmp($row_rsUpdPersonne['state'],A))) {echo "checked=\"checked\"";} ?> id="State_0" />
                              En activité</label>
                            <br />
                            <label>
                              <input type="radio" name="State" value="C"  <?php if (!(strcmp($row_rsUpdPersonne['state'],C))) {echo "checked=\"checked\"";} ?> id="State_1" />
                              En cessation d'activité</label>
                            <br />
                            <label>
                              <input type="radio" name="State" value="O"  <?php if (!(strcmp($row_rsUpdPersonne['state'],O))) {echo "checked=\"checked\"";} ?> id="State_2" />
                              Autres</label>
                            <br />
                          </p></td>
                          <th width="20%">Genre:</th>
                          <td width="23%" valign="baseline"><label>
                            <input type="radio" name="sexe" value="M" <?php if (!(strcmp($row_rsUpdPersonne['sexe'],M))) {echo "checked=\"checked\"";} ?> id="State_3" />
                            Masculin</label><br />
                            <label>
                              <input type="radio" name="sexe" value="F"  <?php if (!(strcmp($row_rsUpdPersonne['sexe'],F))) {echo "checked=\"checked\"";} ?> id="State_4" />
                              Feminin</label></td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle"><span class="style6">Date Cessation:</span></th>
                          <td colspan="3">
                            <span class="style6">
                          <input name="date_cessation" type="date"  value="<?php echo $row_rsUpdPersonne['date_cessation']; ?>" size="32"> 
                          ex: 12/12/2012 </span></span></td>
                        </tr>
                        <tr valign="baseline">
                          <th align="right" valign="middle"><span class="style6">Afficher:</span></th>
                          <td colspan="3"><input name="display" type="checkbox" value="1" <?php if (!(strcmp($row_rsUpdPersonne['display_agescom'],1))) {echo "checked=\"checked\"";} ?>><?php if (!(strcmp($row_rsUpdPersonne['display_agescom'],1))) {echo "checked=\"checked\"";} ?></td>
                        </tr>
                        </tbody>
                      </table>
                      <input type="hidden" name="checboxName" value="<?php echo $row_rsUpdPersonne['checboxName']; ?>">
                      <input type="hidden" name="dateUpdate" value="<?php echo $row_rsUpdPersonne['dateUpdate']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $row_rsUpdPersonne['user_id']; ?>">
                      <input type="hidden" name="MM_update" value="frm_member_update">
                      <input type="hidden" name="commissions_commission_id" value="<?php echo $row_rsUpdPersonne['commissions_commission_id']; ?>">
                      <input name="montant" type="hidden" value="<?php echo $row_rsUpdPersonne['montant']; ?>" size="50" />
                      <input name="position" type="hidden" value="<?php echo $row_rsUpdPersonne['position']; ?>" size="15" />
                      <input name="comId" type="hidden" value="<?php echo $_GET['comID']; ?>" />
                      <input name="perId" type="hidden" value="<?php echo $_GET['perID']; ?>" />
                      <input name="fonId" type="hidden" value="<?php echo $row_rsFonctions['fonction_id']?>" />
                      <input name="isBack" type="hidden" value="" />
                      <input name="date_constation2" type="hidden"  value="<?php echo $row_rsUpdPersonne['date_constation']; ?>" size="32" />
                    </form>
						</div>
					</div>
					<div class="fR pt10 mb20">
						<span class="btnTy21"><input type="button" class="btn" value="Sauvegarder" onClick="javascript:fn_saveMember();"></span> <span class="btnTy21"><input type="button" class="btn" value="Retour" onClick="javascript:fn_moveList('<?php echo $row_rsUpdPersonne['commissions_commission_id']; ?>');"></span>
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