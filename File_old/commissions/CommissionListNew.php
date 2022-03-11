<?php require('../includes/db.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
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
<script type="text/javascript" src="../js/common/date.js"></script>
<script type="text/javaScript" language="javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("Etes-vous sur de vouloir déconnecter?", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "../CtrL/UserLogOutCtrl.php?doLogout=true";
	}
	
	//등록화면으로 이동
	function fn_movePubCommissionInsert(){
		var form = document.frm_pubCommission;
		form.action = "CommissionReg.php";
		form.target = "_top";
		form.submit();
	}
	function fn_movePubCommissionInsert2(){
		var form = document.frm_pubCommission;
		form.action = "Sanstitre.php";
		form.target = "_top";
		form.submit();
	}
	
	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPagePubPayment();
	}
	
	//조회 처리 함수 :: Query processing function
	function fn_selectListPagePubPayment(){
		var form = document.frm_pubCommission;
		
		util_showExecutionImage();
		
		//상세, 수정에서 온 경우
		/*if(form.isBack.value == "Y"){
			util_initFormValue(form.childNodes, form.searchConditions.value);
		} else {
			form.currentPageNo.value = 1;
		}*/
		
		//trim 처리
		//form.bidNo.value = form.bidNoTemp.value.trim();
		form.action = "CommissionListFrameNew.php";
		form.target = "PubCommissionFrame";
		form.submit();
		
		/*if(!validatefrm_pubCommission(form)){
			return;
		} else {
			form.submit();
		}*/
	}
	
	function fn_goPage(exDocType) {

		var form = document.frm_pubCommission;
		
		form.exDocType.value = exDocType;
		
		form.action = "<c:url value='/ed/rcv/moveCtDocList.do'></c:url>";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body id="body_admin" onLoad="javascript:fn_onLoad()">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
		<div class="top">
			<img src="../images/admin_top_agescom.jpg" alt="top">
		</div>
		<!--<div class="gnb">
			${ExmsLangCodeSelectDivStr}
		</div>-->
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
                          <p class="sline">Commissions/Comités</p>
                          <ul>
                            <li class="depth2_on"><p class="bullet"><a href="../commissions/CommissionListNew.php">Liste des Commissions</a></p></li>
                            <li class="depth2"><a href="../commissions/CommissionListNew.php">Liste des Comites</a></li>
                          </ul>
                        </li>
                        <li class="depth1_none">
                          <p class="sline">Membres </p>
                          <ul>
                            
                            <li class="depth2"><a href="../membres/membre.php">Liste Membres</a></li>
                            <li class="depth2"><a href="#" onClick="javascript:fn_goPage('ETC')">Autres</a></li>
                          </ul>
                        </li> 
					<!--<c:if test="${userAuth eq 'M' }">-->
					<!--<li class="depth1_on"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth2"></l:mapping></p> 
						<ul>
							<li class="depth2_on"><p class="bullet"><a href="/ed/rcv/movePubPaymentList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth2_1"></l:mapping> </a></p></li>
						</ul>
					</li>
					</c:if>
					<c:if test="${userAuth eq 'B' }">
					<li class="depth1_on"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth3"></l:mapping> </p>
						<ul>
							<li class="depth2"><a href="/ed/rcv/moveBidDepositList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth3_1"></l:mapping> </a></li>
						</ul>
					</li>-->
					<!--</c:if>-->
					<!--<c:if test="${userAuth ne 'A'}">-->
					<!--<li class="depth1_none"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth4"></l:mapping> </p>
						<ul>
							<c:forEach items="${exDocMenu }" var="resultList" varStatus="vs">
								<c:choose>
									<c:when test="${userAuth eq 'I' && (resultList.cd eq 'TAX' || resultList.cd eq 'TCD' || resultList.cd eq 'BLC') }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'G' && (resultList.cd eq 'BRC' || resultList.cd eq 'FIR') }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'C' && (resultList.cd eq 'CNP') }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'R' && (resultList.cd eq 'LAW') }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'B' && (resultList.cd eq 'ASC' || resultList.cd eq 'CFC' || resultList.cd eq 'CDB') }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${resultList.cd eq 'ETC' }">
										<li class="depth2"><a href="#" onClick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
								</c:choose>
							</c:forEach>
						</ul>
					</li>-->
					<!--</c:if>-->
					<!--<c:if test="${userAuth=='A' }">
						<li class="depth1_none"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth5"></l:mapping> </p>
							<ul>
								<li class="depth2"><a href="/ed/master/moveLangList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_1"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveMappingInfoList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_2"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveCodeTypeList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_3"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveCodeList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_4"></l:mapping> </a></li>
							</ul>
						</li>
					</c:if>-->
				</ul>
			</div><!-- //menu END -->
			
			<div class="content" id="contents">
				<h1 class="h1_title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'title'); ?></h1>
  <form name="frm_pubCommission" method="post" id="frm_pubCommission">
					<div class="tableTy2">
						<div class="dataArea">
						  <input type="hidden" name="searchConditions" value="$_POST['searchConditions']">
						  <input type="hidden" name="currentPageNo" value="$_POST['currentPageNo']">
						  <input type="hidden" name="isBack" value="$_POST['isBack']">
						  <input type="hidden" name="bidNo" value="$_POST['bidNo']">
						  <input type="hidden" name="bidModSeq" value="$_POST['bidModSeq']">
							<input type="hidden" name="exDocType" />
						  <input type="hidden" name="bizRegNo" value="$_POST['bizRegNo']">
							
			  <table class="data">
								<caption><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'title'); ?> </caption>
								<colgroup>
									<col style="width: 30%">
									<col style="width: *">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine"><label for="bidNoTemp"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'commissionSigle'); ?></label></th>
										<td><!--<input type="text" class="text"  style="width: 80%" id="bidNoTemp" name="bidNoTemp" maxlength="11">-->
                                        <input type="text" class="text"  style="width: 30%" id="commission_sigle" name="commission_sigle" maxlength="11"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine"><label for="bidNm"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'commissionLib'); ?> </label></th>
										<td><!--<input type="text" class="text"  style="width: 80%" name="bidNm" id="bidNm" maxlength="200">-->
                                        <input type="text" class="text"  style="width: 80%" name="commissionLib" id="commissionLib" maxlength="200"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				<div class="fR mt15 mb20">
						<select name="recordCountPerPage" id="recordCountPerPage" class="article_selectbox">
							<option value="10">
								<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_10result_text'); ?>
							</option>
							<option value="20">
								<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_20result_text'); ?> 
							</option>
							<option value="30">
								<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_30result_text'); ?> 
							</option>
							<option value="50">
								<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'COMMON', $ObjId = 'common_50result_text'); ?> 
							</option>
						</select>
						<span class="btnTy3"> <input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'srchBtn'); ?> " onClick="javascript:fn_selectListPagePubPayment();"></span>
				  </div>
		      <iframe name="PubCommissionFrame" id="PubCommissionFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
		  </form>
				<div class="fR pt10 mb20">
				  <span class="btnTy21"><input type="button" class="btn" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'PubCommission', $ObjId = 'insertPubCommission'); ?> " onClick="javascript:fn_movePubCommissionInsert();"></span>
				</div>
			</div><!-- //content END -->
			<c:out value="${footer}" escapeXml="false"></c:out>
		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->
</body>
</html>