<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php require('../com/recordSetCommission.php'); ?>
<?php require('../inc/biblio.inc.php'); ?>
<?php require('../includes2/db.php'); ?>
<html lang="ko"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Application de Gestion des Commissions</title>
<link rel="stylesheet" href="../css/common.css" media="all">
<script type="text/javaScript" src="../js/common/font.js"></script>
<script type="text/javaScript" src="../js/common/alert.js"></script>
<script type="text/javaScript" language="javascript">
    
    // mask String
    var validateTokenNumber="Chiffre";
    var validateTokenKorean="Caractère coréen";
    var validateTokenUpperEnglish="Majuscule";
    var validateTokenLowerEnglish="Minuscule";
    var validateTokenNewline="Saut de ligne";
    var validateTokenUnderBar="Barre de soulignement";
    var validateTokenComma="Virgule";
    var validateTokenDot="Point";
    var validateTokenDash="Tiret";
    var validateTokenSpace="Espace";
    var validateTokenParentheses ="Parenthèses";

    // required message
    var requiredMessage="Veuillez remplir les champs obligatoires.";

    // calrendar.js에서 사용 	
    var systime ="May 1, 2021 13:07:21";
    var systimeStr ="20210501130721721";
    var today ="20210501";
    // 공통메세지 	
    var valiTelNoMsg ="Numéro de téléphone portable/fax invalide. (8 chiffres)";
    var valiDateMsg ="Date invalide.";
    var valiNoMatchDateMsg ="Date du commencement doit être antérieure à la date de la clôture.";
    var todayStr ="01/05/2021";
    // contextPath
    var contextPath = "/";
    // 현재언어
    var langCode = "fr";
     // 날짜포맷
    var dateFormat = "dd/MM/yyyy";
     // 날짜구분타입
    var dateSeparater = "/";
     // 시간구분타입
    var timeSeparater = ":";
     // 화폐구분타입
    var caliberSeparater = ".";
     // 화폐구분단위
    var caliberDigits = 3;
     // 소수점 구분
    var caliberPoint = ",";
     // 입찰, 계약 자리수 구분 메세지
     var invalidDigitMessage = "Possible de saisir un nombre entier avec {0} chiffre et un décimal avec {1} chiffres";
     // 금액 체크 메세지
     var invalidMoneyMessage = "Entrée invalide.";
     // 수량 체크 메세지
     var invalidQuantityMessage = "Entrée inalide.";
     // 소수점 체크 메세지
     var invalidDecimalMessage = "Possible de saisir jusqu'à {1} chiffres après la virgule";
     // 확인 메세지
     var confirmStr = "Confirmer";
     // 취소 메세지
     var cancelStr = "Annuler";
     // 정수 범위 메세지
     var intRangeStr = "Nombre entier peut consister 14 chiffres au plus.";
 
	function noEvent() {
		if (event.keyCode == 116) {
			event.keyCode= 2;
			return false;
		}
	}
	document.onkeydown = noEvent;
	
</script>

<script type="text/javascript"> 

     var bCancel = false; 

    function validateFrm_pubPm_insert(form) {                                                                   
        if (bCancel) 
      return true; 
        else 
       return validateRequired(form) && validateMaxLength(form); 
   } 

    function required () { 
     this.aa = new Array("bidNo", "N° d'Avis d'Appel d'Offre", new Function ("varName", "this.maxlength='11';  return this[varName];"));
     this.ab = new Array("supplierNm", "Soumissionnaire", new Function ("varName", "this.maxlength='200';  return this[varName];"));
    } 

    function maxlength () { 
     this.aa = new Array("bidNo", "N° d'Avis d'Appel d'Offre can not be greater than 11 characters(korean 3characters).", new Function ("varName", "this.maxlength='11';  return this[varName];"));
     this.ab = new Array("bidNm", "Intitulé de l'Avis d'Appel d'Offre can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200';  return this[varName];"));
     this.ac = new Array("supplierNm", "Soumissionnaire can not be greater than 200 characters(korean 3characters).", new Function ("varName", "this.maxlength='200';  return this[varName];"));
    } 


</script>


