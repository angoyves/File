<?php require_once('../Connections/MyFileConnect.php'); ?>
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
if (isset($_POST['userIdTemp'])) {
  $colname_Recordset = $_POST['userIdTemp'];
}
$colname2_Recordset = "-1";
if (isset($_POST['acceptYn'])) {
  $colname2_Recordset = $_POST['acceptYn'];
}
$colname3_Recordset = "-1";
if (isset($_POST['supplierNm'])) {
  $colname3_Recordset = $_POST['supplierNm'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
//$query = "SELECT user_id, user_name, user_login, display_agescom, supplierNm, telNo, eMail, acceptYn, regDt FROM users";
$query = "SELECT user_id, user_name, user_login, supplierNm, telNo, regDt, acceptYn, display_agescom FROM users";

if (isset($_POST['userIdTemp'])) {
$query_Recordset = sprintf("%s WHERE user_login LIKE %s ORDER BY user_id DESC", $query, GetSQLValueString("%" . $colname_Recordset . "%", "text"));
}
if (isset($_POST['acceptYn'])) {
$query_Recordset = sprintf("%s WHERE acceptYn LIKE %s ORDER BY user_id DESC", $query, GetSQLValueString("%" . $colname2_Recordset . "%", "text"));
}
if (isset($_POST['supplierNm'])) {
$query_Recordset = sprintf("%s WHERE supplierNm LIKE %s ORDER BY user_id DESC", $query, GetSQLValueString("%" . $colname3_Recordset . "%", "text"));
}
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
<title>Enregistrement d'Utilisateur </title>
<link rel="stylesheet" href="../css/common.css" media="all">
<link rel="stylesheet" href="../css/sub.css" media="all">
<script type="text/javascript" src="../jscommon/font.js"></script>
<script type="text/javascript" src="../jscommon/alert.js"></script>
<script type="text/javascript" src="../jscommon/alertExms.js"></script>
<script type="text/javascript" src="../jscommon/pagination.js"></script>
<script type="text/javascript" src="../jscommon/frame.js"></script>
<script type="text/javascript" src="../jscommon/ajax.js"></script>
<script type="text/javascript" src="../jscommon/event.js"></script>
<script type="text/javaScript" language="javascript">

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		//처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("UserFrame", 100);
		}else{
			util_resizeFrame("UserFrame");
		}
		util_initCompSearchConditions('frm_user');
	}
	 
	//상세화면 이동 처리 함수 :: More screen-handling functions
	function fn_moveUserDetail(userId){
		var form = parent.document.frm_user;
		form.userId.value = userId;
		form.target = "_top";
		form.action = "UserDetailsAdmin.php";
		form.submit();
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad();">
<div id="frameDiv">
	<!-- <div class="content"> -->
	<div class="tableTy1">
		<form name="frm_user_list" modelAttribute="UserSVO" method="post">
<table class="data rowEven">
				<caption><l:mapping programId="User" objId="title"></l:mapping></caption>
				<colgroup>
					<col style="width: 5%">
                    <col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 13%">
					<col style="width: 17%">
					<col style="width: 20%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col">N°</th>
						<th scope="col">ID Utilisateur</th>
						<th scope="col">Service Emetteur</th>
						<th scope="col">Téléphone</th>
						<th scope="col">Date de Demande</th>
						<th scope="col">Statut</th>
					</tr>
				</thead>
				<tbody>
                    <?php $i=0; if ($totalRows_Recordset <> 0) { // Show if recordset isset ?>
						<?php do { $i++; ?>
                        <tr>
                         <td class="tL"><?php echo $i; ?>&nbsp;</td>
                         <td class="tL"><a href="#" onClick="javascript:fn_moveUserDetail('<?php echo $row_Recordset['user_id']; ?>');"><?php echo $row_Recordset['user_login']; ?></a></td>
                         <td class="tL"><?php echo $row_Recordset['supplierNm']; ?></td>
                         <td class="tL"><?php echo $row_Recordset['telNo']; ?></td>
                         <td class="tL"><?php echo $row_Recordset['regDt']; ?></td>
                         <td class="tC">
                                                <?php if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='Y'){ ?>
                                                    Validé
                                                <?php }  else if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='N'){ ?>
                                                    Renvoyé
                                                <?php } else if (isset($row_Recordset['acceptYn']) && $row_Recordset['acceptYn']=='R'){ ?>
                                                    <span class="bold"><font color="F15F5F">Validation Demandée</font></span>
                                                <?php } ?>
                          </td>
                      </tr>
                    <?php } while ($row_Recordset = mysql_fetch_assoc($Recordset)); ?>
                    <?php } // Show if recordset isset ?>
                      <?php if ($totalRows_Recordset == 0) { // Show if recordset empty ?>
                        <tr>
                          <td colspan="6" style="width: 740px" align="center">Aucun résultat.</td>
                        </tr>
                        <?php } // Show if recordset empty ?>
				</tbody>
			</table>
		</form>
	</div>
	
	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${UserSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_user" listURL="/ed/user/selectListPageUser.do" paginationInfo="${UserSVO}" target="UserFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset);
?>
