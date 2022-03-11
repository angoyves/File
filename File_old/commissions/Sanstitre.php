<?php require_once('../../Connections/MyFileConnect.php'); ?>
<?php require('../includes/inc/db.php'); ?>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
<link rel="stylesheet" href="../css/common.css" media="all">
<link rel="stylesheet" href="../css/common.css">
<link rel="stylesheet" href="../layout.css">
<link rel="stylesheet" href="../css/component.css">
<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javascript" src="../js/common/frame.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript">


	
	//작성 내용 저장 :: Save Information
	 function fn_insertPubPayment(){
	 	var form = document.frm_pubPm_insert;
	 
	 	// 파일 태그 추가후 선택을 하지 않은 경우
		/*if(!fn_checkSelectedFile()){
			return;
		}*/
	 	
	 	util_trimRequiredValue(form);
	 	/*if(!validateFrm_pubPm_insert(form)){
			return;
		}else{*/
			util_confirmAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubPaymentReg', $ObjId = 'bidNo'); ?> [" + form.bidNo.value + "-" + form.bidModSeq.value +"] " 
					+ "<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_save_msg_dbf'); ?>" ,"fn_submitInsertPubPayment()");
		//}
	 	
	 }
	
	 //Form Submit
	 function fn_submitInsertPubPayment(){
	
		 var form = document.frm_pubPm_insert;
		
		 //처리중 이미지 만들기
		 util_showExecutionImage();
		
		 form.action = "com/comCtrl.php";
		 form.target = "ResultFrame";
		 form.submit();
	 }

	//목록으로 이동
	function fn_movePubPaymentList(){
		history.go(-1);
	}
	
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}
	function fn_searchInst(){
		
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url    = "http://localhost:8080/cam-exms/jsp/ep/pub/EpPubComInstListPopup.php";
				  
		var ReturnValue = window.open(url, "inst", openParam);
		ReturnValue.focus();
	}
	function fn_reset(){
		
		document.getElementById("instCd").value = "";
		document.getElementById("instNm").value = "";
		
	}
