<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require('../includes/db.php'); ?>
<?php
	  require('../includes2/db.php');
	  require('../includes2/fonction_db.php');
	  require('../includes2/DW_Fonctions.php');
	  require('../includes2/controler.php');
	  require("../inc/biblio.inc.php");
	  //require("include/logfile.php");
	  require("../src/inc/mysql_biblio.inc.php");
	  //require('../AGIS/includes/MyFonction.php');


?>
<?php

$typecommissionIsEmpty = false;
$natureIsEmpty = false;
$regionIsEmpty = false;
$departementIsEmpty = false;
$structureIsEmpty = false;
$localiteIsEmpty = false;

if (isset($_POST['type_commission_id']) && $_POST['type_commission_id'] == ""){
$typecommissionIsEmpty = true; }
if (isset($_POST['nature_id']) && $_POST['nature_id'] == ""){
$natureIsEmpty = true; }
if (isset($_POST['region_id']) && $_POST['region_id'] == ""){
$regionIsEmpty = true; }
if (isset($_POST['departement_id']) && $_POST['departement_id'] == ""){
$departementIsEmpty = true; }
if (isset($_POST['localite_id']) && $_POST['localite_id'] == ""){
$localiteIsEmpty = true; }
if (isset($_POST['structure_id']) && $_POST['structure_id'] == ""){
$structureIsEmpty = true; }

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  //$localite_lib = MinmapDB::getInstance()->get_localite_lib_by_localite_id($_POST['localite_id']);
  //$type_commission_lib = MinmapDB::getInstance()->get_type_commission_lib_by_commission_id($_POST['type_commission_id']);
  //$nature_lib = MinmapDB::getInstance()->get_nature_lib_by_nature_id($_POST['nature_id']);
  
  $comissionLib = MinmapDB::getInstance()->get_lib_by_id(type_commissions, type_commission_lib, type_commission_id, $_POST['type_commission_id']).' de '
  . MinmapDB::getInstance()->get_lib_by_id(natures, lib_nature, nature_id, $_POST['nature_id']).' place aupres de la (du) '
  . MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $_POST['structure_id']);
  MinmapDB::getInstance()->get_lib_by_id(structures, structure_lib, structure_id, $row_rsPersonnes['structure_id']);
  $insertSQL = sprintf("INSERT INTO commissions (commission_id, localite_id, type_commission_id, nature_id, structure_id, region_id, user_id, commission_lib, commission_parent, montant_cumul, nombre_offre, membre_insert, dateCreation, dateUpdate, display_agescom) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['commission_id'], "int"),
                       GetSQLValueString($_POST['localite_id'], "int"),
                       GetSQLValueString($_POST['type_commission_id'], "int"),
                       GetSQLValueString($_POST['nature_id'], "int"),
                       GetSQLValueString($_POST['structure_id'], "int"),
                       GetSQLValueString($_POST['region_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       //GetSQLValueString($_POST['commission_lib'], "text"),$comissionLib
					   GetSQLValueString($comissionLib, "text"),
                       GetSQLValueString($_POST['commission_parent'], "int"),
                       GetSQLValueString($_POST['montant_cumul'], "text"),
                       GetSQLValueString($_POST['nombre_offre'], "text"),	
                       GetSQLValueString(0, "text"),
                       GetSQLValueString($_POST['dateCreation'], "date"),
                       GetSQLValueString($_POST['dateUpdate'], "date"),
                       GetSQLValueString($_POST['display'], "text"));

  mysql_select_db($database_MyFileConnect, $MyFileConnect);
  $Result1 = mysql_query($insertSQL, $MyFileConnect) or die(mysql_error());

 /* $insertGoTo = "liste_commissions.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));*/
  
/*echo "<script type='".text/javascript."'>
			if (confirm('Créer une nouvelle Commission???')) 
			{".
				  $insertGoTo = "CommissionRegPopup.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			else
			{".
				  $insertGoTo = "liste_commissions.php?valid=ok";
				  if (isset($_SERVER['QUERY_STRING'])) {
					$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				   $insertGoTo .= $_SERVER['QUERY_STRING'];
				  }
				  header(sprintf("Location: %s", $insertGoTo)) ."
			}
		</script>";
}*/
  
      echo "<script type='".text/javascript."'>
  		window.opener.location.reload(); 
		self.close(); 
		</script>";
}

$colname_rsLocalites = "-1";
if (isset($_GET['depID'])) {
  $colname_rsLocalites = (get_magic_quotes_gpc()) ? $_GET['depID'] : addslashes($_GET['depID']);
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsLocalites = sprintf("SELECT localite_id, localite_lib FROM localites WHERE departement_id = %s AND display = 1 ORDER BY localite_lib ASC", $colname_rsLocalites);
$rsLocalites = mysql_query($query_rsLocalites, $MyFileConnect) or die(mysql_error());
$row_rsLocalites = mysql_fetch_assoc($rsLocalites);
$totalRows_rsLocalites = mysql_num_rows($rsLocalites);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsTypeCommission = "SELECT type_commission_id, type_commission_lib FROM type_commissions WHERE display = '1' ORDER BY type_commission_lib ASC";
$rsTypeCommission = mysql_query($query_rsTypeCommission, $MyFileConnect) or die(mysql_error());
$row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
$totalRows_rsTypeCommission = mysql_num_rows($rsTypeCommission);

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsNatureCommission = "SELECT nature_id, lib_nature FROM natures WHERE display = '1' ORDER BY lib_nature ASC";
$rsNatureCommission = mysql_query($query_rsNatureCommission, $MyFileConnect) or die(mysql_error());
$row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
$totalRows_rsNatureCommission = mysql_num_rows($rsNatureCommission);

/*mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = "SELECT structure_id, structure_lib FROM structures WHERE type_structure_id =4 AND display = '1' ORDER BY structure_lib ASC";
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);*/


$colname_rsStructures = isset($_REQUEST["locID"])?$_REQUEST["locID"]:"79";

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsStructures = sprintf("SELECT structure_id, structure_lib, code_structure FROM structures WHERE localite_id = %s AND display_agescom = 1 ORDER BY code_structure ASC", $colname_rsStructures);
$rsStructures = mysql_query($query_rsStructures, $MyFileConnect) or die(mysql_error());
$row_rsStructures = mysql_fetch_assoc($rsStructures);
$totalRows_rsStructures = mysql_num_rows($rsStructures);

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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<style type="text/css"> 
	html {overflow:hidden;}  
.style1 {font-family: "Arial Narrow"}
.style10 {font-size: 16}
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
.style9 {font-family: "Arial Narrow"; font-size: 16; }
</style>  
<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/alertExms.js"></script>
<script type="text/javascript" src="../js/common/validation.js" ></script>
<script type="text/javascript" src="../js/common/frame.js" ></script>
<script type="text/javascript" src="../js/common/ajax.js" ></script>
<script type="text/javascript" src="../js/common/string.js" ></script>
<script type="text/javascript" src="../js/common/event.js" ></script>
<script type="text/javaScript" language="javascript">
//작성 내용 저장 :: Save Information
	function fn_insertUser(){
		
		var form = document.frm_user_insert;

		util_trimRequiredValue(form);
		
		if(!validateFrm_user_insert(form)){
			return;
		} else {
			//패스워드 일치여부 확인
			if(!fn_chkPwDup()){
				return;
			} 
	
			//아이디 중복여부 체크
			if(form.idRegisted.value == 'Y'){
				util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'un_available_id'); ?>");
				form.userId.focus();
				return;
			}
	
			//아이디 중복체크 후 값을 변경한 경우인지 체크
			if(form.idChanged.value == 'N'){
				util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_insert_msg'); ?>", 'fn_submitInsertUser()');
			}else{
				util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'check_id_again'); ?>");
			} 
			util_confirmAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_insert_msg'); ?>", 'fn_submitInsertUser()');
		}
	 }
	
	//Form Submit
	function fn_submitInsertUser(){
		var form = document.frm_user_insert;
		form.action = "<c:url value='/ed/user/insertUser.do'></c:url>";
		form.target = "ResultFrame";
		form.submit();
	}
	
	//특수문자체크
	function isValid(str){
		// return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
	}
	
	function fn_chkIdDuplicate(){
		var form = document.frm_user_insert;
		form.idChanged.value="Y";
		if(form.userId.value == ''){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'type_id'); ?>");
			form.userId.focus();
			return;
		}else if (!isValid(form.userId.value)){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'invalid_char'); ?>");
			form.userId.value="";
			return;
		}
	
		util_trimRequiredValue(form);
	
		var url = "/ed/user/checkUserDuplicate.do" + "?userId=" + form.userId.value;
	    AutoComplete.ContentLoader(url, fn_checkDupResult);
	}
	
	//중복 처리 결과확인 :: check duplicate result
	function fn_checkDupResult(){
		if(AutoComplete.getState()){
			var form = document.frm_user_insert;
			var result = xmlHttp.responseText;
			if(result == "success"){
				form.checkResult.value = "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'availableID'); ?>";
				form.idRegisted.value="N";
				form.idChanged.value="N";
			}else{
				form.checkResult.value = "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'notAvailableID'); ?>"; 
				form.idRegisted.value="Y";
				form.idChanged.value="N";
			}
		}
	}
	
	
	function fn_chkPwDup(){
		var form = document.frm_user_insert;
		var pwVar = form.userPw.value;
		var confVar = form.confirmPw.value;
	
		if(pwVar != confVar){
			util_messageAlertOnPopup("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'chk_pw_dup'); ?>");
			form.userPw.value='';
			form.confirmPw.value='';
			form.userPw.focus();
			return false;
		}
		return true;
	}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>