<script type="text/javascript" src="../js/common/font.js"></script>
<script type="text/javascript" src="../js/common/alert.js"></script>
<script type="text/javascript" src="../js/common/pagination.js"></script>
<script type="text/javascript" src="../js/common/validation.js"></script>
<script type="text/javascript" src="../js/common/frame.js"></script>
<script type="text/javascript" src="../js/common/ajax.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}
	
	//작성 내용 저장 :: Save Information
	 function fn_insertPubPayment(){
	 	var form = document.frm_pubPm_insert;
	 
	 	// 파일 태그 추가후 선택을 하지 않은 경우
		if(!fn_checkSelectedFile()){
			return;
		}
	 	
	 	util_trimRequiredValue(form);
	 	if(!validateFrm_pubPm_insert(form)){
			return;
		}else{
			util_confirmAlert("Voulez-vous enregistrer la commission concernée?" ,"fn_submitInsertPubPayment()");
		}
	 	
	 }
	
	 //Form Submit
	 function fn_submitInsertPubPayment(){
	
		 var form = document.frm_pubPm_insert;
		
		 //처리중 이미지 만들기
		 util_showExecutionImage();
		
		 form.action = "../CtrL/ComCtrl.php";
		 //form.target = "ResultFrame";
		 form.submit();
	 }
 
	//입찰공고번호 검색 팝업
	function fn_searchBidNo(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url = "/ed/rcv/pubPaymentSrchListPopup.do";
		window.open(url, 'pubBidSrchPop', openParam);
	}
	
	//조달업체 검색 팝업
	function fn_searchSupplier(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url    = "../search/EpPubComInstListPopup.php";
		window.open(url, 'pubSupplierSrchPop', openParam);
	}

	//목록으로 이동
	function fn_movePubPaymentList(){
		history.go(-1);
	}

	function fn_goPage(exDocType) {

		var form = document.frm_pubPm_insert;
		
		form.exDocType.value = exDocType;
		
		form.action = "/ed/rcv/moveCtDocList.do";
		form.target = "_top";
		form.submit();
	}
	
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}

</script>
</head> 
<body id="body_admin">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
		<div class="top">
			<img src="../images/admin_top_agescom.jpg" alt="top">
		</div>
		<div class="gnb">
			<div id="language_select">	<ul class="horizontal_list">		<li><a href="/setLocale.do?lang=fr" target="_top">Fre</a></li>		<li><a href="/setLocale.do?lang=en" target="_top">Eng</a></li>		<li><a href="/setLocale.do?lang=ko" target="_top">Kor</a></li>	</ul></div>
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
					
					<li class="depth1_on">
						<p class="sline">Enregistrement</p> 
						<ul>
							<li class="depth2_on">
							  <p class="bullet">Commités/Comissions</p></li>
						</ul>
					</li>
					
					
					
<!--					<li class="depth1_none">
						<p class="sline">Liste</p>
						<ul>
									
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Commissions de passation des marches</a></li>
                                        <li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Commisstés de maturation</a></li>
                                        <li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Autres</a></li>
									
								
							
						</ul>
					</li>-->
					
					
				</ul>
			</div><!-- //menu END -->

			<div class="content" id="contents">
				<h1 class="h1_title">Enregistrer une Commission/Comité</h1>
				<div class="tableTy1">
					<div class="dataArea">
						<form id="RcvSVO" name="frm_pubPm_insert" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="type_commission_id" value="<?php echo isset($_REQUEST["typID"])?$_REQUEST["typID"]:"" ?>" />
                        <input type="hidden" name="commission_id" value="" />
                        <input type="hidden" name="user_id" value="" />
                        <input type="hidden" name="idStructure" id="idStructure" value="" />
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
								<caption>Enregistrer la Commission/Comité</caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: *">
								</colgroup>
								<tbody>
