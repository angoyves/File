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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<script type="text/javascript" src="js/common/font.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/alertExms.js"></script>
<script type="text/javascript" src="js/common/validation.js" ></script>
<script type="text/javascript" src="js/common/frame.js" ></script>
<script type="text/javascript" src="js/common/ajax.js" ></script>
<script type="text/javascript" src="js/common/string.js" ></script>
<script type="text/javascript" src="js/common/event.js" ></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javaScript" language="javascript">

	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPageSupplierSrch();
	}

	//조회 처리 함수 :: Query processing function
	function fn_selectListPageSupplierSrch(){
		var form = document.frm_supplierInfo_insert;
		form.currentPageNo.value = 1;
		
		var bizRegNoSc = form.bizRegNoTemp.value;
		var supplierNmSc = form.supplierNm.value;

		if(bizRegNoSc == '' && supplierNmSc == ''){
			util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'SupplierSrchPopup', $ObjId = 'srchCondition'); ?>", null);
		} else {
			form.bizRegNo.value = form.bizRegNoTemp.value.trim();
			form.action = "SupplierSrchPopupFrame.php";
			form.target = "SupplierSrchPopupFrame";
			form.submit();
		}
	}
</script>
</head>
<body>
<div id="popup_main">
	<div id="popWrap">
		<!-- Layout : header Area -->
		<div class="popHeader" id="pop_header">
			<h1 class="title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></h1>
			<button class="Close" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>" onclick="window.close();"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></button>
		</div>
		<!-- // Layout : header Area -->

		<!-- Layout : container Area -->
		<div class="popContainer" id="popup_contents">
			<!-- 입력폼 // -->
			<form name="frm_supplierInfo_insert" modelAttribute="RcvSVO" method="post">
				<div class="tableTy2">
					<div class="dataArea">
						<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
						<!-- 라운드 디자인을 위함. -->
						<input type="hidden" name="searchConditions" value="<?php echo $_POST[searchConditions]; ?>">
						<input type="hidden" name="currentPageNo" value="<?php echo $_POST[currentPageNo]; ?>">
						<input type="hidden" name="isBack" value="<?php echo $_POST[isBack]; ?>">
						<input type="hidden" name="bizRegNo" value="<?php echo $_POST[bizRegNo]; ?>">
						<table class="data">
							<colgroup>
								<col style="width: 20%">
								<col style="width: 80%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row"><em class="pointTxt2" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>"></em><label for="bizRegNoTemp"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
									<td>
										<input type="text" id="bizRegNoTemp" name="bizRegNoTemp" class="text" maxlength="11" size="80%" value="<?php echo $_POST['bizRegNoTemp'] ?>"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageSupplierSrch()', '^[^<>]*$', 14, document.frm_supplierInfo_insert.supplierNm);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
								<tr>
									<th scope="row"><em class="pointTxt2" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>"></em><label for="supplierNm"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
									<td>
										<input type="text" name="supplierNm" id="supplierNm" class="text" maxlength="200" size="80%" value="<?php echo $_POST['supplierNm'] ?>"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageSupplierSrch()', '^[^<>]*$', 14, document.frm_supplierInfo_insert.bizRegNoTemp);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- //입력폼 끝 -->

				<div class="fR mt15 mb20">
					<span class="btnTy3"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>" onclick="javascript:fn_selectListPageSupplierSrch();"></span>
				</div>
				<iframe name="SupplierSrchPopupFrame" id="SupplierSrchPopupFrame" width="100%" height="180px" frameborder="0" scrolling="no"></iframe>
			</form>
		</div>
		<!-- // Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><button class="btn" onClick="window.close();" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></button></span>
		</div>
		<!-- // Layout : Button Area -->
	</div>
</div>
</body>
</html>