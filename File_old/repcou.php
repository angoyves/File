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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recordSet = 50;
if (isset($_GET['numbr'])) {
  $maxRows_recordSet = $_GET['numbr'];
}

$pageNum_recordSet = 0;
if (isset($_GET['pageNum_recordSet'])) {
  $pageNum_recordSet = $_GET['pageNum_recordSet'];
}
$startRow_recordSet = $pageNum_recordSet * $maxRows_recordSet;

if (isset($_GET['value'])) {
  $colValue_fonction = $_GET['value'];
}

if (isset($_GET['typM'])) {
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
$txtSearch = isset($_POST['txtSearch'])?$_POST['txtSearch']:" ";

mysql_select_db($database_MyFileConnect, $MyFileConnect);

/*
if (isset($colValue_fonction) && isset($coltypID_fonction) && isset($_POST['txtSearch'])){
$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions  
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND fonctions_fonction_id = %s 
AND type_commission_id = %s
AND (commission_lib LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR fonction_lib LIKE %s)
AND commissions.display_agescom = 1 
AND membres.display_agescom = 1 
ORDER BY personne_nom, date_constation ASC", GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));	
} else if (isset($colValue_fonction) && isset($coltypID_fonction)){
	if ((isset($_GET['regId'])) && (isset($_GET['depId']))){
	$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
	FROM membres, commissions, personnes, fonctions  
	WHERE membres.commissions_commission_id = commissions.commission_id  
	AND membres.personnes_personne_id = personnes.personne_id  
	AND membres.fonctions_fonction_id = fonctions.fonction_id  
	AND fonctions_fonction_id = %s 
	AND type_commission_id = %s
	AND region_id = %s
	AND departement_id = %s
	AND commissions.display_agescom = 1 
	AND membres.display_agescom = 1 
	ORDER BY personne_nom, date_constation ASC", GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int"), GetSQLValueString($coldepID_fonction, "int"));
	} else if (isset($_GET['regId'])) {
	$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
	FROM membres, commissions, personnes, fonctions  
	WHERE membres.commissions_commission_id = commissions.commission_id  
	AND membres.personnes_personne_id = personnes.personne_id  
	AND membres.fonctions_fonction_id = fonctions.fonction_id  
	AND fonctions_fonction_id = %s 
	AND type_commission_id = %s
	AND region_id = %s
	AND commissions.display_agescom = 1 
	AND membres.display_agescom = 1 
	ORDER BY date_constation, personne_nom ASC", GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"), GetSQLValueString($colregID_fonction, "int"));	
	} else {
	$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
	FROM membres, commissions, personnes, fonctions  
	WHERE membres.commissions_commission_id = commissions.commission_id  
	AND membres.personnes_personne_id = personnes.personne_id  
	AND membres.fonctions_fonction_id = fonctions.fonction_id  
	AND fonctions_fonction_id = %s 
	AND type_commission_id = %s
	AND commissions.display_agescom = 1 
	AND membres.display_agescom = 1 
	ORDER BY date_constation, personne_nom ASC", GetSQLValueString($colValue_fonction, "int"), GetSQLValueString($coltypID_fonction, "int"));		
	}
} else if (isset($_POST['txtSearch']) && isset($colValue_fonction)){
$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions  
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND fonctions_fonction_id = %s 
AND (commission_lib LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR fonction_lib LIKE %s)
AND commissions.display_agescom = 1 
AND membres.display_agescom = 1 
ORDER BY personne_nom, date_constation ASC", GetSQLValueString($colValue_fonction, "int"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));
} else if (isset($colValue_fonction)){
$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions  
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND fonctions_fonction_id = %s 
AND commissions.display_agescom = 1 
AND membres.display_agescom = 1 
ORDER BY personne_nom, date_constation ASC", GetSQLValueString($colValue_fonction, "int"));	
} else if (isset($_POST['txtSearch'])){
$query_recordSet = sprintf("SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions  
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND (commission_lib LIKE %s OR personne_nom LIKE %s OR personne_prenom LIKE %s OR fonction_lib LIKE %s)
AND commissions.display_agescom = 1 
AND membres.display_agescom = 1 
ORDER BY personne_nom, date_constation ASC", GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"), GetSQLValueString("%" . $txtSearch . "%", "text"));*/	


$query_recordSetBasic = "SELECT membres.*, commission_id, commission_lib, commission_sigle, personne_id, personne_nom, personne_prenom, fonction_lib, personnes.structure_id, personne_telephone  
FROM membres, commissions, personnes, fonctions
WHERE membres.commissions_commission_id = commissions.commission_id  
AND membres.personnes_personne_id = personnes.personne_id  
AND membres.fonctions_fonction_id = fonctions.fonction_id  
AND add_commission_agescom = 1 
AND membres.display_agescom = 1
AND type_commission_id = 10";

		if (isset($colregID_fonction) && ($colValue_fonction==0)){
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
	} /*else {
	$query_recordSet = sprintf(" %s   
	ORDER BY personne_nom, date_constation ASC", $query_recordSetBasic);
	}*/
	
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

/*$query_recordSet = "SELECT commission_id, commission_lib, commission_sigle, lib_nature, type_commission_lib, localite_lib, membre_insert, commissions.region_id 
FROM commissions, natures, type_commissions, localites 
WHERE commissions.nature_id = natures.nature_id  
AND commissions.type_commission_id = type_commissions.type_commission_id  
AND commissions.localite_id = localites.localite_id 
AND display_agescom = 1 
ORDER BY localites.localite_lib, commissions.type_commission_id, commissions.commission_lib ASC";*/

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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCou', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="css/common.css" media="all">
<script type="text/javaScript" src="js/common/font.js"></script>
<script type="text/javaScript" src="js/common/alert.js"></script>
<script type="text/javascript" src="js/common/string.js"></script>
<script type="text/javascript" src="js/common/prototype.js"></script>
<script type="text/javascript" src="js/common/validation.js"></script>
<script type="text/javascript" src="/js/common/event.js"></script>
<script type="text/javascript" src="js/common/calendar.js"></script>
<script type="text/javascript" src="js/common/date.js"></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/popup.js"></script>
<script type="text/javascript"> 

     var bCancel = false; 

    function validateFrm_pub(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateMask(form) && validateMaxLength(form); 
   } 

    function mask () { 
     this.aa = new Array("bidNoStr", "Intitulé d'Avis d'Appel d'Offres is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='11'; this.mask=/^[0-9]*$/;  return this[varName];"));
     this.ab = new Array("bidNm", "N° de l'Avis d'Appel d'Offre is invalid.[nl][O]valid characters.[nl][/O][X]invalid characters.[nl][/X]", new Function ("varName", "this.maxlength='200'; this.mask=/^[^<>]*$/;  return this[varName];"));
    } 

    function maxlength () { 
     this.aa = new Array("bidNoStr", "Intitulé d'Avis d'Appel d'Offres can not be greater than 11 characters(korean 3characters).", new Function ("varName", "this.maxlength='11'; this.mask=/^[0-9]*$/;  return this[varName];"));
     this.ab = new Array("bidNm", "N° de l'Avis d'Appel d'Offre can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200'; this.mask=/^[^<>]*$/;  return this[varName];"));
    } 


