<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require("../includes/db.php"); ?>
<?php require('../CtrL/listCommissionCtrl.php'); ?>
<?php 
	  require_once('../includes/db.php');
	  require("../src/inc/design.inc.php");
	  require("../src/inc/biblio.inc.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  require("../src/inc/db.php");
	  require('../includes/MyFonction.php');
	  require('../includes/upload.php');
?>
<?php 
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rsCommissions = 10;
$pageNum_rsCommissions = 0;
if (isset($_GET['pageNum_rsCommissions'])) {
  $pageNum_rsCommissions = $_GET['pageNum_rsCommissions'];
}
$startRow_rsCommissions = $pageNum_rsCommissions * $maxRows_rsCommissions;

$txtSearch = isset($_REQUEST['commissionLib'])?$_REQUEST['commissionLib']:" ";
mysql_select_db($database_MyFileConnect, $MyFileConnect);
if (isset($_GET['comID']) && ($_GET['comID'] != "")) {
	
$query_rsCommissions = sprintf("SELECT commission_id, commission_lib, commission_sigle, lib_nature, type_commission_lib, localite_lib, membre_insert, commissions.region_id, region_lib FROM commissions, natures, type_commissions, localites, regions WHERE commissions.region_id = regions.region_id AND commissions.nature_id = natures.nature_id  AND commissions.type_commission_id = type_commissions.type_commission_id  AND commissions.localite_id = localites.localite_id AND commission_id = %s AND commissions.display_agescom = 1 ORDER BY commissions.commission_id DESC", GetSQLValueString($_GET['comID'], "int"));
} else {
$query_rsCommissions = sprintf("SELECT commission_id, commission_lib, commission_sigle, lib_nature, type_commission_lib, localite_lib, membre_insert, commissions.region_id, region_lib FROM commissions, natures, type_commissions, localites, regions, structures WHERE commissions.region_id = regions.region_id AND commissions.structure_id = structures.structure_id AND commissions.nature_id = natures.nature_id  AND commissions.type_commission_id = type_commissions.type_commission_id  AND commissions.localite_id = localites.localite_id AND (commission_sigle LIKE %s OR commission_lib LIKE %s OR localite_lib LIKE %s OR region_lib LIKE %s OR type_commission_lib LIKE %s OR code_structure LIKE %s) AND commissions.display_agescom = 1 ORDER BY commissions.commission_id DESC", GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));
}

$query_limit_rsCommissions = sprintf("%s LIMIT %d, %d", $query_rsCommissions, $startRow_rsCommissions, $maxRows_rsCommissions);
$rsCommissions = mysql_query($query_limit_rsCommissions, $MyFileConnect) or die(mysql_error());
$row_rsCommissions = mysql_fetch_assoc($rsCommissions);

