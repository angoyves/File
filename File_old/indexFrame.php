<?php require_once('Connections/MyFileConnect.php'); ?>
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
?>
<?php
	  require('includes/db.php');
	  require('includes2/db.php');
	  require('includes2/fonction_db.php');
	  require('includes2/DW_Fonctions.php');
	  require('includes2/controler.php');
	  require("inc/biblio.inc.php");
	  //require("membres/include/logfile.php");
	  require("src/inc/mysql_biblio.inc.php");
	  //require('AGIS/includes/MyFonction.php');


?>
<?php

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recordSet = 50;
if (isset($_POST['recordCountPerPage'])) {
  $maxRows_recordSet = $_POST['recordCountPerPage'];
}

$pageNum_recordSet = 0;
if (isset($_GET['pageNum_recordSet'])) {
  $pageNum_recordSet = $_GET['pageNum_recordSet'];
}
$startRow_recordSet = $pageNum_recordSet * $maxRows_recordSet;

if (isset($_GET['value'])) {
  $colValue_fonction = $_GET['value'];
}

if (isset($_POST['instCd'])) {
  $colInstCd = $_POST['instCd'];
}

if (isset($_POST['instNm'])) {
  $colInstNm = $_POST['instNm'];
}

if (isset($_GET['instCd'])) {
  $colTypeMembre = $_GET['typM'];
}

if (isset($_GET['regID'])) {
  $colregID_fonction = $_GET['regID'];
}
if (isset($_GET['depID'])) {
  $coldepID_fonction = $_GET['depID'];
}
if (isset($_GET['typID'])) {
  $coltypID_fonction = $_GET['typID'];
}
$txtSearch = isset($_POST['txtSearch'])?$_POST['txtSearch']:"-1";

mysql_select_db($database_MyFileConnect, $MyFileConnect);

$query_recordSetBasic = "SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_id, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone, fonctions.fonction_id, fonction_lib 
FROM membres, commissions, personnes, fonctions
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND add_commission_agescom = 1 
AND membres.display_agescom = 1";

/*if (isset($colregID_fonction) && ($colValue_fonction==0)){
			if (isset($coldepID_fonction)){
				if ($colTypeMembre){
					$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						AND fonctions_fonction_id = %s 
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($coldepID_fonction, "int"), GetSQLValueString($colTypeMembre, "int"));
					} else {
					$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						AND fonctions_fonction_id = %s
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($colTypeMembre, "int"), GetSQLValueString($colTypeMembre, "int"));
				}
			} else {
				$query_recordSet = sprintf(" %s    
				AND region_id = %s
				ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"));			
			}
		}

if (isset($colValue_fonction)){

	if (isset($colregID_fonction) && ($colValue_fonction==0)){
		if ($coldepID_fonction){
			$query_recordSet = sprintf(" %s    
				AND region_id = %s
				AND departement_id = %s
				ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($coldepID_fonction, "int"));
		} else {
			$query_recordSet = sprintf(" %s    
				AND region_id = %s
				ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"));
		}
	} else if (isset($coltypID_fonction)){
		if (isset($colregID_fonction)){
			if ($coldepID_fonction){
			$query_recordSet = sprintf(" %s   
				AND fonctions_fonction_id = %s 
				AND type_commission_id = %s
				AND region_id = %s
				AND departement_id = %s
				ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($coldepID_fonction, "int"));
			} else {
		$query_recordSet = sprintf(" %s
		AND fonctions_fonction_id = %s 
		AND type_commission_id = %s
		AND region_id = %s
		ORDER BY date_constation, personne_nom ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int")); }
		} else {
	$query_recordSet = sprintf(" %s   
	AND fonctions_fonction_id = %s 
	AND type_commission_id = %s
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"));}
	} else { 
	$query_recordSet = sprintf(" %s  
	AND fonctions_fonction_id = %s  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"));
	
	//GetSQLQueryString($query_recordSetBasic, $coltypID_fonction, $colregID_fonction, $coldepID_fonction);
	} else {
	$query_recordSet = sprintf(" %s   
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic);
	}
	
} else if (isset($txtSearch)){
	$query_recordSet = sprintf(" %s  
	AND (commission_lib LIKE %s OR commission_sigle LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR fonction_lib LIKE %s)  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));
} else {
$query_recordSet = "SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND add_commission_agescom = 1 
AND membres.display_agescom = 1 
ORDER BY personne_nom, date_constation ASC";
}


/********/

