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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<link rel="stylesheet" href="css/common.css" media="all">
<script type="text/javascript" language="javascript">

/***********************************
 * 화면 onLoad
 ***********************************/
function fn_onLoad(){
	
	fn_selectListPageMenu();
	
}

/***********************************
 *  공고기관 초기화
 ***********************************/

function fn_selectListPageMenu(){
	
	//util_showExecutionImage();
	
 	//if (!validateFrm_pub(form))return;

	/*if(form.isBack.value == "Y"){
		util_initFormValue(form.childNodes , form.searchConditions.value);
	} else {
		form.currentPageNo.value = 1;
	}*/
	
	document.getElementById('menuFrame').src='menusFrame.php';
	//document.getElementById('InsertArrondissementForm').action='arrondissements.php';
	//document.getElementById('InsertArrondissementForm').target='ArrondissementFrame';
	//document.getElementById('InsertArrondissementForm').submit();

}

</script>
</head>

<body onload="javascript:fn_onLoad()">
<div id="main">
<div id="sitewrap">
<div id="wrap">
<div class="top"><img src="images/admin_top_agescom.jpg" alt="top"></div><!-- top END -->
	  <div class="gnb">
			Langue
		</div><!-- gnb END -->
  <div id="con_wrap">
<div class="menu"><!-- Menu BEGIN -->
	      <ul>
	        <li class="depth1_on">
	          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth1_1'); ?></p>
	          <ul>
	            <li class="depth2"><a href="javascript:fn_logOut();"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth1_1'); ?></a></li>
	            <li class="depth2"><a href="/ed/user/moveUserDetail.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth1_3'); ?></a></li>
              </ul>
            </li>
	        <li class="depth1_on">
	          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth6'); ?></p>
	          <ul>
	            <li class="depth2"><a href="personnesFrame.php"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth6_1'); ?></a></a>
	              <p></p>
                </li>
              </ul>
            </li>
            <li class="depth1_on">
	          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth3'); ?></p>
	          <ul>
	            <li class="depth2"><a href="/ed/rcv/movePubPaymentList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth3_1'); ?></a>
	              <p></p>
                </li>
	            <li class="depth2"><a href="/ed/rcv/movePubPaymentList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth3_2'); ?></a>
	              <p></p>
                </li>
	            <li class="depth2"><a href="/ed/rcv/movePubPaymentList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth3_3'); ?></a>
	              <p></p>
                </li>
              </ul>
            </li>
	        <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
	        <li class="depth1_on">
	          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth4'); ?></p>
	          <ul>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth4_1'); ?></a></li>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth4_2'); ?></a></li>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth4_3'); ?></a></li>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth4_4'); ?></a></li>
              </ul>
            </li>
	        <?php //} ?>
	        <?php //if (isset($userAuth) || (	$userAuth =='B')) { ?>
	        <li class="depth1_on">
	          <p class="sline"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5'); ?></p>
	          <ul>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_1'); ?></a></li>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_2'); ?></a></li>
	            <li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_3'); ?></a></li>
	            <li class="depth2"><a href="/ed/master/moveLangList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_4'); ?></a></li>
	            <li class="depth2"><a href="/ed/master/moveMappingInfoList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_5'); ?></a></li>
	            <li class="depth2"><a href="/ed/master/moveCodeTypeList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_6'); ?></a></li>
	            <li class="depth2"><a href="/ed/master/moveCodeList.do"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_leftMenu', $ObjId = 'menu_depth5_7'); ?></a></li>
              </ul>
            </li>
	        <?php //} ?>
          </ul>
        </div>
    <div id="contents" class="content">
	        <div class="con" style="margin-top: 20px">

 <form name="form" id="form" method="post">
 <div class="dataArea">
    <table class="data">
      <tr>
        <tr valign="baseline">Afficher par :</td>
        <td>
          <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
            <option value="ccse.php" <?php if (!(strcmp("", $_GET['value']))) {echo "selected=\"selected\"";} ?>>All...</option>
            <option value="ccse.php?value=0" <?php if (!(strcmp(0, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Par REGION</option>         
            <option value="ccse.php?value=142" <?php if (!(strcmp(142, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINMAP</option>
            <option value="ccse.php?value=144" <?php if (!(strcmp(144, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINFI</option>
            <option value="ccse.php?value=145" <?php if (!(strcmp(145, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINEPAT</option>
            <option value="ccse.php?value=143" <?php if (!(strcmp(143, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINDEVEL</option>
            <option value="ccse.php?value=146" <?php if (!(strcmp(146, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep TUTELLE</option>
            <option value="ccse.php?value=40" <?php if (!(strcmp(40, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MO</option>
            <option value="ccse.php?value=2" <?php if (!(strcmp(2, $_GET['value']))) {echo "selected=\"selected\"";} ?>>SECRETAIRE</option>
            <option value="ccse.php?value=1" <?php if (!(strcmp(1, $_GET['value']))) {echo "selected=\"selected\"";} ?>>PRESIDENT</option>  
          </select>
        </td>
        <td><select name="jumpMenu2" id="jumpMenu2" onchange="MM_jumpMenu('parent',this,0)">
          <option value="<?php echo $_SERVER["PHP_SELF"] ?>" <?php if (!(strcmp("#", 50))) {echo "selected=\"selected\"";} ?>>50</option>
          <option value="<?php echo $_SERVER["PHP_SELF"].'?'.$_SERVER['QUERY_STRING'].'&numbr=100' ?>" <?php if (!(strcmp($_GET['numbr'], 100))) {echo "selected=\"selected\"";} ?>>100</option>
          <option value="<?php echo $_SERVER["PHP_SELF"].'?'.$_SERVER['QUERY_STRING'].'&numbr=150' ?>" <?php if (!(strcmp($_GET['numbr'], 150))) {echo "selected=\"selected\"";} ?>>150</option>
        <option value="<?php echo $_SERVER["PHP_SELF"].'?'.$_SERVER['QUERY_STRING'].'&numbr=1000' ?>" <?php if (!(strcmp($_GET['numbr'], 1000))) {echo "selected=\"selected\"";} ?>>All</option>
        </select></td>
      </tr>
      <?php if (isset($_GET['value']) && ($_GET['value']==0)){ ?>
      <tr>
         <th scope="row">Région:</td>
        <td><select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
          <option value="ccse.php" <?php if (!(strcmp("index.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select::</option>
          <?php
		do {  
		?>
          <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
          <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
        </select></td>
        <td><?php echo $txtSearch ?>
        </td>
      </tr>
	  <?php if (isset($_GET['regID'])){ ?>      
	  <tr>
        <th scope="row">Departement:</td>
        <td><span class="style5">
          <select name="menu2"  onChange="MM_jumpMenu('parent',this,0)">
            <option value="ccse.php" <?php if (!(strcmp("ccse.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
            <?php do {  ?>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?></option>
            <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
          </select>
        </span></td>
        <td>&nbsp;</td>
      </tr>
<tr>
        <th scope="row">Type Membre :</td>
        <td>
          <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=" ?>" 
			<?php if (!(strcmp("", $_GET['typeM']))) {echo "selected=\"selected\"";} ?>>[Tous]</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=2" ?>" 
			<?php if (!(strcmp(2, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>SECRETAIRE</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=1" ?>" 
			<?php if (!(strcmp(1, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>PRESIDENT</option>          
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=142" ?>" 
			<?php if (!(strcmp(142, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINMAP</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=144" ?>" 
			<?php if (!(strcmp(144, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINFI</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=145" ?>" 
			<?php if (!(strcmp(145, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINEPAT</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=143" ?>" 
			<?php if (!(strcmp(143, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINDEVEL</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=146" ?>" 
			<?php if (!(strcmp(146, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep TUTELLE</option>
            <option value="<?php echo "index.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=40"  ?>"
			<?php if (!(strcmp(40, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MO</option>
          </select>
        </td>
        <td>&nbsp;</td>
      </tr>
      <?php } ?>
      <?php } ?>
	  <?php if (isset($_GET['value']) && ($_GET['value']<>0)){ ?>
      <tr>
        <th scope="row">Type Commissions:</td>
        <td><select name="jumpMenu3" id="jumpMenu3" onchange="MM_jumpMenu('parent',this,0)">
          <option value="#">Seclect::</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=1" ?>" <?php if (!(strcmp(1, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Commission centrale</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=7" ?>" <?php if (!(strcmp(7, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Commission Interne</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=8" ?>" <?php if (!(strcmp(8, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Commission Speciales</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=3" ?>" <?php if (!(strcmp(3, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Commission régionale</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=4" ?>" <?php if (!(strcmp(4, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Commission départementale</option>
          <option value="<?php echo "index.php?value=" . $_GET['value'] . "&typID=10" ?>" <?php if (!(strcmp(10, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>Cadre de concertation</option>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <?php //echo $_GET['typID'] ?>
      <?php if (isset($_GET['typID']) && ($_GET['typID']==3 || $_GET['typID']==4 || $_GET['typID']==7)){ ?>
      <tr>
         <th scope="row">Région:</td>
        <td><select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
          <option value="ccse.php" <?php if (!(strcmp("ccse.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select::</option>
          <?php
		do {  
		?>
          <option value="<?php echo "index.php?value=".$_GET['value']."&typID=".$coltypID_fonction."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
          <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
        </select></td>
        <td><?php echo $txtSearch ?>
        </td>
      </tr>
      <tr>
        <th scope="row">Departement:</td>
        <td><span class="style5">
          <select name="menu2"  onChange="MM_jumpMenu('parent',this,0)">
            <option value="ccse.php" <?php if (!(strcmp("ccse.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
            <?php do {  ?>
            <option value="<?php echo "index.php?value=".$_GET['value']."&typID=".$coltypID_fonction."&regID=".$_GET['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?></option>
            <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
          </select>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <?php } ?>
      <?php } ?>
      <tr>
        <th scope="row">Rechercher:</td>
        <td>
          <input name="txtSearch" type="text" id="txtSearch" size="30" maxlength="150" value="<?php echo (isset($_POST['txtSearch']))? $_POST['txtSearch'] : ""; ?>"/>
        </td>
        <td><input type="submit" name="btnSearch" id="btnSearch" value="Envoyer" />
          <input type="button" name="btnSearch2" id="btnSearch2" value="Reinitialiser" onclick="window.location.href='index.php'" /></td>
      </tr>
      <tr>
        <th scope="row">&nbsp;</td>
        <td><input name="txtValue" type="hidden" id="txtValue" value="<?php echo (isset($_GET['value']))? $_GET['value'] : ""; ?>"/><?php //echo (isset($_GET['value']))? $_GET['value'] : ""; ?></td>
        <td>&nbsp;</td>
      </tr>
    </table>
 </div>
    <?php //echo $query_limit_recordSet; //$query_recordSet; ?>
    </form>
 <p>&nbsp;</p>
    <?php if ($totalRows_recordSet > 0) { // Show if recordset not empty ?>
    <div class="tableTy1">
		<form name="frm_pubPayment_list" modelAttribute="RcvSVO" method="post">
        <table class="data rowEven">
    			<caption><l:mapping programId="PubPayment" objId="DBF"></l:mapping></caption>
				<colgroup>
					<col style="width: 15%">
					<col style="width: 30%">
					<col style="width: 20%">
					<col style="width: 35%">
				</colgroup>
				<thead>
					<tr>
                        <th scope="col">N°</th>
                        <th scope="col">Commission</th>
                        <th scope="col">Noms et Prenoms</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Structure</th>
					</tr>
				</thead>
      <?php $counter=0 ?>
      <?php do { ?>
      <?php $counter++ ?>
        <tr bgcolor="<?php echo alter_color($counter, "#eee", "#FFF"); ?>">
          <td align="center" nowrap><?php echo $counter ?>&nbsp; </td>
          
          <td nowrap>
          <?php (isset($_GET['comID']))?$urlvalue=$_GET['comID']:$urlvalue=$row_recordSet['commission_id']; ?>
          <!--<a href="#" onclick="<?php //popup('detail_membres_pub.php?comID='.$urlvalue, "800", "450"); ?>">-->
          <a href="#" onclick="<?php popup('detail_membres.php?comID='.$urlvalue, "800", "450"); ?>">
          <?php 
		  if (isset($_POST['txtSearch']) && $_POST['txtSearch'] != "" ){
		  echo str_ireplace($_POST['txtSearch'],'<span style="background-color:yellow">'. strtoupper($_POST['txtSearch']) .'</span>',strtoupper($row_recordSet['commission_sigle']));
		  } else {
		  echo strtoupper($row_recordSet['commission_sigle']);
		  } ?>
          </a>&nbsp; 
			<?php 
			$result = MinmapDB::getInstance()->get_lib_by_id(fichiers, url, commissions_commission_id, $row_recordSet['commission_id']);
            if (isset($result)){
            do {
			?>
            <a href="#" onclick="<?php popup(htmlentities($result), "710", "650"); ?>">
            <img src="images/img/b_pdfdoc.png" width="16" height="16" />
            </a>
            <?php
			} while ($row = mysql_fetch_assoc($result));
			}
			//endwhile;
            mysqli_free_result($result);
            ?>
          <!--<a href="#" onclick="<?php //popup("upd_commission.php?recordID=".$row_recordSet['commission_id'], "710", "450"); ?>"><img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/></a>-->  
          </td>
          
          
          <td nowrap><?php 
		  if (isset($_POST['txtSearch']) && $_POST['txtSearch'] != "" ){
		  echo str_ireplace($_POST['txtSearch'],'<span style="background-color:yellow">'. strtoupper($_POST['txtSearch']) .'</span>',strtoupper($row_recordSet['personne_nom'].' '.$row_recordSet['personne_prenom']));
		  } else {
		  echo strtoupper($row_recordSet['personne_nom'].' '.$row_recordSet['personne_prenom']);
		  } ?>
            <!--<a href="#" onclick="<?php /*?>popup('upd_personne_rmap.php?comID='.$urlvalue.'&perID='.$row_recordSet['personne_id'], "800", "450");<?php */ ?>">
            <img src="images/img/b_usredit.png" alt="" width="16" height="16" align="absmiddle"/></a>-->&nbsp; </td>
          <td><?php echo $row_recordSet['personne_telephone']; ?>&nbsp; </td>
          <td>
	     <?php 
		 $LibStr = MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_recordSet['structure_id']) ; 
		 $codeStr = MinmapDB::getInstance()->get_lib_by_id(structures, code_structure, structure_id, $row_recordSet['structure_id']) ;
		 echo isset($codeStr)?$codeStr:$LibStr; 
		 ?></a>
         <a href="#" onclick="<?php popup('upd_structures.php?strID='.$row_recordSet['structure_id'], "800", "450"); ?>">
         <?php /*?><?php if (isset($LibStr) || isset($codeStr)){ ?>
         <img src="images/img/b_edit.png" alt="" width="16" height="16" align="absmiddle"/>
         <?php } ?><?php */?>
         </a></td>
          </tr>
        <?php } while ($row_recordSet = mysql_fetch_assoc($recordSet)); ?>
    </table>
    	</form>
    <?php } // Show if recordset not empty ?>
	        </div>
		</div>
	</div>


</div>
</div>
</div>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>