</script>


<script type="text/javascript" language="javascript">
/***********************************
 * 화면 onLoad
 ***********************************/
function fn_onLoad(){
	
	fn_selectListPageEpPub();
	
}

/***********************************
 *  공고기관 초기화
 ***********************************/
function fn_reset(){
	
	document.getElementById("instCd").value = "";
	document.getElementById("instNm").value = "";
	
}

/***********************************
 *  공고기관 조회 팝업
 ***********************************/
function fn_searchInst(){
	
	var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	var url    = "http://localhost:8080/cam-exms/jsp/ep/pub/EpPubBidInstListPopup.php";
   			  
	var ReturnValue = window.open(url, "inst", openParam);
	ReturnValue.focus();
}

/***********************************
 *  입찰공고 목록 조회
 ***********************************/
function fn_selectListPageEpPub(){
	// 처리중 이미지 생성
	var form = document.frm_pub;
	
	util_showExecutionImage();
	
 	if (!validateFrm_pub(form))return;
    
 // 상세, 수정에서 온 경우
	/*if(form.isBack.value == "Y"){
		util_initFormValue(form.childNodes , form.searchConditions.value);
	} else {
		form.currentPageNo.value = 1;
	}*/
	
 	//util_trimValue();
	
	
	/*form.bidNo.value = form.bidNoStr.value;
    
	form.action = "PersonnelListFrameTest.php";
	//form.target = "PubPaymentFrame";frm_pub
	form.target = "PubPaymentFrame";
	form.submit();*/
	
	//document.getElementById('PubPaymentFrame').src='sampleTestFrame.php';
	document.getElementById('frm_pub').action='repcouFrame.php';
	document.getElementById('frm_pub').target='PubPaymentFrame';
	document.getElementById('frm_pub').submit();
	
	//form.bidNo.value = form.bidNoStr.value;
	//form.action = "sampleTestFrame.php";
	//form.target = "PubPaymentFrame";
	//form.submit();
		
	/*if(!validateFrm_pubPayment(form)){
		return;
	} else {
		form.submit();
	}*/

}