if (isset($colInstCd) && ($colInstCd!=0)){	

	$query_recordSet = sprintf(" %s  
	AND (personne_matricule LIKE %s OR personne_nom LIKE %s )  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString("%" . $colInstCd . "%", "text"), GetSQLValueString("%" . $colInstNm . "%", "text"));		
	
} else if (isset($txtSearch) && $txtSearch != "-1"){
	
	$query_recordSet = sprintf(" %s  
	AND (commission_lib LIKE %s OR commission_sigle LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR fonction_lib LIKE %s)  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, 
	GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), 
	GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));

} else if (isset($colregID_fonction)) {
		
		if (isset($coldepID_fonction)){	
		
			if (isset($coltypID_fonction)) {
				
			 			$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						AND fonctions_fonction_id = %s 
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"), 
						GetSQLValueString($coldepID_fonction, "int"), GetSQLValueString($colTypeMembre, "int"));
						
			} else {
						
						$query_recordSet = sprintf(" %s    
						AND region_id = %s
						AND departement_id = %s
						ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"), 
						GetSQLValueString($coldepID_fonction, "int"));								
				
			}
			
		} else {
			
			$query_recordSet = sprintf(" %s    
			AND region_id = %s
			ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colregID_fonction, "int"));
			
		}
		
} else if (isset($colValue_fonction)){
	
	$query_recordSet = sprintf(" %s AND fonction_id = %s
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic, GetSQLValueString($colValue_fonction, "int"));
	/*$query_recordSet = sprintf(" %s  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic);*/	

} else {
	
	$query_recordSet = sprintf(" %s  
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic);

}



$query_limit_recordSet = sprintf("%s LIMIT %d, %d", $query_recordSet, $startRow_recordSet, $maxRows_recordSet);
$recordSet = mysql_query($query_limit_recordSet, $MyFileConnect) or die(mysql_error());
$row_recordSet = mysql_fetch_assoc($recordSet);

if (isset($_GET['totalRows_recordSet'])) {
  $totalRows_recordSet = $_GET['totalRows_recordSet'];
} else {
  $all_recordSet = mysql_query($query_recordSet);
  $totalRows_recordSet = mysql_num_rows($all_recordSet);
}
$totalPages_recordSet = ceil($totalRows_recordSet/$maxRows_recordSet)-1;

$queryString_recordSet = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recordSet") == false && 
        stristr($param, "totalRows_recordSet") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recordSet = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recordSet = sprintf("&totalRows_recordSet=%d%s", $totalRows_recordSet, $queryString_recordSet);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);