</script>
<style type="text/css">
<!--
.style1 {font-family: "Arial Narrow"}
-->
</style>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<form name="frm_pubPm_insert" method="post" action="../CtrL/ComCtrl.php" encType="multipart/form-data">
						<input type="hidden" name="bidLot" value="NON" >
						<input type="hidden" name="type_commission_id" value="<?php echo isset($_REQUEST["typID"])?$_REQUEST["typID"]:"" ?>" />
                        <input type="hidden" name="commission_id" value="" />
                        <input type="hidden" name="user_id" value="" />
                        <input type="hidden" name="commission_parent" value="" />
                        <input type="hidden" name="montant_cumul" value="" />
                        <input type="hidden" name="nombre_offre" value="" />
                        <input type="hidden" name="region_id" value="<?php echo isset($_REQUEST["regID"])?$_REQUEST["regID"]:"13" ?>" />
                        <input type="hidden" name="departement_id" value="<?php echo isset($_REQUEST["depID"])?$_REQUEST["depID"]:"10" ?>" />
                        <input type="hidden" name="localite_id2" value="<?php echo isset($_REQUEST["locID"])?$_REQUEST["locID"]:"79" ?>" />
                        <input type="hidden" name="membre_insert" value="" />
                        <input type="hidden" name="dateCreation" value="" />
                        <input type="hidden" name="dateUpdate" value="" />
  <input type="hidden" name="MM_insert" value="frm_pubPm_insert" />


                        <table class="data">
                                                <colgroup>
                                                    <col style="width: 25%">
                                                    <col style="width: *">
                                                </colgroup>
                                                <tbody>
                                                    
                                                    
                                                    
                                                    
                                                    
                        <tr valign="baseline">
                                                <th scope="row">Type Commission:</th>
                                                <td class="style1"><select name="type_commission" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value=""  <?php if (!(strcmp("", 7))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php
                        do {  
                        ?>
                                                  <option value="<?php echo "Sanstitre.php?typID=".$row_rsTypeCommission['type_commission_id']?>"<?php if (!(strcmp($row_rsTypeCommission['type_commission_id'], $_GET['typID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsTypeCommission['type_commission_lib']) ?></option>
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
                                                    <a href="#" onClick="<?php popup($showGoTo, "710", "250"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16">
                                                      <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($typecommissionIsEmpty) { ?>
                                                  </a></span>
                                                  <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
                                        <?php } ?></td>
                                              </tr>
                                              <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3 || $_GET['typID'] == 4 || $_GET['typID'] == 5)){ ?>
                                              <tr valign="baseline">
                                               <th scope="row">Region:</th>
                                                <td valign="middle" class="style5"><select name="menu1" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="Sanstitre.php" <?php if (!(strcmp("Sanstitre.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php
                                do {  
                                ?>
                                                  <option value="<?php echo "Sanstitre.php?typID=".$_GET['typID']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
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
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "150"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" /></a>
                                                  <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($regionIsEmpty) { ?>
                                                  <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
                                                <?php } ?></td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Departement:</th>
                                                <td valign="middle" class="style5"><select name="menu2" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="Sanstitre.php" <?php if (!(strcmp("Sanstitre.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
                                                  <?php do {  ?>
                                                  <option value="<?php echo "Sanstitre.php?typID=".$_GET['typID']."&regID=".$_REQUEST['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?> </option>
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
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "350"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" />
                                                    <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($departementIsEmpty) { ?>
                                                  </a>
                                                  <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le departement, SVP!</div>
                                                <?php } ?></td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Localite:</th>
                                                <td valign="middle" class="style5"><select name="localite_id" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="Sanstitre.php" <?php if (!(strcmp("Sanstitre.php", $_GET['locID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php do {  ?>
                                                  <option value="<?php echo "Sanstitre.php?typID=".$_GET['typID']."&regID=".$_REQUEST["regID"]."&depID=".$_REQUEST["depID"]."&locID=".$row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], $_GET['locID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']) ?></option>
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
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" />
                                                    <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($localiteIsEmpty) { ?>
                                                  </a>
                                                <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la localite, SVP!</div></td>
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
                                                    <a href="#" onClick="<?php popup($showGoTo, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" />
                                                      <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($natureIsEmpty) { ?>
                                                  </a></span>
                                                  <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la nature , SVP!</div>
                                                <?php } ?></td>
                                              </tr>
                                              
                        <tr valign="baseline">
                                              
                                                <th scope="row">Structure :</th>
                                        <td class="style1"><input type="hidden" class="text" id="idStructure" name="idStructure" style="width:20%" readonly="readonly">
                                          <input type="text" class="text" id="instCd" name="instCd" style="width:25%" readonly="readonly">
                                          <input type="text" class="text" id="instNm" name="instNm" style="width:45%" readonly="readonly">
                                          <span class="btnTy3">
                                          <input type="button" class="btn" value="Rechercher" onClick="fn_searchInst();">
                                          </span> <span class="btnTy3">
                                          <input type="button" class="btn" value="Réinitialiser"onclick="fn_reset();">
                                        </span><span class="style5">
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
                                        <a href="#" onClick="<?php popup('sample30.php?regID='.$reg_id.'&locID='.$loc_id, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" /></a>
                                        <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($structureIsEmpty) { ?>
                                        </span>
                                        <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la structure de rattachement, SVP!</div>
                                        <?php } ?></td>
                       
				      				</tr>
									<tr>
										<td style="display: none;">
											<?php include('../com/FileUpDnInsert.php'); //flush(); ?>
										</td>
									</tr>
								</tbody>
							</table>
                        	<div class="fR pt10 mb20">
                            <span class="btnTy21">
                            <input name="Envoyer" type="submit" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubPaymentReg', $ObjId = 'insertPubPayment'); ?>">
                            <input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubPaymentReg', $ObjId = 'insertPubPayment'); ?>" onclick="fn_submitInsertPubPayment();" />
                            </span>
                            <span class="btnTy21">
                            <input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubPaymentReg', $ObjId = 'cancelBtn'); ?>" onClick="javascript:fn_movePubPaymentList();"></span>
</div>
						</form>
</body>
</html>