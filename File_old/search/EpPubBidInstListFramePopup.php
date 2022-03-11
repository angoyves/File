<?php require_once('../../../Connections/MyFileConnect.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecordsetPersonne = 5;
$pageNum_RecordsetPersonne = 0;
if (isset($_GET['pageNum_RecordsetPersonne'])) {
  $pageNum_RecordsetPersonne = $_GET['pageNum_RecordsetPersonne'];
}
$startRow_RecordsetPersonne = $pageNum_RecordsetPersonne * $maxRows_RecordsetPersonne;

$colname_RecordsetPersonne = "-1";
if (isset($_POST['instNm'])) {
  $colname_RecordsetPersonne = $_POST['instNm'];
}
$colname2_RecordsetPersonne = "-1";
if (isset($_POST['instCd'])) {
  $colname2_RecordsetPersonne = $_POST['instCd'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
//echo $query_RecordsetPersonne = sprintf("SELECT personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade FROM personnes WHERE personne_nom LIKE %s OR personne_matricule LIKE %s", GetSQLValueString("%" . $colname_RecordsetPersonne . "%", "text"), GetSQLValueString("%" . $colname2_RecordsetPersonne . "%", "text"));

if ((isset($colname_RecordsetPersonne) && $colname_RecordsetPersonne <> "") && (isset($colname2_RecordsetPersonne) && $colname2_RecordsetPersonne <> ""))  {
$query_RecordsetPersonne = sprintf("SELECT personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade FROM personnes WHERE personne_nom LIKE %s AND personne_matricule LIKE %s ", GetSQLValueString("%" . $colname_RecordsetPersonne . "%", "text"), GetSQLValueString("%" . $colname2_RecordsetPersonne . "%", "text"));
} else if ((isset($colname_RecordsetPersonne) && $colname_RecordsetPersonne <> "") && (isset($colname2_RecordsetPersonne) && $colname2_RecordsetPersonne == "")) {
$query_RecordsetPersonne = sprintf("SELECT personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade FROM personnes WHERE personne_nom LIKE %s", GetSQLValueString("%" . $colname_RecordsetPersonne . "%", "text"));

} else if ((isset($colname_RecordsetPersonne) && $colname_RecordsetPersonne == "") && (isset($colname2_RecordsetPersonne) && $colname2_RecordsetPersonne <> "")) {
$query_RecordsetPersonne = sprintf("SELECT personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade FROM personnes WHERE personne_matricule LIKE %s", GetSQLValueString("%" . $colname2_RecordsetPersonne . "%", "text"));
} else {
 $query_RecordsetPersonne = "SELECT personne_id, personne_matricule, personne_nom, personne_prenom, personne_grade FROM personnes";
}

$query_limit_RecordsetPersonne = sprintf("%s LIMIT %d, %d", $query_RecordsetPersonne, $startRow_RecordsetPersonne, $maxRows_RecordsetPersonne);
$RecordsetPersonne = mysql_query($query_limit_RecordsetPersonne, $MyFileConnect) or die(mysql_error());
$row_RecordsetPersonne = mysql_fetch_assoc($RecordsetPersonne);

if (isset($_GET['totalRows_RecordsetPersonne'])) {
  $totalRows_RecordsetPersonne = $_GET['totalRows_RecordsetPersonne'];
} else {
  $all_RecordsetPersonne = mysql_query($query_RecordsetPersonne);
  $totalRows_RecordsetPersonne = mysql_num_rows($all_RecordsetPersonne);
}
$totalPages_RecordsetPersonne = ceil($totalRows_RecordsetPersonne/$maxRows_RecordsetPersonne)-1;

$queryString_RecordsetPersonne = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecordsetPersonne") == false && 
        stristr($param, "totalRows_RecordsetPersonne") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecordsetPersonne = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecordsetPersonne = sprintf("&totalRows_RecordsetPersonne=%d%s", $totalRows_RecordsetPersonne, $queryString_RecordsetPersonne);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>공고기관 조회</title>
<link rel="stylesheet" href="../../../css/common.css" media="all">
<c:out value="${commonScript}" escapeXml="false"/>
<script type="text/javascript" src="../../../js/common/frame.js"></script>
<script type="text/javascript" src="../../../js/common/pagination.js"></script>
<script type="text/javascript" src="../../../js/common/string.js"></script>
<script type="text/javaScript" language="javascript">
/* ********************************************************
 * 화면초기화
 ******************************************************** */
function fn_onLoad(){
	
	//util_resizeFrame("EpPubBidInstListFramePopup");
	util_resizeFrame('EpPubBidInstListFramePopup'); 
	util_initCompSearchConditions('frm_pub_bidInst');

}

/****************************
* 발주기관 선택
****************************/
function fn_selectInst(instCd, instNm, idPerson){
	
	var opener = parent.window.opener.document;
	
	/* var retObj = {};
		retObj.instCd = instCd;
		retObj.instNm = instNm;
		retObj.from = "order"; */
	
	opener.getElementById("instCd").value = instCd;
	opener.getElementById("instNm").value = instNm;
	opener.getElementById("idPerson").value = idPerson;

	window.returnValue=true;
	parent.close();
	
}
</script>
</head>
<body onLoad="fn_onLoad()">
	
<div id="frameDiv">
 	<div class="tableTy1">
		<table class="data rowEven">
        <colgroup>
					<col style="width: 20%">
					<col style="width: 35%">
					<col style="width: 35%">
					<col style="width: 10%">
				</colgroup>
				<thead>
					<tr>
                        <th scope="col">Matricule
                          <label>
                            <input type="hidden" name="textfield" id="textfield" value="<?php echo $colname_RecordsetPersonne; ?>">
                      </label></th>
                        <th scope="col">Nom
                          <label>
                            <input type="hidden" name="textfield2" id="textfield2" value="<?php echo $colname2_RecordsetPersonne; ?>">
                      </label></th>
                        <th scope="col">Prenom</th>
                        <th scope="col">CNIe</th>
					</tr>
				</thead>
			  <tbody>
					  <?php do { ?>
                        <tr>
                          <td class="tL"><a href="#" style="cursor:pointer; cursor:hand;" onClick="javascript:fn_selectInst('<?php echo $row_RecordsetPersonne['personne_matricule']; ?>','<?php echo $row_RecordsetPersonne['personne_nom'] ?>','<?php echo $row_RecordsetPersonne['personne_id']; ?>'); return false;">
		       				<?php echo $row_RecordsetPersonne['personne_matricule']; ?>
		       				</a>&nbsp; </td>
                          <td class="tL"><a href="#" style="cursor:pointer; cursor:hand;" onClick="javascript:fn_selectInst('<?php echo $row_RecordsetPersonne['personne_matricule']; ?>','<?php echo $row_RecordsetPersonne['personne_nom'] ?>','<?php echo $row_RecordsetPersonne['personne_id']; ?>'); return false;"><?php echo $row_RecordsetPersonne['personne_nom']; ?></a>&nbsp; </td>
                          <td class="tL"><a href="#" style="cursor:pointer; cursor:hand;" onClick="javascript:fn_selectInst('<?php echo $row_RecordsetPersonne['personne_matricule']; ?>','<?php echo $row_RecordsetPersonne['personne_nom'] ?>','<?php echo $row_RecordsetPersonne['personne_id']; ?>'); return false;"><?php echo $row_RecordsetPersonne['personne_prenom']; ?></a>&nbsp; </td>
                          <td class="tL"><a href="#" style="cursor:pointer; cursor:hand;" onClick="javascript:fn_selectInst('<?php echo $row_RecordsetPersonne['personne_matricule']; ?>','<?php echo $row_RecordsetPersonne['personne_nom'] ?>','<?php echo $row_RecordsetPersonne['personne_id']; ?>'); return false;"><?php echo $row_RecordsetPersonne['personne_telephone']; ?></a>&nbsp; </td>
                        </tr>
                        <?php } while ($row_RecordsetPersonne = mysql_fetch_assoc($RecordsetPersonne)); ?>
                  <?php if ($totalRows_RecordsetPersonne == 0) { // Show if recordset empty ?>
                          <tr>
                            <td colspan="5" style="width: 740px" align="center">Aucun Enregistrement trouvé</td>
                          </tr>
                      <?php } // Show if recordset empty ?>
                      
			</tbody>
		</table>
            <table border="0">
      <tr>
        <td><?php if ($pageNum_RecordsetPersonne > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RecordsetPersonne=%d%s", $currentPage, 0, $queryString_RecordsetPersonne); ?>">Premier</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecordsetPersonne > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_RecordsetPersonne=%d%s", $currentPage, max(0, $pageNum_RecordsetPersonne - 1), $queryString_RecordsetPersonne); ?>">Précédent</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecordsetPersonne < $totalPages_RecordsetPersonne) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RecordsetPersonne=%d%s", $currentPage, min($totalPages_RecordsetPersonne, $pageNum_RecordsetPersonne + 1), $queryString_RecordsetPersonne); ?>">Suivant</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecordsetPersonne < $totalPages_RecordsetPersonne) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_RecordsetPersonne=%d%s", $currentPage, $totalPages_RecordsetPersonne, $queryString_RecordsetPersonne); ?>">Dernier</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>
        Enregistrements <?php echo ($startrow_RecordsetPersonne + 1) ?> à <?php echo min($startrow_RecordsetPersonne + $maxRows_RecordsetPersonne, $totalRows_RecordsetPersonne) ?> sur <?php echo $totalRows_RecordsetPersonne ?>
  </div>
	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${epPubSVO}"/>
	</div>
	<div class="boardNavigation" style="text-align: center;">
		<ul class="page">
			<tf:pagination formName="frm_pub_bidInst" listURL="/ep/pub/moveEpPubBidInstListFrame.do" paginationInfo="${epPubSVO}" target="EpPubBidInstListFramePopup"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>
<?php
mysql_free_result($RecordsetPersonne);
?>
