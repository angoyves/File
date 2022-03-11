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

$maxRows_Recordset = 10;
$pageNum_Recordset = 0;
if (isset($_GET['pageNum_Recordset'])) {
  $pageNum_Recordset = $_GET['pageNum_Recordset'];
}
$startRow_Recordset = $pageNum_Recordset * $maxRows_Recordset;

$colname_Recordset = "-1";
if (isset($_POST['bidNm'])) {
  $colname_Recordset = $_POST['bidNm'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_lib LIKE %s AND (type_commission_id = 4 OR type_commission_id = 8  OR type_commission_id = 7) ORDER BY commission_lib ASC", GetSQLValueString("%" . $colname_Recordset . "%", "text"));
$query_limit_Recordset = sprintf("%s LIMIT %d, %d", $query_Recordset, $startRow_Recordset, $maxRows_Recordset);
$Recordset = mysql_query($query_limit_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);

if (isset($_GET['totalRows_Recordset'])) {
  $totalRows_Recordset = $_GET['totalRows_Recordset'];
} else {
  $all_Recordset = mysql_query($query_Recordset);
  $totalRows_Recordset = mysql_num_rows($all_Recordset);
}
$totalPages_Recordset = ceil($totalRows_Recordset/$maxRows_Recordset)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopup', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<link rel="stylesheet" href="css/sub.css" media="all">
<!--<c:out value="${commonScript}" escapeXml="false"></c:out>
--><script type="text/javascript" src="js/common/font.js"></script>
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

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		// 처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("PubSrchPopupFrame", 100);
		}else{
			util_resizeFrame("PubSrchPopupFrame");
		}
		util_initCompSearchConditions('frm_bidInfo_insert');
	}

	function fn_selectInst(bidNo, bidModSeq, bidNm, guarBidAmt, guarBidCurr, onOffType){
		
		if (onOffType == "FF") {
			parent.fn_messageAlert();
			return;
		}
		
		parent.window.opener.document.frm_pubPm_insert.bidNo.value = bidNo;
		parent.window.opener.document.frm_pubPm_insert.bidModSeq.value = bidModSeq;
		parent.window.opener.document.frm_pubPm_insert.bidNm.value = util_decodeQuot(bidNm);
		parent.window.opener.document.frm_pubPm_insert.guarBidAmt.value = guarBidAmt;
		parent.window.opener.document.frm_pubPm_insert.guarBidCurr.value = guarBidCurr;
		parent.window.close();
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad();">
<div id="frameDiv">
	<!-- <div class="content"> -->
	<div class="tableTy1">
			<table class="data rowEven">
				<caption><l:mapping programId="PubSrchPopup" objId="title"></l:mapping></caption>
				<colgroup>
					<col style="width: 20%">
					<col style="width: 40%">
					<col style="width: 20%">
					<col style="width: 20%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopupFrame', $ObjId = 'bidNo'); ?></th>
						<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopupFrame', $ObjId = 'bidNm'); ?></th>
						<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopupFrame', $ObjId = 'pmt_guarBidAmt'); ?></th>
						<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubSrchPopupFrame', $ObjId = 'bdRcvEndDt'); ?></th>
					</tr>
				</thead>
				<tbody>
              <?php do { ?>
                <input type="hidden" name="todayTime" value="${RcvSVO.todayTime}">
				<input type="hidden" name="bdRcvEndDt" value="${resultInfo.bdRcvEndDt}">
                <?php if ($totalRows_Recordset > 0) { // Show if recordset not empty ?>
  <tr>
    <td class="tC"><a href="#" onClick="fn_selectInst('<?php echo $row_Recordset['localite_id']; ?>','<?php echo $row_Recordset['structure_id']; ?>','<?php echo $row_Recordset['commission_lib']; ?>','<?php echo $_POST['guarBidAmt']; ?>','<?php echo $_POST['guarBidCurr']; ?>', '<?php echo $_POST['onOffType']; ?>');"><?php echo $row_Recordset['localite_id']; ?></a></td>
    <td class="tC"><?php echo $row_Recordset['structure_id']; ?></td>
    <td class="tC"><?php echo $row_Recordset['region_id']; ?></td>
    <td class="tL"><?php echo $row_Recordset['commission_lib']; ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_Recordset = mysql_fetch_assoc($Recordset)); ?>
      <?php if ($totalRows_Recordset == 0) { // Show if recordset empty ?>
        <tr>
          <td colspan="4" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_no_result_msg'); ?></td>
        </tr>
        <?php } // Show if recordset empty ?>
</tbody>
			</table>
			<p>&nbsp;</p>
  </div>

	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${RcvSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_bidInfo_insert" listURL="/ed/rcv/pubPaymentSrchListPopupFrame.do" paginationInfo="${RcvSVO}" target="PubSrchPopupFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset);
?>
