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
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<script type="text/javaScript" src="../js/common/font.js"></script>
<script type="text/javaScript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/prototype.js"></script>
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript" src="../js/common/calendar.js"></script>
<script type="text/javascript" src="../js/common/date.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/Disconnect.js"></script>
<script type="text/javascript" src="../js/common/popup.js"></script>
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
function fn_onLoad(myValue){
	
	fn_selectListPageEpPub(myValue);
	
}

/***********************************
 *  공고기관 초기화
 ***********************************/
function fn_reset(){
	form = document.frm_pub;	
	document.getElementById("instCd").value = "";
	document.getElementById("instNm").value = "";
	document.getElementById("txtSearch").value = "";
	document.getElementById('frm_pub').submit();
	
	
}

/***********************************
 *  공고기관 조회 팝업
 ***********************************/
function fn_searchInst(){
	
	var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
	var url    = "http://localhost/cam-exms/jsp/ep/pub/EpPubBidInstListPopup.php";
   			  
	var ReturnValue = window.open(url, "inst", openParam);
	ReturnValue.focus();
}

/***********************************
 *  입찰공고 목록 조회
 ***********************************/
function fn_selectListPageEpPub(myValue){
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
	document.getElementById('frm_pub').action='membreFrame.php?value='+myValue;
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
	function fn_moveUserDetail(userId){
		var form = parent.document.frm_user;
		form.userId.value = userId;
		form.target = "_top";
		form.action = "userFrame.php";
		form.submit();
	}
</script>
<style type="text/css">
<!--
.style5 {font-family: "Arial Narrow"; font-size: 16px; }
-->
</style>
</head>
<body onLoad="fn_onLoad(<?php echo $_GET['value']; ?>)">
<div id="main">
<div id="sitewrap">
<div id="wrap">
<div class="top"><img src="../images/admin_top_agescom.jpg" alt="top"></div>
  <div id="con_wrap">
    <div class="menu">
      <ul>
            <li class="depth1_on"><p class="sline">Gestion d'Utilisateur</p>
						<ul>
							<li class="depth2"><a href="javascript:fn_logOut();">Déconnexion</a></li>
							
							<li class="depth2"><a href="UsersReg.php">Utilisateurs</a></li>
							
							<li class="depth2"><a href="UserDetails.php">Mes Informations</a></li>
						</ul>
			</li>
          </ul>
        </li>
        <li class="depth1_on">
          <p class="sline">Commissions/Comités</p>
          <ul>
            <li class="depth2"><a href="../commissions/CommissionListNew.php">Liste des Commissions</a></li>
            <li class="depth2"><a href="../commissions/CommissionListNew.php">Liste des Comites</a></li>
          </ul>
        </li>
        <li class="depth1_none">
          <p class="sline">Membres </p>
          <ul>
            
            <li class="depth2_on"><p class="bullet"><a href="../membres/membre.php">Liste des Membres</a></p></li>
            <li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Autres</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div id="contents" class="content">
      <div class="con" style="margin-top: 20px">
		        <div class="fR" style="display: none;">
					<span class="btnTy21 fR ml15"><input type="button" class="btn" value="Test" onClick="fn_selectTestBid();"></span>
				</div>
                <h1 class="h1_title">Liste des Membres</h1>
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
                    <input name="txtValue2" type="hidden" id="txtValue2" value="<?php echo (isset($_GET['value']))? $_GET['value'] : ""; ?>"/>
                    <input type="hidden" name="bizRegNo" value="<?php echo $_POST['bizRegNo'] ?>">
					
				<div class="tableTy2">
              <div class="dataArea">	
	                	<table class="data">
							<colgroup>
								<col style="width:20%">
                            <col style="width:80%">
							</colgroup>
	                        <tbody>
	                            <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchName'); ?></th>
	                                <td>
	                                	<input type="hidden" class="text" id="idPerson" name="idPerson" style="width:20%" readonly="readonly">
                                        <input type="text" class="text" id="instCd" name="instCd" style="width:20%" readonly="readonly">
	                            		<input type="text" class="text" id="instNm" name="instNm" style="width:40%" readonly="readonly">
	                            		<span class="btnTy3"><input type="button" class="btn" value="Rechercher" onClick="fn_searchInst();"></span>
	                            		<span class="btnTy3"><input type="button" class="btn" value="Réinitialiser"onclick="fn_reset();"></span></td>
	                            </tr>
	                	    <th align="right" scope="row">Afficher par :</th>
	                	    <td><select name="jumpMenu2" id="jumpMenu2" onChange="MM_jumpMenu('parent',this,0)">
	                	      <option value="membre.php" <?php if (!(strcmp("", $_GET['value']))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	      <option value="membre.php?value=0" <?php if (!(strcmp(0, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Par REGION</option>
	                	      <option value="membre.php?value=142" <?php if (!(strcmp(142, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINMAP</option>
	                	      <option value="membre.php?value=144" <?php if (!(strcmp(144, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINFI</option>
	                	      <option value="membre.php?value=145" <?php if (!(strcmp(145, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINEPAT</option>
	                	      <option value="membre.php?value=143" <?php if (!(strcmp(143, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MINDEVEL</option>
	                	      <option value="membre.php?value=146" <?php if (!(strcmp(146, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep TUTELLE</option>
	                	      <option value="membre.php?value=40" <?php if (!(strcmp(40, $_GET['value']))) {echo "selected=\"selected\"";} ?>>Rep MO</option>
	                	      <option value="membre.php?value=2" <?php if (!(strcmp(2, $_GET['value']))) {echo "selected=\"selected\"";} ?>>SECRETAIRE</option>
	                	      <option value="membre.php?value=1" <?php if (!(strcmp(1, $_GET['value']))) {echo "selected=\"selected\"";} ?>>PRESIDENT</option>
	                	      </select>	                	      <input type="text" id="FonctionId" name="FonctionId" value="<?php echo $_GET['value'] ?>"></td>
                	      </tr>
	                	  <?php if (isset($_GET['value']) && ($_GET['value']==0)){ ?>
	                	  <tr>
	                	    <th align="right" scope="row">Région:</th>
	                	    <td><select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
	                	      <option value="membre.php" <?php if (!(strcmp("membre.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	      <?php
		do {  
		?>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
	                	      <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
	                	      </select>
	                	      <input type="text" id="FonctionId2" name="FonctionId2" value="<?php echo $_GET['regID'] ?>"></td>
                	      </tr>
	                	  <?php if (isset($_GET['regID'])){ ?>
	                	  <tr>
	                	    <th align="right" scope="row">Departement:</th>
	                	    <td>
	                	      <select name="menu2"  onChange="MM_jumpMenu('parent',this,0)">
	                	        <option value="membre.php" <?php if (!(strcmp("membre.php", "depID"))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	        <?php do {  ?>
	                	        <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?></option>
	                	        <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
                	        </select>
	                	      <input type="text" id="FonctionId3" name="FonctionId3" value="<?php echo $_GET['depID'] ?>"></td>
                	      </tr>
	                	  <tr>
	                	    <th align="right" scope="row">Type Membre :</th>
	                	    <td><select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=" ?>" 
			<?php if (!(strcmp("", $_GET['typeM']))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=2" ?>" 
			<?php if (!(strcmp(2, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>SECRETAIRE</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=1" ?>" 
			<?php if (!(strcmp(1, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>PRESIDENT</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=142" ?>" 
			<?php if (!(strcmp(142, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINMAP</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=144" ?>" 
			<?php if (!(strcmp(144, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINFI</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=145" ?>" 
			<?php if (!(strcmp(145, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINEPAT</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=143" ?>" 
			<?php if (!(strcmp(143, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MINDEVEL</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=146" ?>" 
			<?php if (!(strcmp(146, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep TUTELLE</option>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&regID=".$_GET['regID']."&depID=".$_GET['depID']."&typM=40"  ?>"
			<?php if (!(strcmp(40, $_GET['typM']))) {echo "selected=\"selected\"";} ?>>Rep MO</option>
	                	      </select></td>
                	      </tr>
	                	  <?php } ?>
	                	  <?php } ?>
	                	  <?php if (isset($_GET['value']) && ($_GET['value']<>0)){ ?>
	                	  <tr>
	                	    <th align="right" scope="row">Type Commissions:</th>
	                	    <td><select name="jumpMenu3" id="jumpMenu3" onChange="MM_jumpMenu('parent',this,0)">
	                	      <option value="#">TOUS::</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=1" ?>" <?php if (!(strcmp(1, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>COMMISSION CENTRALE</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=7" ?>" <?php if (!(strcmp(7, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>COMMISSION INTERNE</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=8" ?>" <?php if (!(strcmp(8, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>COMMISSION SPECIALE</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=3" ?>" <?php if (!(strcmp(3, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>COMMISSION REGIONALE</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=4" ?>" <?php if (!(strcmp(4, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>COMMISSION DEPARTEMENTALE</option>
	                	      <option value="<?php echo "membre.php?value=" . $_GET['value'] . "&typID=10" ?>" <?php if (!(strcmp(10, $_GET['typID']))) {echo "selected=\"selected\"";} ?>>CADRE DE CONCERTATION</option>
	                	      </select></td>
                	      </tr>
	                	  <?php //echo $_GET['typID'] ?>
	                	  <?php if (isset($_GET['typID']) && ($_GET['typID']==3 || $_GET['typID']==4 || $_GET['typID']==7)){ ?>
	                	  <tr>
	                	    <th align="right" scope="row">Région:</th>
	                	    <td>
                            <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
	                	      <option value="membre.php" <?php if (!(strcmp("membre.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	      <?php
		do {  
		?>
	                	      <option value="<?php echo "membre.php?value=".$_GET['value']."&typID=".$coltypID_fonction."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
	                	      <?php
		} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
		  $rows = mysql_num_rows($rsRegion);
		  if($rows > 0) {
			  mysql_data_seek($rsRegion, 0);
			  $row_rsRegion = mysql_fetch_assoc($rsRegion);
		  }
		?>
	                	      </select></td>
                	      </tr>
	                	  <tr>
	                	    <th align="right" scope="row">Departement:</th>
	                	    <td>
	                	      <select name="menu2"  onChange="MM_jumpMenu('parent',this,0)">
	                	        <option value="membre.php" <?php if (!(strcmp("membre.php", "depID"))) {echo "selected=\"selected\"";} ?>>TOUS::</option>
	                	        <?php do {  ?>
	                	        <option value="<?php echo "membre.php?value=".$_GET['value']."&typID=".$coltypID_fonction."&regID=".$_GET['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?></option>
	                	        <?php
			} while ($row_rsDepartements = mysql_fetch_assoc($rsDepartements));
			  $rows = mysql_num_rows($rsDepartements);
			  if($rows > 0) {
				  mysql_data_seek($rsDepartements, 0);
				  $row_rsDepartements = mysql_fetch_assoc($rsDepartements);
			  }
			?>
                	        </select></td>
                	      </tr>
	                	  <?php } ?>
	                	  <?php } ?>
                          <tr>
	                                <th scope="row"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'searchOther'); ?></th><!-- 입찰공고명 -->
	                                <td>
                                	  <input type="text" class="text" id="txtSearch" name="txtSearch" style="width:97%" maxlength="250" value="<?php echo (isset($_POST['txtSearch']))? $_POST['txtSearch'] : ""; ?>"
                                			onblur="javascript:util_checkValidation(this, '^[^<>]*$', 250);">
                           			</td>
                          </tr>
                        </tbody>
               	    </table>
                	  <p>&nbsp;</p>
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
                 <iframe name="PubPaymentFrame" id="PubPaymentFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
                 <div class="fR pt10 mb20"><span class="btnTy21">
                   <input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubMembre', $ObjId = 'insertPubMembre'); ?> " onClick="javascript:fn_movePubCommissionInsert();">
                 </span></div>
              </form>
              
          </div>
		</div>
	</div>


</div>
</div>
</div>
</body>
</html>