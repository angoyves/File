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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<link rel="stylesheet" href="css/sub.css" media="all">
<script type="text/javascript" src="js/common/font.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/alertExms.js"></script>
<script type="text/javascript" src="js/common/validation.js" ></script>
<script type="text/javascript" src="js/common/frame.js" ></script>
<script type="text/javascript" src="js/common/ajax.js" ></script>
<script type="text/javascript" src="js/common/string.js" ></script>
<script type="text/javascript" src="js/common/prototype.js"></script>
<script type="text/javascript" src="js/common/event.js" ></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/calendar.js"></script>
<script type="text/javascript" src="js/common/date.js"></script>
<script type="text/javaScript" language="javascript">

	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPagePubPmBidInfo();
	}
	
	//조회 처리 함수 :: Query processing function
	function fn_selectListPagePubPmBidInfo(){
		var form = document.frm_bidInfo_insert;
		form.currentPageNo.value = 1;
		
		//trim 처리
		form.bidNo.value = form.bidNoTemp.value.trim();
		form.action = "PubSrchPopupFrame.php";
		form.target = "PubSrchPopupFrame";
		form.submit();
	}

	function fn_messageAlert() {
		util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'msg1'); ?>");
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad()">
<div id="popup_main">
	<div id="popWrap">
		<!-- Layout : header Area -->
		<div class="popHeader" id="pop_header">
			<h1 class="title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'title'); ?></h1>
			<button class="Close" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'closeBtn'); ?>" onclick="window.close();"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'closeBtn'); ?></button>
		</div>
		<!-- // Layout : header Area -->

		<!-- Layout : container Area -->
		<div class="popContainer" id="popup_contents">
			<!-- 입력폼 // -->
			<form name="frm_bidInfo_insert" modelAttribute="RcvSVO" method="post" id="frm_bidInfo_insert">	
				<div class="tableTy2">
					<div class="dataArea">
						<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
						<!-- 라운드 디자인을 위함. -->
						<input type="hidden" name="searchConditions" value="<?php $_POST['searchConditions']; ?>">
						<input type="hidden" name="currentPageNo" value="<?php $_POST['currentPageNo']; ?>">
						<input type="hidden" name="isBack" value="<?php $_POST['isBack']; ?>">
						<input type="hidden" name="bidNo" value="<?php $_POST['bidNo']; ?>">
						<table class="data">
							<colgroup>
								<col style="width: 20%">
								<col style="width: 80%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row">
										<label for="bidNoTemp"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'bidNo'); ?></label>
											<em class="pointTxt2" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'title'); ?>"></em>
									</th>
									<td>
										<input type="text" id="bidNoTemp" name="bidNoTemp" class="text" maxlength="11" size="80%" value="<?php $_POST[bidNoTemp]; ?>"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageCtDocBidInfo()', '^[^<>]*$', 14, document.frm_bidInfoCt_insert.bidNm;"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="bidNm"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'bidNm'); ?></label>
											<em class="pointTxt2" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'bidNm'); ?>"></em>
									</th>
									<td>
										<input type="text" id="bidNm" name="bidNm" class="text" maxlength="200" size="80%" value="<?php $_POST[bidNm]; ?>"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageCtDocBidInfo()', '^[^<>]*$', 14, document.frm_bidInfoCt_insert.bidNoTemp);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14); ">
									</td>
								</tr>
								<tr>
									<th scope="row" class="noLine"><label for="startDateStr"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'bdRcvEndDt'); ?></label></th>
									<td class="period">
										<input type="text" name="startDateStr" id="startDateStr" class="article100_text" maxlength="8" style="width:65px" value="<?php $nextyear = mktime(0, 0, 0, date("m"), date("d"), date("y")-1); echo date('d/m/y', $nextyear); $_POST['startDate']; ?>"
													onkeydown="javascript:util_checkNumber(this, event)" onFocus="javascript:util_setDateFormat(this)"
													onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																	util_checkObjDayWithHidden(this, document.frm_bidInfo_insert.startDate, document.frm_bidInfo_insert.endDateStr, 'before',valiNoMatchDateMsg)">
										<input type="hidden" name="startDate" id="startDate" value="<?php $_POST['startDate']; ?>">
										<a href="#"><img src="<c:url value='/images/common/ico_calendar.gif'></c:url>" 
											class="pl5 vM"
											onclick="javascript:Calendar_D(document.frm_bidInfo_insert.startDateStr, document.frm_bidInfo_insert.startDate);return false;" alt="calendar"></a>
										~
										<input type="text" name="endDateStr" id="endDateStr" class="article100_text" maxlength="8" style="width:65px" value="<?php echo date('d/m/y'); $_POST['endDate']; ?>"
													onkeydown="javascript:util_checkNumber(this, event)" onFocus="javascript:util_setDateFormat(this)"
													onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																util_checkObjDayWithHidden(this, document.frm_bidInfo_insert.endDate, document.frm_bidInfo_insert.startDateStr, 'after', valiNoMatchDateMsg)">
										<input type="hidden" name="endDate"  id="endDate" value="${RcvSVO.endDate}">  <a href="#"><img src="<c:url value='images/common/ico_calendar.gif'></c:url>"
													class="pl5 vM" onClick="javascript:Calendar_D(document.frm_bidInfo_insert.endDateStr, document.frm_bidInfo_insert.endDate);return false;" alt="calendar"></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- //입력폼 끝 -->

				<div class="fR mt15 mb20">
					<span class="btnTy3"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'srchBtn'); ?>" onclick="javascript:fn_selectListPagePubPmBidInfo();"></span>
				</div>
				<div class="btnAreaLeft mt5">
	                <p class="fL" style="color: #FF0000;">※ <?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'bdRcvEndDt_info'); ?></p>
	            </div>
				<iframe name="PubSrchPopupFrame" id="PubSrchPopupFrame" width="100%" height="180px" frameborder="0" scrolling="no"></iframe>
			</form>
		</div>
		<!-- // Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><button class="btn" onClick="window.close();" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'closeBtn'); ?>"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'closeBtn'); ?></button></span>
		</div>
		<!-- // Layout : Button Area -->
	</div>
</div>
</body>
</html>