if (isset($_GET['totalRows_rsCommissions'])) {
  $totalRows_rsCommissions = $_GET['totalRows_rsCommissions'];
} else {
  $all_rsCommissions = mysql_query($query_rsCommissions);
  $totalRows_rsCommissions = mysql_num_rows($all_rsCommissions);
}
$totalPages_rsCommissions = ceil($totalRows_rsCommissions/$maxRows_rsCommissions)-1;
$pageNum_rsCommissions = 0;
if (isset($_GET['pageNum_rsCommissions'])) {
  $pageNum_rsCommissions = $_GET['pageNum_rsCommissions'];
}
$startRow_rsCommissions = $pageNum_rsCommissions * $maxRows_rsCommissions;
?>
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
	function fn_movePubPaymentDetail(comSigle, comLib, strucId, comId){
		var form = parent.document.frm_pubCommission;
		form.bidNo.value = comSigle;
		form.exDocType.value = comLib;
		form.bidModSeq.value = strucId;
		form.bizRegNo.value = comId;
		//form.Page.value = "CommissionDetails.php";
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
    <table class="data">
      <caption>
        Mes Informations
        </caption>
      <colgroup>
        <col style="width: 5%">
        <col style="width: 35%">
        <col style="width: 20%">
        <col style="width: 20%">
        <col style="width: 20%">
      </colgroup>
      <tbody>
        <tr>
          <th scope="row" class="noLine tL">&nbsp;</th>
          <th nowrap="nowrap" class="data rowEven"> Sigle</th>
          <th nowrap="nowrap" class="data rowEven">Localit&eacute;</th>
          <th nowrap="nowrap" class="data rowEven">Departement</th>
          <th nowrap="nowrap" class="data rowEven">Regions&nbsp;</th>
          </tr>
        
        <?php $counter=0; do  { $counter++; ?>
        <?php if ($totalRows_rsCommissions > 0) { // Show if recordset not empty ?>
  <tr>
    <td scope="row" class="noLine tL"><?php if ($countID >= '3') { ?>
      <?php   if ((strcmp($_GET['comID'], $row_rsCommissions['commission_id']))) { ?>
      <a href="show_commissions.php?menuID=<?php echo $_GET['menuID'];?>&amp;action=<?php echo $_GET['action'];?>&amp;comID=<?php echo $row_rsCommissions['commission_id']; ?>&amp;typID=<?php echo $_GET['typID']; ?>" class="control"><img src="../images/img/s_okay.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } else { ?>
      <a href="show_commissions.php" class="control"><img src="../images/img/b_drop.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } ?>
      <?php } else { ?>
      <a href="show_commissions.php?menuID=<?php echo $_GET['menuID'];?>&amp;action=<?php echo $_GET['action'];?>&amp;comID=<?php echo $row_rsCommissions['commission_id']; ?>&amp;typID=<?php echo $_GET['typID']; ?>" class="control"><img src="../images/img/s_attention.png" alt="" width="16" height="16" align="absmiddle"/></a>
      <?php } ?></td>
    <td><a href="#" onClick="javascript:fn_movePubPaymentDetail('<?php echo $row_Recordset['commission_sigle'] ?>','<?php echo $row_Recordset['commission_lib']; ?>','<?php echo $row_Recordset['structure_id']; ?>','<?php echo $row_rsCommissions['commission_id']; ?>');"><?php echo strtoupper($row_rsCommissions['commission_sigle']) ?> <?php //echo $row_rsCommissions['commission_id']; ?></a> &nbsp;
      <?php $commissionName = $row_rsCommissions['commission_lib']; ?>
      <?php $url = MyDB::getInstance()->get_lib_by_id(fichiers, url, commissions_commission_id, $row_rsCommissions['commission_id']);?></td>
    <td><?php echo strtoupper($row_rsCommissions['localite_lib']); ?>&nbsp;
      <?php 
	  
	$colname_RsShowSession = "-1";
	if (isset($row_rsCommissions['commission_id'])) {
	  $colname_RsShowSession = $row_rsCommissions['commission_id'];
	}
	mysql_select_db($database_MyFileConnect, $MyFileConnect);
	$query_RsShowSession = sprintf("SELECT distinct(membres_commissions_commission_id) FROM sessions WHERE membres_commissions_commission_id = %s", GetSQLValueString($colname_RsShowSession, "text"));
	$RsShowSession = mysql_query($query_RsShowSession, $MyFileConnect) or die(mysql_error());
	$row_RsShowSession = mysql_fetch_assoc($RsShowSession);
	$totalRows_RsShowSession = mysql_num_rows($RsShowSession); ?>
      <?php 
		$colname_RsNombresSession = "-1";
if (isset($row_rsCommissions['commission_id'])) {
  $colname_RsNombresSession = $row_rsCommissions['commission_id'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_RsNombresSession = sprintf("SELECT count(commissions_commission_id) as Nombre FROM commissions, membres, fonctions, personnes WHERE membres.commissions_commission_id = commissions.commission_id    AND fonctions_fonction_id = fonctions.fonction_id    AND personnes_personne_id = personne_id   AND membres.fonctions_fonction_id BETWEEN 1 AND 3  AND personnes.display = 1   AND commissions_commission_id = %s  AND personnes.add_commission = 2", GetSQLValueString($colname_RsNombresSession, "int"));
$RsNombresSession = mysql_query($query_RsNombresSession, $MyFileConnect) or die(mysql_error());
$row_RsNombresSession = mysql_fetch_assoc($RsNombresSession);
$totalRows_RsNombresSession = mysql_num_rows($RsNombresSession);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeCommission = "SELECT type_commission_id, type_commission_lib FROM type_commissions WHERE display = '1'";
$rsTypeCommission = mysql_query($query_rsTypeCommission, $MyFileConnect) or die(mysql_error());
$row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
$totalRows_rsTypeCommission = mysql_num_rows($rsTypeCommission);
	   ?></td>
    <td>&nbsp;</td>
    <td><?php echo strtoupper($row_rsCommissions['region_lib']); ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_rsCommissions = mysql_fetch_assoc($rsCommissions)); ?>
        <?php if ($totalRows_rsCommissions == 0) { // Show if recordset empty ?>
        <tr>
          <td colspan="5" class="noLine tL" scope="row"><?php //echo $query_rsCommissions; ?>Aucun enregistrement trouvé</td>
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