<body>
<div id="popup_main">
<div id="popWrap">
	<!-- Layout : header Area -->
	<div id="pop_header" class="popHeader">
		<h1 class="title">Enregistrement Commission</h1>
		<button class="Close" title="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?>"	onclick="window.close();">
			<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?>
		</button>
	</div>
	<!-- //Layout : header Area -->

	<!-- Layout : container Area -->
	<div id="popup_contents" class="popContainer"> 
		<div class="tableTy2">
			<div class="dataArea">
				<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
				<form:form name="frm_user_insert" modelAttribute="UserSVO" method="post" id="frm_user_insert">
					<input type="hidden" name="searchConditions" value="${UserSVO.searchConditions}">
					<input type="hidden" name="currentPageNo" value="${UserSVO.currentPageNo}">
					<input type="hidden" name="isBack" value="${UserSVO.isBack}">
					<input type="hidden" name="idChanged">
					<input type="hidden" name="idRegisted">
					
					<!-- 입력폼 //-->
<table class="data">
						<colgroup>
							<col style="width: 25%">
							<col style="width: *">
						</colgroup>
						<tbody>
                            
                            
                            
                            
                            
<tr valign="baseline">
					    <th scope="row">Type Commission:</th>
					    <td class="style1"><select name="type_commission" class="style1" onchange="MM_jumpMenu('parent',this,0)">
					      <option value=""  <?php if (!(strcmp("", 7))) {echo "selected=\"selected\"";} ?>>Select...</option>
					      <?php