/***********************************
 * 테스트용 모의공고
 ***********************************/
function fn_selectTestBid(){

	var form = document.frm_pub;
	
	form.bidNo.value = "20150100003";
	form.bidModSeq.value = "00";
	
	form.target = "main";
	form.action = "/ep/pub/moveEpPubDetail.do";
	form.submit();
}


function fn_open(){
	 
	var openParam = "width=845px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	window.open('', 'Popup', openParam);

	var form = document.frm_pub;
	
	form.target = "Popup";
   	form.action = "/report1.do";
   	form.submit();
}

function fn_movePubPaymentInsert(){
	var form = document.frm_pub;
	form.action = "memberReg.php";
	form.target = "_top";
	form.submit();
}
	function fn_moveInsertCpm(){
		var form = document.frm_pub;
		form.target = "_top";
		form.action = "commissions/CommissionReg.php"
		form.submit();
	}
function fn_InsertCommissionPopop(){
	
	var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	var url    = "user/CommissionRegPopup.php";
	var ReturnValue = window.open(url, "inst", openParam);
	ReturnValue.focus();
}
</script>
<style type="text/css">
<!--
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
-->
</style>
</head>
<body onLoad="fn_onLoad()">
<div id="main">
<div id="sitewrap">
<div id="wrap">
<div class="top"><img src="images/admin_top_agescom.jpg" alt="top"></div>
  <div id="con_wrap">
    <div class="menu">
      <!-- Menu BEGIN -->
      <ul>
        <p>    
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
        <?php if ($userAuth=='A') { ?>
        </p>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1'); ?></p>
          <ul>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth1_1'); ?></a></a>
              <p></p>
            </li>
          </ul>
        </li>
        <?php } ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2'); ?></p>
          <ul>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_1'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_2'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth2_3'); ?></a>
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
            <li class="depth2"><a href="repcim.php?value=142"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_1'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php?value=144"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_2'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php?value=145"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_3'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_4'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth3_5'); ?></a>
              <p></p>
            </li>
            <li class="depth2"><a href="repcim.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth3_6'); ?></a>
              <p></p>
            </li>
          </ul>
        </li>
        <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4'); ?></p>
          <ul>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_1'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_2'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_3'); ?></a></li>
            <li class="depth2"><a href="repcom.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenu', $ObjId = 'menu_depth4_4'); ?></a></li>
          </ul>
        </li>
        <?php //} ?>
        <?php if (isset($userAuth) || (	$userAuth =='B')) { ?>
        <li class="depth1_on">
          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5'); ?></p>
          <ul>
            <li class="depth2"><a href="repcou.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_1'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_2'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_3'); ?></a></li>
            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'agescom_leftMenuom', $ObjId = 'menu_depth5_4'); ?></a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if (isset($userAuth) || (	$userAuth =='B')) { ?>
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
        <?php } ?>
      </ul>
    </div>
    <div id="contents" class="content">
