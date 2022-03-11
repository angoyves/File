<?php //require_once('../Connections/MyFileConnect.php'); ?>
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
if (isset($_POST['supplierNm'])) {
  $colname_Recordset = $_POST['supplierNm'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM personnes WHERE personne_nom LIKE %s ORDER BY personne_nom ASC", GetSQLValueString("%" . $colname_Recordset . "%", "text"));
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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<link rel="stylesheet" href="css/sub.css" media="all">
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

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		// 처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("SupplierSrchPopupFrame", 100);
		}else{
			util_resizeFrame("SupplierSrchPopupFrame");
		}
		util_initCompSearchConditions('frm_supplierInfo_insert');
	}

	function fn_selectSupplier(bizRegNo, supplierNm){
		parent.window.opener.document.frm_pubPm_insert.bizRegNo.value = bizRegNo;
		parent.window.opener.document.frm_pubPm_insert.supplierNm.value = util_decodeQuot(supplierNm);
		parent.window.close();
	}

</script>
</head>
<body onLoad="fn_onLoad()">
<div id="frameDiv">
<!-- <div class="content"> -->
	<div class="tableTy1">
	  <p>&nbsp;</p>
<table class="data rowEven">
				<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'SupplierSrchPopup', $ObjId = 'title'); ?></caption>
				<colgroup>
					<col style="width: 30%">
					<col style="width: 35%">
                    <col style="width: 35%">
				</colgroup>
				<thead>
                    <tr>
                      <th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></td>
                      <th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></td>
                      <th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?></td>
                    </tr>
                </thead>
				<tbody>
                  <?php do { ?>
                      <tr>
                        <td class="tC"><a href="#" onClick="fn_selectSupplier('<?php echo $row_Recordset['personne_matricule']; ?>', '<?php echo $row_Recordset['personne_nom']; ?>');">
						<?php echo $row_Recordset['personne_nom']; ?></a></td>
                        <td class="tL"><?php echo $row_Recordset['personne_nom']; ?></td>
                        <td class="tL"><?php echo $row_Recordset['personne_prenom']; ?></td>
                      </tr>
                  <?php } while ($row_Recordset = mysql_fetch_assoc($Recordset)); ?>
                  <?php if ($totalRows_Recordset == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="3" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_no_result_msg'); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
      </tbody>
	  </table>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset);
?>
