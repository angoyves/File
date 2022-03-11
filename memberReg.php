<?php
/*if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "A";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "connexion_old.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}*/
?>
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
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<validator formName="frm_pubPm_insert" staticJavascript="false" xhtml="true" cdata="false"></validator:javascript>
<script type="text/javascript" src="js/common/font.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/validation.js"></script>
<script type="text/javascript" src="js/common/frame.js"></script>
<script type="text/javascript" src="js/common/ajax.js"></script>
<script type="text/javascript" src="js/common/string.js"></script>
<script type="text/javascript" src="js/common/event.js"></script>
<script type="text/javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_common', $ObjId = 'confirm_logout'); ?>", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "user/logOut.php";
	}
	
	//작성 내용 저장 :: Save Information
	 function fn_insertPubPayment(){
	 	var form = document.frm_pubPm_insert;
	 
	 	// 파일 태그 추가후 선택을 하지 않은 경우
		if(!fn_checkSelectedFile()){
			return;
		}
	 	
	 	util_trimRequiredValue(form);
	 	if(!validateFrm_pubPm_insert(form)){
			return;
		}else{
			util_confirmAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubPaymentReg', $ObjId = 'bidNo'); ?> [" + form.bidNo.value + "-" + form.bidModSeq.value +"] " 
					+ "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_save_msg_dbf'); ?>" ,"fn_submitInsertPubPayment()");
		}
	 	
	 }
	
	 //Form Submit
	 function fn_submitInsertPubPayment(){
	
		 var form = document.frm_pubPm_insert;
		
		 //처리중 이미지 만들기
		 util_showExecutionImage();
		
		 form.action = "<c:url value='/ed/rcv/insertPubPayment.do'></c:url>";
		 form.target = "ResultFrame";
		 form.submit();
	 }
 
	//입찰공고번호 검색 팝업
	function fn_searchBidNo(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url = "PubSrchPopup.php";
		window.open(url, 'pubBidSrchPop', openParam);
	}
	
	//조달업체 검색 팝업
	function fn_searchSupplier(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url    = "SupplierSrchPopup.php";
		window.open(url, 'pubSupplierSrchPop', openParam);
	}

	//목록으로 이동
	function fn_movePubPaymentList(){
		history.go(-1);
	}

	function fn_goPage(exDocType) {

		var form = document.frm_pubPm_insert;
		
		form.exDocType.value = exDocType;
		
		form.action = "<c:url value='/ed/rcv/moveCtDocList.do'></c:url>";
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
			<img src="images/admin_top.jpg" alt="top">
		</div>
		<div class="gnb">
			${ExmsLangCodeSelectDivStr}
		</div>
		<div class="con_wrap">
		  <div class="menu">
		    <!-- Menu BEGIN -->
		    <ul>
		      <li class="depth1_on">
		        <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1'); ?></p>
		        <ul>
		          <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1_1'); ?></a></a>
		            <p></p>
	              </li>
	            </ul>
	          </li>
		      <li class="depth1_on">
		        <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2'); ?></p>
		        <ul>
		          <li class="depth2"><a href="repcou.php?value=142"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_1'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcou.php?value=144"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_2'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcou.php?value=145"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_3'); ?></a>
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
		          <li class="depth2"><a href="repcom.php?value=142"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_1'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcom.php?value=144"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_2'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcom.php?value=145"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_3'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_4'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_5'); ?></a>
		            <p></p>
	              </li>
		          <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth3_6'); ?></a>
		            <p></p>
	              </li>
	            </ul>
	          </li>
		      <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
		      <li class="depth1_on">
		        <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4'); ?></p>
		        <ul>
		          <li class="depth2"><a href="repcse.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_1'); ?></a></li>
		          <li class="depth2"><a href="repcse.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_2'); ?></a></li>
		          <li class="depth2"><a href="repcse.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_3'); ?></a></li>
		          <li class="depth2"><a href="repcse.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_4'); ?></a></li>
	            </ul>
	          </li>
		      <?php //} ?>
		      <li class="depth1_on">
		        <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5'); ?></p>
		        <ul>
		          <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_1'); ?></a></li>
		          <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_2'); ?></a></li>
		          <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_3'); ?></a></li>
		          <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_4'); ?></a></li>
	            </ul>
	          </li>
		      <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
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
		      <?php //} ?>
	        </ul>
	      </div>
		  <!-- //menu END -->

	  <div class="content" id="contents">
				<h1 class="h1_title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></h1>
				<div class="tableTy1">
					<div class="dataArea">
						<form name="frm_pubPm_insert" modelAttribute="RcvSVO" method="post" encType="multipart/form-data">
						<input type="hidden" name="bidLot" value="NON" >
							<table class="data">
								<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: *">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL"><em class="pointTxt2" >*</em> <?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></th>
										<td>Value<input type="hidden" name="exDocType" value="DBF"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bidNo"><em class="pointTxt2">*</em> <?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
										<td>
											<input type="text" class="text"  id="bidNo" style="width: 48%" name="bidNo" readonly="readonly">&nbsp;<input type="text" class="text"  id="bidModSeq" style="width: 20%" name="bidModSeq" readonly="readonly">
											<span class="btnTy3"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'memberReg', $ObjId = 'SearchBtn'); ?>" onClick="javascript:fn_searchBidNo();"></span>
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bidNm"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
										<td><input type="text" class="text"  id="bidNm" style="width: 70%" name="bidNm" readonly="readonly"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="guarBidAmt"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
										<td><input type="text" class="text"  id="guarBidAmt" style="width: 20%" name="guarBidAmt" readonly="readonly">&nbsp;<input type="text" class="text"  id="guarBidCurr" style="width: 10%" name="guarBidCurr" readonly="readonly"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bizRegNo"><em class="pointTxt2">*</em> <?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></label></th>
										<td>
											<input type="text" class="text"  id="bizRegNo" style="width: 20%" name="bizRegNo" readonly="readonly">
											&nbsp;<input type="text" class="text"  id="supplierNm" style="width: 48%" name="supplierNm" readonly="readonly">
											<span class="btnTy3"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>" onClick="javascript:fn_searchSupplier();"></span>
										</td>
									</tr>
									<tr>
									  <td style="display: none;">
											<?php include("FileUpDnInsert.php"); ?>
										</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>" onClick="javascript:fn_insertPubPayment();"></span>
					<span class="btnTy21"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>" onClick="javascript:fn_movePubPaymentList();"></span>
				</div>
			</div><!-- //content END -->
			<c:out value="${footer}" escapeXml="false"></c:out>
		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div><!-- //main END -->
</body>
</html>