do {  
?>
					      <option value="<?php echo "CommissionRegPopup.php?typID=".$row_rsTypeCommission['type_commission_id']?>"<?php if (!(strcmp($row_rsTypeCommission['type_commission_id'], $_GET['typID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsTypeCommission['type_commission_lib']) ?></option>
					      <?php
} while ($row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission));
  $rows = mysql_num_rows($rsTypeCommission);
  if($rows > 0) {
      mysql_data_seek($rsTypeCommission, 0);
	  $row_rsTypeCommission = mysql_fetch_assoc($rsTypeCommission);
  }
?>
					      </select>
					      <span class="style5">
					        <?php           
			$showGoTo = "add_types.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					        <a href="#" onclick="<?php popup($showGoTo, "710", "250"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
					          <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($typecommissionIsEmpty) { ?>
				          </a></span>
					      <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
		        <?php } ?></td>
				      </tr>
					  <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3 || $_GET['typID'] == 4 || $_GET['typID'] == 5)){ ?>
					  <tr valign="baseline">
					   <th scope="row">Region:</th>
					    <td valign="middle" class="style5"><select name="menu1" class="style1" onchange="MM_jumpMenu('parent',this,0)">
					      <option value="CommissionRegPopup.php" <?php if (!(strcmp("CommissionRegPopup.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
					      <?php
		do {  
		?>
					      <option value="<?php echo "CommissionRegPopup.php?typID=".$_GET['typID']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
					      <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
					      </select>
					      <?php           
			$showGoTo = "add_regions.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					      <a href="#" onclick="<?php popup($showGoTo, "710", "150"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" /></a>
					      <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($regionIsEmpty) { ?>
					      <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
				        <?php } ?></td>
				      </tr>
					  <tr valign="baseline">
					    <th scope="row">Departement:</th>
					    <td valign="middle" class="style5"><select name="menu2" class="style1" onchange="MM_jumpMenu('parent',this,0)">
					      <option value="CommissionRegPopup.php" <?php if (!(strcmp("CommissionRegPopup.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
					      <?php do {  ?>
					      <option value="<?php echo "CommissionRegPopup.php?typID=".$_GET['typID']."&regID=".$_REQUEST['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?> </option>
					      <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
					      </select>
					      <?php           
			$showGoTo = "add_localites.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					      <a href="#" onclick="<?php popup($showGoTo, "710", "350"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
					        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($departementIsEmpty) { ?>
				          </a>
					      <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le departement, SVP!</div>
				        <?php } ?></td>
				      </tr>
					  <tr valign="baseline">
					    <th scope="row">Localite:</th>
					    <td valign="middle" class="style5"><select name="localite_id" class="style1" onchange="MM_jumpMenu('parent',this,0)">
					      <option value="CommissionRegPopup.php" <?php if (!(strcmp("CommissionRegPopup.php", $_GET['locID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
					      <?php do {  ?>
					      <option value="<?php echo "CommissionRegPopup.php?typID=".$_GET['typID']."&regID=".$_REQUEST["regID"]."&depID=".$_REQUEST["depID"]."&locID=".$row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], $_GET['locID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']) ?></option>
					      <?php
		} while ($row_rsLocalites = mysql_fetch_assoc($rsLocalites));
		  $rows = mysql_num_rows($rsLocalites);
		  if($rows > 0) {
			  mysql_data_seek($rsLocalites, 0);
			  $row_rsLocalites = mysql_fetch_assoc($rsLocalites);
		}
		?>
					      </select>
					      <?php           
			$showGoTo = "add_localites.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					      <a href="#" onclick="<?php popup($showGoTo, "710", "750"); ?>"><img src="images/img/b_snewtbl.png" width="16" height="16" />
					        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($localiteIsEmpty) { ?>
				          </a>
				        <div class="control"><img src="images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la localite, SVP!</div></td>
				      </tr>
					  <?php } ?>
					  <?php } ?>
					  <tr valign="baseline">
					    <th scope="row">Nature Commission:</th>
					    <td class="style1"><select name="nature_id" class="style1">
					      <option value=""  <?php if (!(strcmp("", 9))) {echo "selected=\"selected\"";} ?>>Select...</option>
					      <?php
do {  
?>
					      <option value="<?php echo $row_rsNatureCommission['nature_id']?>"<?php if (!(strcmp($row_rsNatureCommission['nature_id'], 9))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsNatureCommission['lib_nature']) ?></option>
					      <?php
} while ($row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission));
  $rows = mysql_num_rows($rsNatureCommission);
  if($rows > 0) {
      mysql_data_seek($rsNatureCommission, 0);
	  $row_rsNatureCommission = mysql_fetch_assoc($rsNatureCommission);
  }
?>
					      </select>
					      <span class="style5">
					        <?php           

			$showGoTo = "add_natures.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					        <a href="#" onclick="<?php popup($showGoTo, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" />
					          <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($natureIsEmpty) { ?>
				          </a></span>
					      <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la nature , SVP!</div>
				        <?php } ?></td>
				      </tr>
                      <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3 || $_GET['typID'] == 4 || $_GET['typID'] == 5)){ ?>
					  <tr valign="baseline">
                      
					    <th scope="row">Structure de rattachement:</th>
					    <td class="style1"><select name="structure_id" class="style1">
					      <option value=""  <?php if (!(strcmp("", 894))) {echo "selected=\"selected\"";} ?>>Select...</option>
					      <?php
do {  
?>
					      <option value="<?php echo $row_rsStructures['structure_id']?>"<?php if (!(strcmp($row_rsStructures['structure_id'], 894))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsStructures['code_structure']) ?></option>
					      <?php
} while ($row_rsStructures = mysql_fetch_assoc($rsStructures));
  $rows = mysql_num_rows($rsStructures);
  if($rows > 0) {
      mysql_data_seek($rsStructures, 0);
	  $row_rsStructures = mysql_fetch_assoc($rsStructures);
  }
?>
					      </select>
					      <span class="style5">
					        <?php           
			//$showGoTo = "add_structures.php";
			$reg_id = isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
			$loc_id = isset($_REQUEST['locID'])?$_REQUEST['locID']:"79";
			$showGoTo = "showstructure.php?regID=". isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
			if (isset($_SERVER['QUERY_STRING'])) {
				$showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
				$showGoTo .= $_SERVER['QUERY_STRING'];
			}
	 	  ?>
					        <a href="#" onclick="<?php popup('sample30.php?regID='.$reg_id.'&locID='.$loc_id, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" /></a>
					        <?php
            /** Display error messages if "user" field is empty or there is already a user with that name*/
            if ($structureIsEmpty) { ?>
				          </span>
					      <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la structure de rattachement, SVP!</div>
				        <?php } ?></td>
                       
				      </tr>
                      <?php } ?>
<tr valign="baseline">
                      
					    <th scope="row">Structure de rattachement:</th>
			    <td class="style1"><input type="hidden" class="text" id="idPerson" name="idPerson" style="width:20%" readonly="readonly">
                  <input type="text" class="text" id="instCd" name="instCd" style="width:25%" readonly="readonly">
                  <input type="text" class="text" id="instNm" name="instNm" style="width:45%" readonly="readonly">
                  <span class="btnTy3">
                  <input type="button" class="btn" value="Rechercher" onClick="fn_searchInst();">
                  </span> <span class="btnTy3">
                  <input type="button" class="btn" value="Réinitialiser"onclick="fn_reset();">
                </span></td>
                       
				      </tr>
                            
                            
                            
                            
			</tbody>
					</table>
					<p><span class="style10">
					  <?php if (isset($_GET['valid']) && $_GET['valid'] == 'ok'){ ?>
                      <span class="succes">Commission insérée avec succès!!!</span>
                      <?php } ?>
                      <span class="style1">
                      <input type="hidden" name="commission_lib" cols="32" rows="5">
                      <input name="display" type="hidden" value="1" size="32" />
                    </span></span></p>
				</form>
			</div>
		</div>
		<!-- //입력폼 끝 -->
		<!-- //Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><input type="button" class="btn" value="Enregistrer<?php //echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'insertBtn'); ?>" onClick="javascript:fn_insertUser();"></span> <span class="btnTy4"><button class="btn" onClick="window.close();"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'UserRegPopup', $ObjId = 'closeBtn'); ?></button>
			</span>
		</div>
		<!-- //Layout : Button Area -->
	</div>
</div>
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div>
</body>
</html>