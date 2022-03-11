<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require('../includes/db.php'); ?>
<?php require('../CtrL/listCommissionCtrl.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><l:mapping programId="PubPayment" objId="title"></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<link rel="stylesheet" href="../css/sub.css" media="all">
<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/alertExms.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/common/frame.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javaScript" language="javascript">
	
	function fn_onLoad(){
		util_hideExecutionAll(parent.document);
		util_resizeFrame("PubCommissionFrame");
		util_initCompSearchConditions('frm_pubCommission');
	}
	
	//상세화면 이동 처리 함수 :: 
	function fn_movePubPaymentDetail(bidNo, exDocType, bidModSeq, bizRegNo){
		var form = parent.document.frm_pubCommission;
		form.bidNo.value = bidNo;
		form.exDocType.value = exDocType;
		form.bidModSeq.value = bidModSeq;
		form.bizRegNo.value = bizRegNo;
		form.target = "_top";
		form.action = "CommissionDetails.php";
		form.submit();
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad()">
<div id="frameDiv">
<!-- <div class="content"> -->
	<div class="tableTy1">
		<form name="frm_pubCommission_list" method="post">
			<table class="data rowEven">
				<caption><l:mapping programId="PubPayment" objId="DBF"></caption>
				<colgroup>
					<col style="width: 20%">
					<col style="width: 60%">
                    <col style="width: 20%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col">SIGLE<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'Sigle'); ?></th>
						<th scope="col">LIBELLE COMMISSION<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'Designation'); ?></th>
						<th scope="col">REGION</th>
					</tr>
				</thead>
				<tbody>
					<?php do { ?>
						<tr>
							<td align="left" class="tC"><a href="#" onClick="javascript:fn_movePubPaymentDetail('<?php echo $row_Recordset['commission_sigle'] ?>','<?php echo $row_Recordset['commission_lib']; ?>','<?php echo $row_Recordset['structure_id']; ?>','<?php echo $row_Recordset['commission_id']; ?>');"><?php echo isset($row_Recordset['commission_sigle'])?$row_Recordset['commission_sigle']:"NULL"; ?></a></td>
							<td class="tL"><?php echo $row_Recordset['commission_lib']; ?></td>
						  <td class="tL">&nbsp;</td>
						</tr>
					<?php } while ($row_Recordset = mysql_fetch_assoc($Recordset)); ?>
                    <?php if ($totalRows_Recordset == 0) { // Show if recordset empty ?>
                      <tr>
                        <td colspan="3" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></td>
                      </tr>
                      <?php } // Show if recordset empty ?>
                </tbody>
			</table>
		</form>
	</div>

	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${RcvSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_pubCommission" listURL="/ed/rcv/selectListPubPayment.do" paginationInfo="${RcvSVO}" target="PubCommissionFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset);
?>
