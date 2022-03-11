<?php require_once('Connections/MyFileConnect.php'); ?>
<?php require('includes/db.php'); ?>
<?php
	  require('includes2/db.php');
	  require('includes2/fonction_db.php');
	  require('includes2/DW_Fonctions.php');
	  require('includes2/controler.php');
	  require("inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("src/inc/mysql_biblio.inc.php");
	  //require('../AGIS/includes/MyFonction.php');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<script type="text/javaScript" src="js/common/font.js"></script>
<script type="text/javaScript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/string.js"></script>
<script type="text/javascript" src="js/common/prototype.js"></script>
<script type="text/javascript" src="js/common/validation.js"></script>
<script type="text/javascript" src="/js/common/event.js"></script>
<script type="text/javascript" src="js/common/calendar.js"></script>
<script type="text/javascript" src="js/common/date.js"></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/popup.js"></script>
<script type="text/javascript"> 

     var bCancel = false; 

    function validateFrm_pub(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateMask(form) && validateMaxLength(form); 
   } 

    function mask () { 
     this.aa = new Array("bidNoStr", "Intitulé d'Avis d'Appel d'Offres is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='11'; this.mask=/^[0-9]*$/;  return this[varName];"));
     this.ab = new Array("bidNm", "N° de l'Avis d'Appel d'Offre is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='200'; this.mask=/^[^<>]*$/;  return this[varName];"));
    } 

    function maxlength () { 
     this.aa = new Array("bidNoStr", "Intitulé d'Avis d'Appel d'Offres can not be greater than 11 characters(korean 3characters).", new Function ("varName", "this.maxlength='11'; this.mask=/^[0-9]*$/;  return this[varName];"));
     this.ab = new Array("bidNm", "N° de l'Avis d'Appel d'Offre can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200'; this.mask=/^[^<>]*$/;  return this[varName];"));
    } 


</script>


<script type="text/javascript" language="javascript">
/***********************************
 * 화면 onLoad
 ***********************************/
function fn_onLoad(myValue){
	
	fn_selectListPageEpPub(myValue);
	
}

/***********************************
 *  공고기관 초기화
 ***********************************/
function fn_reset(){
	
	document.getElementById("instCd").value = "";
	document.getElementById("instNm").value = "";
	document.getElementById("txtSearch").value = "";
	
}

/***********************************
 *  공고기관 조회 팝업
 ***********************************/
function fn_searchInst(){
	
	var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	var url    = "http://localhost:8080/cam-exms/jsp/ep/pub/EpPubBidInstListPopup.php";
   			  
	var ReturnValue = window.open(url, "inst", openParam);
	ReturnValue.focus();
}

/***********************************
 *  입찰공고 목록 조회
 ***********************************/
function fn_selectListPageEpPub(myValue){
	// 처리중 이미지 생성
	var form = document.frm_pub;
	
	util_showExecutionImage();
	
 	if (!validateFrm_pub(form))return;
    
 // 상세, 수정에서 온 경우
	/*if(form.isBack.value == "Y"){
		util_initFormValue(form.childNodes , form.searchConditions.value);
	} else {
		form.currentPageNo.value = 1;
	}*/
	
 	//util_trimValue();
	
	
	/*form.bidNo.value = form.bidNoStr.value;
    
	form.action = "PersonnelListFrameTest.php";
	//form.target = "PubPaymentFrame";frm_pub
	form.target = "PubPaymentFrame";
	form.submit();*/
	
	//document.getElementById('PubPaymentFrame').src='sampleTestFrame.php';
	document.getElementById('frm_pub').action='repcomFrame.php?value='+myValue;
	document.getElementById('frm_pub').target='PubPaymentFrame';
	document.getElementById('frm_pub').submit();
	
	//form.bidNo.value = form.bidNoStr.value;
	//form.action = "sampleTestFrame.php";
	//form.target = "PubPaymentFrame";
	//form.submit();
		
	/*if(!validateFrm_pubPayment(form)){
		return;
	} else {
		form.submit();
	}*/

}

/***********************************
 * 테스트용 모의공고
 ***********************************/
function fn_selectTestBid(){

	var form = document.frm_pub;
	
	form.bidNo.value = "20150100003";
	form.bidModSeq.value = "00";
	
	form.target = "main";
	form.action = "/ep/pub/moveEpPubDetail.do";
	form.submit();
}


function fn_open(){
	 
	var openParam = "width=845px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	window.open('', 'Popup', openParam);

	var form = document.frm_pub;
	
	form.target = "Popup";
   	form.action = "/report1.do";
   	form.submit();
}
function fn_movePubPaymentInsert(){
	var form = document.frm_pub;
	form.action = "memberReg.php";
	form.target = "_top";
	form.submit();
}
	function fn_moveUserDetail(userId){
		var form = parent.document.frm_user;
		form.userId.value = userId;
		form.target = "_top";
		form.action = "repcom.php";
		form.submit();
	}
