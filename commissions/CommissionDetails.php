<?php 
	require_once('../Connections/MyFileConnect.php');
	require("../include/logfile.php");
	require('../includes/inc/db.php');
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

$colname_Recordset = "-1";
if (isset($_REQUEST['bizRegNo'])) {
  $colname_Recordset = $_REQUEST['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset = sprintf("SELECT * FROM commissions WHERE commission_id = %s", GetSQLValueString($colname_Recordset, "int"));
$Recordset = mysql_query($query_Recordset, $MyFileConnect) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

$colname_rsMembresCommission = "-1";
if (isset($_REQUEST['bizRegNo'])) {
  $colname_rsMembresCommission = $_REQUEST['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsMembresCommission = sprintf("SELECT personne_id, personne_nom, personne_prenom, fonctions_fonction_id, fonction_lib, personnes.structure_id, personne_telephone, sexe, membres.state  FROM membres, commissions, personnes, fonctions WHERE membres.commissions_commission_id = commissions.commission_id   AND membres.personnes_personne_id = personnes.personne_id   AND membres.fonctions_fonction_id = fonctions.fonction_id   AND add_commission_agescom = 1  AND membres.display_agescom = 1 AND (type_commission_id = 1 OR type_commission_id = 3 OR type_commission_id = 4 OR type_commission_id = 7 OR type_commission_id = 8) AND commission_id = %s ORDER BY fonctions_fonction_id ASC", GetSQLValueString($colname_rsMembresCommission, "int"));
$rsMembresCommission = mysql_query($query_rsMembresCommission, $MyFileConnect) or die(mysql_error());
$row_rsMembresCommission = mysql_fetch_assoc($rsMembresCommission);
$totalRows_rsMembresCommission = mysql_num_rows($rsMembresCommission);

$colname_Recordset1 = "-1";
if (isset($_POST['bizRegNo'])) {
  $colname_Recordset1 = $_POST['bizRegNo'];
}
mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_Recordset1 = sprintf("SELECT * FROM fichiers WHERE commissions_commission_id = %s ORDER BY fichierID DESC", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $MyFileConnect) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/alertExms.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/prototype.js"></script>
<script type="text/javascript" src="../js/common/calendar.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javascript" src="../js/common/file.js"></script>

<script type="text/javaScript" language="javascript">

	//로그아웃
	function fn_logOut(){
		//util_confirmAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'exms_common', $ObjId= 'confirm_logout'); ?>", "submitLogout()");
		util_confirmAlert("Etes-vous sur de vouloir vous déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}

	// 리스트 화면 처리 함수 :: List processing functions, screen
	function fn_moveList(){
		var form = document.frm_pubCommission_detail;
		form.isBack.value ="Y";
		form.target = "_top";
		//form.action = "../membres/membre.php";
		form.action = "CommissionListNew.php";
		form.submit();
	}

	function fn_goPage(exDocType) {

		var form = document.frm_pubCommission_detail;
		
		form.exDocType.value = exDocType;
		
		form.action = "<c:url value='/ed/rcv/moveCtDocList.do'></c:url>";
		form.target = "_top";
		form.submit();
	}
	
	function fn_movePubPaymentInsert(){
		var form = document.frm_pubCommission_detail;
		form.action = "../UploadFile.php";
		form.target = "_top";
		form.submit();
	}
	function fn_movePubMemberInsert(){
		var form = document.frm_pubCommission_detail;
		form.action = "../UploadFile.php";
		form.target = "_top";
		form.submit();
	}
	function fn_moveCommissionUpdate(){
		var form = document.frm_pubCommission_detail;
		form.target = "_top";
		form.action = "CommissionUpdate.php";
		form.submit();
	}
	function fn_moveCommissionDelete(){
		var form = document.frm_pubCommission_detail;
		form.target = "_top";
		form.action = "delete.php";
		form.submit();
	}
	function fn_searchPerson(exParaType){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url    = "../personnes/searchPersonnes.php?comID="+ exParaType;
		window.open(url, 'pubSupplierSrchPop', openParam);
	}
	function fn_Print(exParaType){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		//var url    = "../etats/ex.php?bizRegNo="+ exParaType;
		//var url    = "../etats/ex.php";
		var form = document.frm_pubCommission_detail;
		form.target = "_blank";
		form.action = "../etats/ex.php";
		form.submit();
		//window.open(url, 'pubSupplierSrchPop', openParam);
	}
</script>
</head> 
<body id = "body_admin">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
	  <div class="top">
			<img src="../images/admin_top_agescom.jpg" alt="top">
		</div>
		<div class="con_wrap">
        <div class="menu">
              <ul>
                    <li class="depth1_on"><p class="sline">Gestion d'Utilisateur</p>
                                <ul>
                                    <li class="depth2"><a href="javascript:fn_logOut();">Déconnexion</a></li>
                                    
                                    <li class="depth2"><a href="../user/UsersReg.php">Utilisateurs</a></li>
							
							<li class="depth2"><a href="../user/UserDetails.php">Mes Informations</a></li>
                                </ul>
                    </li>
          </ul>
                </li>
                <li class="depth1_on">
                  <p class="sline">Commissions/Comités</p>
                  <ul>
                    <li class="depth2_on"><a href="../commissions/CommissionListNew.php">Liste Commissions</a></li>
                    <li class="depth1_on"><p class="bullet"><a href="../commissions/CommissionListNew.php">&nbsp;Details Commission</a></p></li>
                  </ul>
                </li>
                <li class="depth1_none">
                  <p class="sline">Membres </p>
                  <ul>
                    
                    <li class="depth2"><a href="../membres/membre.php">Liste Membres</a></li>
                    <li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Autres</a></li>
                  </ul>
                </li>
              </ul>
          </div>
            <!-- //menu END -->

			<div class="content" id="contents">
				<h1 class="h1_title">Details Commission<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='title'); ?></h1>
				<h2 class="bullet1"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='stSubtitle'); ?></h2>
				<form name="frm_pubCommission_detail" method="post">
					<div class="tableTy1">
						<div class="dataArea">
							<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
							<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
							<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
							<input type="hidden" name="bidNo" value="${RcvSVO.bidNo}">
							<input type="hidden" name="exDocType" />
                            <input type="hidden" name="bizRegNo" value="<?php echo $_POST['bizRegNo'] ?>"/>
                            <input type="hidden" name="comId" value="<?php echo $row_Recordset['commission_id']; ?>"/>
                            <input type="hidden" name="comSig" value="<?php echo strtoupper($row_Recordset['commission_sigle']); ?>"/>
                            <input type="hidden" name="comLib" value="<?php echo strtoupper($row_Recordset['commission_lib']); ?>"/>
                            
                            
							<table class="data">
								<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='1stSubtitle'); ?></caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: 80%">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocType'); ?>Numero</th>
										<td>
										<c:choose>
											<c:when test="${RcvSVO.exDocType == 'DBF'}">
				                      			<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='DBF'); ?>
				                      		</c:when>
										</c:choose>
										<?php echo $row_Recordset['commission_id']; ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='bidNo'); ?>Sigle</th>
										<td><?php echo strtoupper($row_Recordset['commission_sigle']); ?></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='bidNm'); ?>Designation</th>
										<td><?php echo strtoupper($row_Recordset['commission_lib']); ?></td>
									</tr>
                                    <tr>
										<th scope="row" class="noLine tL"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='bizRegNo'); ?>Etat</th>
										<td><?php echo (isset($row_Recordset['display_agescom']) && $row_Recordset['display_agescom']==1) ?'Activé':'Desactivé';  ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
                    <h2 class="bullet1 mt20">Membres&nbsp;</h2>
                  <div class="tableTy1">
                   
  <table class="data">
    <caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></caption>
    <colgroup>
      <col style="width: 40%">
      <col style="width: 35%">
      <col style="width: *%">
      </colgroup>
    <thead>
      <tr>
        <th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='rowNum'); ?>Noms et prenoms</th>
        <th scope="col">Fonction<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypeNm'); ?></th>
        <th scope="col">Contact</th>
        </tr>
    </thead>
    <tbody>
      <?php do { ?>
  <tr>
    <td nowrap>
	<?php if (isset($row_rsMembresCommission['sexe']) && $row_rsMembresCommission['sexe']=="M") { ?>
    	<?php if (isset($row_rsMembresCommission['state']) && $row_rsMembresCommission['state']=="A") { ?>
        <img src="../images/icons/young-user-icon.jpg" width="18" height="16">
        <?php } else { ?>
        <img src="../images/icons/young-user-icon-gris.jpg" width="18" height="16">
        <?php } ?>
    <?php } else { ?>
    	<?php if (isset($row_rsMembresCommission['state']) && $row_rsMembresCommission['state']=="A") { ?>
        <img src="../images/icons/female-user-icon.jpg" width="18" height="16">
        <?php } else { ?>
        <img src="../images/icons/female-user-icon-gris.jpg" width="18" height="16">
        <?php } ?>
    <?php } ?>
    &nbsp;<a href="../membres/memberUpdate.php?perID=<?php echo $row_rsMembresCommission['personne_id']; ?>&comID=<?php echo $row_Recordset['commission_id']; ?>" ><?php echo strtoupper($row_rsMembresCommission['personne_nom']) .' '. strtoupper($row_rsMembresCommission['personne_prenom'].' '.$row_rsMembresCommission['state']); ?></a></td>
    <td><?php echo $row_rsMembresCommission['fonction_lib']; ?></td>
    <td nowrap><a href="#" onClick="javascript:util_downloadFileByFullPath(); return false;"></a>
      <iframe name="attachFileFrame" width="0" height="0" frameborder="0"></iframe><?php echo $row_rsMembresCommission['personne_telephone']; ?></td>
  </tr>
<?php } while ($row_rsMembresCommission = mysql_fetch_assoc($rsMembresCommission)); ?> 
 <?php if ($totalRows_rsMembresCommission == 0) { // Show if recordset empty ?>
      <tr>
        <td colspan="3" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId='common_no_result_msg'); ?></td>
      </tr>
     <?php } // Show if recordset empty ?>
    </tbody>
  </table>
  