<div class="con" style="margin-top: 20px">
		        <div class="fR" style="display: none;">
					<span class="btnTy21 fR ml15"><input type="button" class="btn" value="Test" onClick="fn_selectTestBid();"></span>
				</div>
                <h1 class="h1_title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCou', $ObjId = 'title'); ?></h1>
				<form id="frm_pub" name="frm_pub" method="post">
				  <input type="hidden" id="searchConditions" name="searchConditions" value="">
					<input type="hidden" id="isBack" name="isBack" value="">
					<input type="hidden" id="currentPageNo" name="currentPageNo" value="1">
					<input type="hidden" id="publicDtFrom" name="publicDtFrom" value="20190608">
					<input type="hidden" id="publicDtTo" name="publicDtTo" value="20200608">
					<input type="hidden" id="bdOpenDtFrom" name="bdOpenDtFrom" value="20190608">
					<input type="hidden" id="bdOpenDtTo" name="bdOpenDtTo" value="20210608">
					<input type="hidden" id="bidModSeq" name="bidModSeq" value="">
					<input type="hidden" id="bidNo" name="bidNo" value="">
                    <input type="hidden" id="IdPerson" name="IdPerson" value="<?php echo $_POST['']; ?>">
                    <input name="txtValue" type="hidden" id="txtValue" value="<?php echo (isset($_GET['value']))? $_GET['value'] : ""; ?>"/>
					
				<div class="tableTy2">
                  <div class="dataArea">	
	                	<table class="data">
							<colgroup>
								<col style="width:25%">
	                            <col style="width:75%">
							</colgroup>
	                        <tbody>
	                            <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchName'); ?></th>
	                                <td>
	                                	<input type="hidden" class="text" id="idPerson" name="idPerson" style="width:20%" readonly="readonly">
                                        <input type="text" class="text" id="instCd" name="instCd" style="width:25%" readonly="readonly">
	                            		<input type="text" class="text" id="instNm" name="instNm" style="width:45%" readonly="readonly">
	                            		<span class="btnTy3"><input type="button" class="btn" value="Rechercher" onClick="fn_searchInst();"></span>
	                            		<span class="btnTy3"><input type="button" class="btn" value="Réinitialiser"onclick="fn_reset();"></span></td>
	                            </tr>
	                            <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchOther'); ?></th><!-- 입찰공고명 -->
	                                <td>
	                                	<input type="text" class="text" id="txtSearch" name="txtSearch" style="width:97%" maxlength="250"
                                			onblur="javascript:util_checkValidation(this, '^[^<>]*$', 250);">
                           			</td>
	                            </tr>
	                        </tbody>
	                    </table>
					</div>
				</div>
				
				<!-- 검색버튼 영역 시작 -->
				<div class="fR mt15 mb20">
					<select id="recordCountPerPage" name="recordCountPerPage" class="article_selectbox">
						<option value="10" selected="selected">
							10 résultats
						</option>
						<option value="20">
							20 résultats
						</option>
						<option value="30">
							30 résultats
						</option>
						<option value="50">
							50 résultats
						</option>
					</select>
					<span class="btnTy3">
						<input class="btn" type="button" onClick="javascript:fn_selectListPageEpPub()"
                       value="Rechercher">
                    </span>
                 </div>
              </form>
              <iframe name="PubPaymentFrame" id="PubPaymentFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
              <div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="Enregistrer un Nouveau Membre" onClick="fn_moveInsertCpm();"></span>
				</div>
	        </div>
		</div>
	</div>


</div>
</div>
</div>
</body>
</html>