<tr valign="baseline">
                                                <th align="left" scope="row"><em class="pointTxt2">*</em>Type Commission</th>
                      <td class="style1"><select name="type_commission" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value=""  <?php if (!(strcmp("", 7))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php
                        do {  
                        ?>
                          <option value="<?php echo "commissionReg.php?typID=".$row_rsTypeCommission['type_commission_id']?>"<?php if (!(strcmp($row_rsTypeCommission['type_commission_id'], $_GET['typID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsTypeCommission['type_commission_lib']) ?></option>
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
                                    $showGoTo = "TypeCommissionAddPopop.php";
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
                        <div class="control"><img src="../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
                      <?php } ?></td>
                                  </tr>
                                              <?php if (isset($_GET['typID']) && ($_GET['typID'] == 3 || $_GET['typID'] == 4 || $_GET['typID'] == 5)){ ?>
                                              <tr valign="baseline">
                                               <th align="left" scope="row">Region</th>
                                                <td valign="middle" class="style5"><select name="menu1" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="commissionReg.php" <?php if (!(strcmp("commissionReg.php", $_GET['regID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php
                                do {  
                                ?>
                                                  <option value="<?php echo "commissionReg.php?typID=".$_GET['typID']."&regID=".$row_rsRegion['region_id']?>"<?php if (!(strcmp($row_rsRegion['region_id'], $_GET['regID']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRegion['region_lib']?></option>
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
                                    $showGoTo = "../add_regions.php";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
                                        $showGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                  ?>
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "250"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16"></a><a href="#" onClick="<?php popup($showGoTo, "710", "150"); ?>"></a>
                                                  <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($regionIsEmpty) { ?>
                                                  <div class="control"><img src="../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le type de la commission, SVP!</div>
                                                <?php } ?></td>
                                  </tr>
                                              <tr>
                                                <th align="left" scope="row">Departement:</th>
                                                <td valign="middle" class="style5"><select name="menu2" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="commissionReg.php" <?php if (!(strcmp("commissionReg.php", "depID"))) {echo "selected=\"selected\"";} ?>>Select::</option>
                                                  <?php do {  ?>
                                                  <option value="<?php echo "commissionReg.php?typID=".$_GET['typID']."&regID=".$_REQUEST['regID']."&depID=".$row_rsDepartements['departement_id']?>"<?php if (!(strcmp($row_rsDepartements['departement_id'], $_REQUEST["depID"]))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsDepartements['departement_lib']) ?> </option>
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
                                    $showGoTo = "../add_localites.php";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
                                        $showGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                  ?>
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "250"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16"></a><a href="#" onClick="<?php popup($showGoTo, "710", "350"); ?>"><?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($departementIsEmpty) { ?>
                                                  </a>
                                                  <div class="control"><img src="../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner le departement, SVP!</div>
                                                <?php } ?></td>
                                  </tr>
                                              <tr>
                                                <th align="left" scope="row">Localite:</th>
                                                <td valign="middle" class="style5"><select name="localite_id" class="style1" onChange="MM_jumpMenu('parent',this,0)">
                                                  <option value="commissionReg.php" <?php if (!(strcmp("commissionReg.php", $_GET['locID']))) {echo "selected=\"selected\"";} ?>>Select...</option>
                                                  <?php do {  ?>
                                                  <option value="<?php echo "commissionReg.php?typID=".$_GET['typID']."&regID=".$_REQUEST["regID"]."&depID=".$_REQUEST["depID"]."&locID=".$row_rsLocalites['localite_id']?>"<?php if (!(strcmp($row_rsLocalites['localite_id'], $_GET['locID']))) {echo "selected=\"selected\"";} ?>><?php echo strtoupper($row_rsLocalites['localite_lib']) ?></option>
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
                                    $showGoTo = "../add_localites.php";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
                                        $showGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                  ?>
                                                  <a href="#" onClick="<?php popup($showGoTo, "710", "250"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16"></a><a href="#" onClick="<?php popup($showGoTo, "710", "750"); ?>"><?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($localiteIsEmpty) { ?>
                                                  </a>
                                                <div class="control"><img src="../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la localite, SVP!</div></td>
                                  </tr>
                                              <?php } ?>
                                              <?php } ?>
                                              <tr valign="baseline">
                                                <th align="left" scope="row"><em class="pointTxt2">*</em>Nature Commission:</th>
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
                        
                                    $showGoTo = "AddNaturePopop.php";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
                                        $showGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                  ?>
                                                    <a href="#" onClick="<?php popup($showGoTo, "710", "250"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16"></a><a href="#" onClick="<?php popup($showGoTo, "710", "750"); ?>"><?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($natureIsEmpty) { ?>
                                                  </a></span>
                                                  <div class="control"><img src="../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la nature , SVP!</div>
                                                <?php } ?></td>
                                </tr>
									<tr>
										<th align="left" class="noLine tL" scope="row"><label for="bizRegNo"><em class="pointTxt2">*</em> Structure</label></th>
										<td>
										  <input type="text" class="text" id="instCd" style="width: 20%" name="instCd" readonly="readonly">
											&nbsp;<input type="text" class="text" id="instNm" style="width: 48%" name="instNm" readonly="readonly">
											<span class="btnTy3"><input type="button" class="btn" value="Rechercher" onClick="javascript:fn_searchSupplier();"></span><?php           
                                    //$showGoTo = "add_structures.php";
                                    $reg_id = isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
                                    $loc_id = isset($_REQUEST['locID'])?$_REQUEST['locID']:"79";
                                    $showGoTo = "showstructure.php?regID=". isset($_REQUEST['regID'])?$_REQUEST['regID']:"13";
                                    if (isset($_SERVER['QUERY_STRING'])) {
                                        $showGoTo .= (strpos($showGoTo, '?')) ? "&" : "?";
                                        $showGoTo .= $_SERVER['QUERY_STRING'];
                                    }
                                  ?>
                                        <a href="#" onClick="<?php popup(showGoTo.'&locID='.$loc_id, "710", "750"); ?>"><img src="../../images/img/b_snewtbl.png" width="16" height="16" /></a>
                                        <?php
                                    /** Display error messages if "user" field is empty or there is already a user with that name*/
                                    if ($structureIsEmpty) { ?>
                                        </span>
                                        <div class="control"><img src="../../images/img/b_comment.png" alt="" width="16" height="16" align="absmiddle" />Selectionner la structure de rattachement, SVP!</div>
                                        <?php } ?>
										</td>
									</tr>
									<tr align="left">
										<td style="display: none;">
											














<link rel="stylesheet" type="text/css" href="/css/common.css">
<link rel="stylesheet" type="text/css" href="/css/layout.css">
<link rel="stylesheet" type="text/css" href="/css/component.css">
<script type="text/javascript">

	var fileIndex = 0;
	/* ********************************************************
	 * 파일태그 추가
	 ******************************************************** */
	function fn_addFile(){
		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		// 파일은 3개까지
		if(tableLength >= 3){
			util_messageAlert("Vous ne pouvez pas joindre plus de 3 fichiers.");
			return;
		}

		// 기존에 추가된 파일태그에 값이 없으면 리턴
		for(var i = 1; i <= fileIndex; i++){

			var compareFileObj = document.getElementById("file" + i);

			if(compareFileObj != null &&
			   compareFileObj.value == ""){

				util_messageAlert("Selectionner le fichier existant.");
				return;
			}

		}
		fileIndex++;
		fn_addFileRow(fileIndex, tableLength);

	}

	/* ********************************************************
	 * 파일태그 추가(인텍스)
	 ******************************************************** */
	function fn_addFileRow(paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");
		var rowObj = tableObj.insertRow(tableIndex);
		var cellObj = rowObj.insertCell(0);
		cellObj.style.border = "0px";

		var htmlStr  = "<span class=\"btnTy3\"><input type=\"file\" style=\"width:450px; height:23px; background-color:#FBFAF2; border:1px solid #D9D0C1;\" id=\"file" 
										+ paramFileIndex + "\" name=\"file" + paramFileIndex + "\"  size=\"100\" onchange=\"javascript:fn_checkFileName(this, " 
												+ paramFileIndex + "," + tableIndex + ")\" style=\"width:80%\"></span>";
		       htmlStr += "&nbsp;&nbsp;<span class=\"btnTy3\"><input type=\"button\" class=\"btn\" onclick=\"javascript:fn_deleteFileRow(this.parentNode.parentNode.parentNode)\" value=\"Annuler\"></span>";
        cellObj.innerHTML = htmlStr;

	}

	/* ********************************************************
	 * 파일태그 삭제
	 ******************************************************** */
	function fn_deleteFileRow(trObj){

		var tableObj = document.getElementById("fileTable");
		var trIndex = trObj.sectionRowIndex;

		tableObj.deleteRow(trIndex);

	}

	/* ********************************************************
	 * 파일명 체크
	 ******************************************************** */
	function fn_checkFileName(fileObj, paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");

		var fileName = "";
		if(navigator.userAgent.indexOf("Firefox") > -1 ){

			fileName = fileObj.value;

		}else{

			var fileName = fileObj.value;
			fileName = fileName.substring(fileName.lastIndexOf("\\") + 1);

		}

		/*
		 * 중복파일 검색 시작
		 */
		// 기존에 추가된 파일태그에 값이 없으면 리턴
		for(var i = 1; i <= fileIndex; i++){

			var compareFileObj = document.getElementById("file" + i);

			if(compareFileObj != null){

				var compareFileObj = document.getElementById("file" + i);
				var compareFileName = "";
				if(navigator.userAgent.indexOf("Firefox") > -1 ){

					var compareFileName = compareFileObj.value;

				}else{

					var compareFileName = compareFileObj.value;
					compareFileName = compareFileName.substring(compareFileName.lastIndexOf("\\") + 1);

				}

				if(paramFileIndex != i &&
				   fileName == compareFileName){

					util_messageAlert("Le meme nom du fichier existe deja.");

					if(navigator.userAgent.indexOf("MSIE") > -1 ){
						fn_deleteFileRow(fileObj.parentNode.parentNode);
						fn_addFileRow(paramFileIndex, tableIndex);
					}else{
						fileObj.value = "";
					}

				}

			}

		}
		/*
		 * 중복파일 검색 끝
		 */

		/*
		 * 파일명 유효성 검증 시작
		 */
		var maskStr = "^[0-9|ㄱ-ㅎ|ㅏ-ㅣ|가-힝|+-|_|.| |()|'|À-ÿ]*$";
		var regPat = new RegExp(maskStr);
		var result = matchPattern(fileName, regPat);

		if(result == null){

			var checkMaskStr = unescape(replaceAll("Le nom du fichier est invalide. Les caractères valides sont comme suit:","\\","%"));
			var checkMaskStr = extractMaskStrs(maskStr, checkMaskStr);

			util_messageAlert(checkMaskStr);

			if(navigator.userAgent.indexOf("MSIE") > -1 ){
				fn_deleteFileRow(fileObj.parentNode.parentNode);
				fn_addFileRow(paramFileIndex, tableIndex);
			}else{
				fileObj.value = "";
			}
		}
		/*
		 * 파일명 유효성 검증 끝
		 */

	}

	/* ********************************************************
	 * 선택하지 않은 파일이 있는지 확인
	 ******************************************************** */
	function fn_checkSelectedFile(){

		var result = true;
		
		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		if(tableLength == 0){
			util_messageAlert("Bien vouloir joindre la quittance.");
			return false;
		}

		for(var i = 0; i <= fileIndex;i++){

			var fileObj = document.getElementById("file" + i);
			if(fileObj != null &&
			   fileObj.value == ""){
				util_messageAlert("Bien vouloir joindre la quittance.", fileObj);
				return false;
			}

		}

		return result;

	}
	
	/* ********************************************************
	 * 초기화
	 ******************************************************** */
	function fn_initFiles(){

		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		for(var i = tableLength - 1; i >= 0; i--){
			tableObj.deleteRow(i);
		}

		fileIndex = 0;

	}

</script>

</td></tr><tr>
	<th align="left" class="tL">
		<label class="article_label">
		<em class="pointTxt2">*</em> 
			Fichier attaché
		</label>
	</th>
	<td><span class="btnTy3">
	  <input type="button" class="btn" onClick="javascript:fn_addFile()" value="Ajouter fichier">
	</span>
	  <table name="fileTable" id="fileTable" class="file_table">
		</table>
		<br>
		Vous ne pouvez que télécharger trois (03) fichiers au maximum. La taille de chaque fichier doit être de 4Mo au plus.
	</td>
</tr>


										
									
								</tbody>
							</table>
						</form>
					</div>
				</div>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="Envoyer" onClick="javascript:fn_insertPubPayment();"></span>
					<span class="btnTy21"><input type="button" class="btn" value="Retour" onClick="javascript:fn_movePubPaymentList();"></span>
				</div>
			</div><!-- //content END -->
			    <div id="copy_w">
        <p class="fL">&nbsp;</p>
        <p class="fL ml20">&nbsp;</p>
        <p class="fR mt15"><img src="images/main/copylight.gif" alt="Copyright (C) 2014 Soft I Tech. All Rights Reserved."></p>
    </div>
<script type="text/javaScript" language="javascript">

    if ((navigator.userAgent.indexOf('MSIE 6')>0) && (navigator.userAgent.indexOf('MSIE 7')==-1)){

        util_messageAlertWithExec("Il se peut que les pages ne fonctionnent pas correctement sous l'environnement Internet Explorer 6 et 7. Veuillez mettre à jour votre navigateur au dessus d’IE 8 ou utiliser d'autres navigateurs tels que Chrome, Firefox.", "fn_moveMain()");

		   function fn_moveMain(){
		       location.href='http://179.18.0.96/'
		   }
    }

</script>

		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div><!-- //main END -->

</body></html>