function fn_InsertCommissionPopop(){
	
	var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	var url    = "user/CommissionRegPopup.php";
	var ReturnValue = window.open(url, "inst", openParam);
	ReturnValue.focus();
}
</script>
<style type="text/css">
<!--
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
-->
</style>
</head>
<body onLoad="fn_onLoad(<?php echo $_GET['value']; ?>)">
<div id="main">
<div id="sitewrap">
<div id="wrap">
<div class="top"><img src="images/admin_top_agescom.jpg" alt="top"></div>
  <div id="con_wrap">
    <div class="menu">
      <!-- Menu BEGIN -->
      <ul>
        <p>    
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
        <?php if ($userAuth=='A') { ?>
        </p>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1'); ?></p>
          <ul>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1_1'); ?></a></a>
              <p></p>
            </li>
          </ul>
        </li>
        <?php } ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2'); ?></p>
          <ul>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_1'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_2'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_3'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_4'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_5'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth2_6'); ?></a>
              <p></p>
            </li>
          </ul>
        </li>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3'); ?></p>
          <ul>
            <li class="depth2"><a href="repcim.php?value=142"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_1'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php?value=144"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_2'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php?value=145"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_3'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_4'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_5'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth3_6'); ?></a>
              <p></p>
            </li>
          </ul>
        </li>
        <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4'); ?></p>
          <ul>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_1'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_2'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_3'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_4'); ?></a></li>
          </ul>
        </li>
        <?php //} ?>
        <?php if (isset($userAuth) || (	$userAuth =='B')) { ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5'); ?></p>
          <ul>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_1'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_2'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_3'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_4'); ?></a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if (isset($userAuth) || (	$userAuth =='B')) { ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth6'); ?></p>
          <ul>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth6_1'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth6_2'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth6_3'); ?></a></li>
            <li class="depth2"><a href="/ed/master/moveLangList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth6_4'); ?></a></li>
            <li class="depth2"><a href="/ed/master/moveMappingInfoList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth6_5'); ?></a></li>
            <li class="depth2"><a href="/ed/master/moveCodeTypeList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth6_6'); ?></a></li>
            <li class="depth2"><a href="/ed/master/moveCodeList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth6_7'); ?></a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div id="contents" class="content">
  <div class="con" style="margin-top: 20px">
		        <div class="fR" style="display: none;">
					<span class="btnTy21 fR ml15"><input type="button" class="btn" value="Test" onClick="fn_selectTestBid();"></span>
				</div>
                <h1 class="h1_title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'title'); ?></h1>
				<form id="frm_pub" name="frm_pub" method="post">
					<input type="hidden" id="searchConditions" name="searchConditions" value="">
					<input type="hidden" id="isBack" name="isBack" value="">
					<input type="hidden" id="currentPageNo" name="currentPageNo" value="1">
					<input type="hidden" id="publicDtFrom" name="publicDtFrom" value="20190608">
					<input type="hidden" id="publicDtTo" name="publicDtTo" value="20200608">
					<input type="hidden" id="bdOpenDtFrom" name="bdOpenDtFrom" value="20190608">
					<input type="hidden" id="bdOpenDtTo" name="bdOpenDtTo" value="20210608">
					<input type="hidden" id="bidModSeq" name="bidModSeq" value="">
					<input type="hidden" id="bidNo" name="bidNo" value="">
                    <input type="hidden" id="IdPerson" name="IdPerson" value="<?php echo $_POST['']; ?>">
                    <input name="txtValue" type="hidden" id="txtValue" value="<?php echo (isset($_GET['value']))? $_GET['value'] : ""; ?>"/>
					
				<div class="tableTy2">
                  <div class="dataArea">	
	                	<table class="data">
							<colgroup>
								<col style="width:25%">
	                            <col style="width:75%">
							</colgroup>
	                        <tbody>
	                            <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchName'); ?></th>
	                                <td>
	                                	<input type="hidden" class="text" id="idPerson" name="idPerson" style="width:20%" readonly="readonly">
                                        <input type="text" class="text" id="instCd" name="instCd" style="width:25%" readonly="readonly">
	                            		<input type="text" class="text" id="instNm" name="instNm" style="width:45%" readonly="readonly">
	                            		<span class="btnTy3"><input type="button" class="btn" value="Rechercher" onClick="fn_searchInst();"></span>
	                            		<span class="btnTy3"><input type="button" class="btn" value="Réinitialiser"onclick="fn_reset();"></span></td>
	                            </tr>
	                            <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchOther'); ?></th><!-- 입찰공고명 -->
	                                <td>
	                                	<input type="text" class="text" id="txtSearch" name="txtSearch" style="width:97%" maxlength="250"
                                			onblur="javascript:util_checkValidation(this, '^[^<>]*$', 250);">
                           			</td>
	                            </tr>
	                        </tbody>
	                    </table>
				  </div>
				</div>
				
				<!-- 검색버튼 영역 시작 -->
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
					<span class="btnTy3">
						<input class="btn" type="button" onClick="javascript:fn_selectListPageEpPub()"
                       value="Rechercher">
                    </span>
                 </div>
              </form>
              <iframe name="PubPaymentFrame" id="PubPaymentFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
              <div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="Enregistrer un Nouveau Membre" onClick="fn_InsertCommissionPopop();"></span>
			</div>
          </div>
		</div>
	</div>


</div>
</div>
</div>
</body>
</html>