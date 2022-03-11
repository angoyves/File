<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require('../includes/db.php'); ?>
<?php
	  require('../includes2/db.php');
	  require('../includes2/fonction_db.php');
	  require('../includes2/DW_Fonctions.php');
	  require('../includes2/controler.php');
	  require("../inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  //require('../AGIS/includes/MyFonction.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<style type="text/css"> 
	html {overflow:hidden;}  
</style>  
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
	function fn_insertTypeCommission(){
		
		var form = document.frm_user_typecommission;

		util_trimRequiredValue(form);
		
		if(!validateFrm_user_insert(form)){
			return;
		} else {
			//패스워드 일치여부 확인
			if(!fn_chkPwDup()){
				return;
			} 
	
			//아이디 중복여부 체크
			if(form.idRegisted.value == 'Y'){
				util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'un_available_id'); ?>");
				form.userId.focus();
				return;
			}
	
			//아이디 중복체크 후 값을 변경한 경우인지 체크
			if(form.idChanged.value == 'N'){
				util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_insert_msg'); ?>", 'fn_submitInsertUser()');
			}else{
				util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'check_id_again'); ?>");
			} 
			util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_insert_msg'); ?>", 'fn_submitInsertUser()');
		}
	 }
	
	//Form Submit
	function fn_submitInsertTypeCommission(){
		var form = document.frm_user_typecommission;
		form.action = "../Ctrl/InsertTypeCommissionCtrl.php";
		//form.target = "ResultFrame";
		form.submit();	
	}
	
	//특수문자체크
	function isValid(str){
		// return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
	}
	
	function fn_chkIdDuplicate(){
		var form = document.frm_user_typecommission;
		form.idChanged.value="Y";
		if(form.userId.value == ''){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'type_id'); ?>");
			form.userId.focus();
			return;
		}else if (!isValid(form.userId.value)){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'invalid_char'); ?>");
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
			var form = document.frm_user_typecommission;
			var result = xmlHttp.responseText;
			if(result == "success"){
				form.checkResult.value = "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'availableID'); ?>";
				form.idRegisted.value="N";
				form.idChanged.value="N";
			}else{
				form.checkResult.value = "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'notAvailableID'); ?>"; 
				form.idRegisted.value="Y";
				form.idChanged.value="N";
			}
		}
	}
	
	
	function fn_chkPwDup(){
		var form = document.frm_user_typecommission;
		var pwVar = form.userPw.value;
		var confVar = form.confirmPw.value;
	
		if(pwVar != confVar){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'chk_pw_dup'); ?>");
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
		<h1 class="title">Eregistrer un type de Commission<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'TypeCommissionAddPopop', $ObjId = 'title'); ?></h1>
		<button class="Close" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?>"	onclick="window.close();">
			<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?>
		</button>
	</div>
	<!-- //Layout : header Area -->

	<!-- Layout : container Area -->
	<div id="popup_contents" class="popContainer"> 
		<div class="tableTy2">
		  <div class="dataArea">
				<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
                  <form name="frm_user_typecommission" modelAttribute="UserSVO" method="post" id="frm_user_typecommission">
                    <!-- 입력폼 //-->
                <table class="data">
                                        <colgroup>
                                            <col style="width: 25%">
                                            <col style="width: *">
                                        </colgroup>
                                        <tbody>
                                        
                                        <tr valign="baseline">
                                          <th nowrap align="right">Sigle:<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'userId'); ?></th>
                                          <td><input type="text" name="TypeCommissionSigle" id="TypeCommissionSigle" value="" size="20"></td>
                                        </tr>
                                        <tr valign="baseline">
                                          <th nowrap align="right">Libelle type commission:<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'userId'); ?></th>
                                          <td><input type="text" name="type_commission_lib" value="" size="32"></td>
                                        </tr>
                                        <tr valign="baseline">
                                          <th nowrap align="right">Taux:<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'userId'); ?></th>
                                          <td><input type="text" name="taux" value="" size="20"></td>
                                        </tr>
                              </tbody>
                                </table>
					  <input type="hidden" name="type_commission_id" value="">
					  <input type="hidden" name="dateCreate" value="">
					  <input type="hidden" name="dateEntry" value="">
					  <input type="hidden" name="lastUpdate" value="">
					  <input type="hidden" name="display" value="1">
					  <input type="hidden" name="MM_insert" value="frm_user_typecommission">
				</form>
			</div>
		</div>
		<!-- //입력폼 끝 -->
		<!-- //Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter"><span class="btnTy4">
		  <input type="button" class="btn" value="Enregistrer<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'TypeCommissionAddPopop', $ObjId = 'insertBtn'); ?>" onClick="javascript:fn_submitInsertTypeCommission();">
		</span><span class="btnTy4"><button class="btn" onClick="window.close();"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?></button>
			</span>
	  </div>
		<!-- //Layout : Button Area -->
	</div>
</div>
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div>
</body>
</html>