$colname_rsDepartements = "-1";
if (isset($_GET['regID'])) {
  $colname_rsDepartements = (get_magic_quotes_gpc()) ? $_GET['regID'] : addslashes($_GET['regID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsDepartements = sprintf("SELECT * FROM departements WHERE regions_region_id = %s AND display = 1 ORDER BY departement_lib ASC", $colname_rsDepartements);
$rsDepartements = mysql_query($query_rsDepartements, $MyFileConnect) or die(mysql_error());
$row_rsDepartements = mysql_fetch_assoc($rsDepartements);
$totalRows_rsDepartements = mysql_num_rows($rsDepartements);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>#TITRE</title>
<link rel="stylesheet" href="css/common.css" media="all">
<link rel="stylesheet" href="css/sub.css" media="all">
<script type="text/javascript" src="js/common/font.js"></script>
<script type="text/javascript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/alertExms.js"></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/frame.js"></script>
<script type="text/javascript" src="js/common/ajax.js"></script>
<script type="text/javascript" src="js/common/event.js"></script>
<!--<c:out value="${commonScript}" escapeXml="false"></c:out>-->
<script type="text/javaScript" language="javascript">
	
	function fn_onLoad(){
		util_hideExecutionAll(parent.document);
		util_resizeFrame("PubPaymentFrame");
		util_initCompSearchConditions('frm_pubPayment');
	}
	
	//상세화면 이동 처리 함수 :: 
	function fn_movePubPaymentDetail(bidNo, exDocType, bidModSeq, bizRegNo){
		var form = parent.document.frm_pubPayment;
		form.bidNo.value = bidNo;
		form.exDocType.value = exDocType;
		form.bidModSeq.value = bidModSeq;
		form.bizRegNo.value = bizRegNo;
		form.target = "_top";
		form.action = "<c:url value='/ed/rcv/movePubPaymentDetail.do'></c:url>";
		form.submit();
	}

	function fn_moveCommissionDetails2(userId){
		var form = parent.document.frm_pub;
		//form.userId.value = userId;
		form.bizRegNo.value = userId;
		form.target = "_top";
		form.action = "commissions/CommissionDetails.php";
		form.submit();
	}
	function fn_moveCommissionDetails(userId){
		var form = parent.document.frm_pub;
		var openParam = "width=800px,height=650px,toolbar=no,menubar=no,resizable=no,scrollbars=no,copyhistory=no,location=no";
		var url = "CommissionDetail.php?bizRegNo="+userId;
		//form.userId.value = userId;
		form.bizRegNo.value = userId;
		//form.target = "_top";
		//form.action = "CommissionDetail.php";
		//form.submit();
		window.open(url, 'CommissionDetail', openParam);
	}

</script>
</head>
<body onLoad="fn_onLoad()">
<div id="frameDiv">
<!-- <div class="content"> -->
	<div class="tableTy1">
		<form name="frm_pubPayment_list" modelAttribute="RcvSVO" method="post">
  <table class="data rowEven">
		        <caption>
		          <l:mapping programId="PubPayment" objId="DBF"></l:mapping>
		          </caption>
		        <colgroup>
		          <col style="width: 6%">
		          <col style="width: 39%">
		          <col style="width: 35%">
		          <col style="width: 20%">
		          </colgroup>
		        <thead>
		          <tr>
		            <th scope="col">N°</th>
		            <th scope="col">Noms et Prenoms</th>
		            <th scope="col">Fonctions</th>
		            <th scope="col">Comités/Comissions</th>
		            </tr>
		          </thead>
		        <tbody>
		          <?php $counter==0; do { $counter++ ?>
		          <tr>
		            <td nowrap class="tL"><?php echo $counter ?>&nbsp;</td>
		            <td nowrap class="tL"><img src="images/icons/young-user-icon.jpg" width="18" height="16">&nbsp;<?php echo strtoupper($row_recordSet['personne_nom'].' '.$row_recordSet['personne_prenom']); ?>&nbsp;</td>
		            <td nowrap class="tL"><?php 
							 echo $row_recordSet['fonction_lib'];
							 /*echo $row_recordSet['fonction_id'];
							 echo $LibFonction = MinmapDB::getInstance()->get_lib_by_id(fonctions, fonction_lib, fonction_id, $row_recordSet['fonction_id']) ;
							 $LibStr = MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_recordSet['structure_id']) ; 
							 $codeStr = MinmapDB::getInstance()->get_lib_by_id(structures, code_structure, structure_id, $row_recordSet['structure_id']) ;
							 echo isset($codeStr)?$codeStr:$LibStr; */
						  ?>
		              &nbsp; </td>
		            <td nowrap class="tL"><a href="#" onClick="fn_moveCommissionDetails('<?php echo $row_recordSet['commission_id']; ?>');"><?php echo strtoupper($row_recordSet['commission_sigle']); ?></a></td>
		            </tr>
		          <?php } while ($row_recordSet = mysql_fetch_assoc($recordSet)); ?>
		          <?php if (isset($totalRows_RecordSet) &&  $totalRows_RecordSet == 0) { // Show if recordset empty ?>
                      <tr>
                        <td colspan="5" style="width: 740px" align="center">Aucun Enregistrement trouvé </td>
                      </tr>
		          <?php } // Show if recordset empty ?>
		          </tbody>
	          </table>
		</form>
	</div>
	<br>
    <table border="0">
      <tr>
        <td><?php if ($pageNum_RecordSet1 > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecordSet1=%d%s", $currentPage, 0, $queryString_RecordSet1); ?>">Premier</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecordSet1 > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecordSet1=%d%s", $currentPage, max(0, $pageNum_RecordSet1 - 1), $queryString_RecordSet1); ?>">Précédent</a>
            <?php } // Show if not first page ?></td>
        <td><?php if ($pageNum_RecordSet1 < $totalPages_RecordSet1) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecordSet1=%d%s", $currentPage, min($totalPages_RecordSet1, $pageNum_RecordSet1 + 1), $queryString_RecordSet1); ?>">Suivant</a>
            <?php } // Show if not last page ?></td>
        <td><?php if ($pageNum_RecordSet1 < $totalPages_RecordSet1) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecordSet1=%d%s", $currentPage, $totalPages_RecordSet1, $queryString_RecordSet1); ?>">Dernier</a>
            <?php } // Show if not last page ?></td>
      </tr>
    </table>
Enregistrements <?php echo ($startRow_RecordSet1 + 1) ?> à <?php echo min($startRow_RecordSet + $maxRows_RecordSet, $totalRows_RecordSet) ?> sur <?php echo $totalRows_RecordSet ?>

</div>
</body>
</html>
<?php
mysql_free_result($rsRegion);

mysql_free_result($RsFile);

mysql_free_result($RecordSet1);
?>