<p>&nbsp;</p>
                  </div>
					<h2 class="bullet1 mt20"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></h2>
					<div class="tableTy1">
						<table class="data">
							<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='2ndSubtitle'); ?></caption>
							<colgroup>
								<col style="width: 15%">
								<col style="width: 35%">
								<col style="width: 50%">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='rowNum'); ?>Numero</th>
									<th scope="col"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypeNm'); ?>Nom document</th>
									<th scope="col">Fichier<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommissionDetail', $ObjId='exDocTypePath'); ?></th>
								</tr>
							</thead>
							<tbody>
								
                                    <?php $i=0; do { ?>
                                        <?php if ($totalRows_Recordset1 > 0) { $i++;// Show if recordset not empty ?>
                                          <tr>
                                            <td class="tC"><?php echo $i; //$row_Recordset1['fichierID']; ?></td>
                                            <td class="tC"><?php echo $row_Recordset1['nomFichier']; ?></td>
                                            <td class="tC"><a href="#" onClick="javascript:util_downloadFileByFullPath(&quot;<c:url value='/'></c:url>&quot;,&quot;${attachList.fileLoc}&quot;+&quot;${attachList.fileNm}&quot;,&quot;${attachList.fileNm}&quot;); return false;"><?php echo $row_Recordset1['url']; ?>
                                              <iframe name="attachFileFrame" width="0" height="0" frameborder="0"></iframe>
                                            </a></td>
                                          </tr>
                                          <?php } // Show if recordset not empty ?>
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <tr>
    <td colspan="3" style="width: 740px" align="center"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId='common_no_result_msg'); ?></td>
  </tr>
  <?php } // Show if recordset empty ?>
                            </tbody>
						</table>
					  <p>&nbsp;</p>
				  </div>
				</form>
				<div class="fR pt10 mb20">
					
                    <span class="btnTy21"><input type="button" class="btn" value="Imprimer" onClick="javascript:fn_Print('<?php echo $row_Recordset['commission_id']; ?>');"></span>
                    <span class="btnTy21"><input type="button" class="btn" value="Ajouter un membre" onClick="javascript:fn_searchPerson('<?php echo $row_Recordset['commission_id']; ?>');"></span>
                    <span class="btnTy21"><input type="button" class="btn" value="Enregistrer un fichier" onClick="javascript:fn_movePubPaymentInsert();"></span>
                    <span class="btnTy21"><input type="button" class="btn" value="Modifier" onClick="javascript:fn_moveCommissionUpdate();"></span>
					<span class="btnTy21"><input type="button" class="btn" value="Supprimer" onClick="javascript:fn_moveCommissionDelete();"></span>
					
                    <span class="btnTy21"><input type="button" class="btn" value="Retour" onClick="javascript:fn_moveList();"></span>
				
					</span>
				</div>
		  </div><!-- //content END -->
	  </div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->
</body>
</html>
<?php
mysql_free_result($Recordset);

mysql_free_result($rsMembresCommission);

mysql_free_result($Recordset1);
?>
