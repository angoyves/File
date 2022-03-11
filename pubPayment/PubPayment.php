<%--
 /**
  * @Description : 입찰공고서대금 조회 : PubPayment List
  * @Modification Information
  * @
  * @   수정일       수정자            수정내용
  * @ ----------    --------    -----------------------
  * @ 2014.10.28     남하늬            초기작성
  *
  */
--%>

<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file="/WEB-INF/jsp/com/TagLibraries.jsp" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>External-Linkage System for the receipt and certificate</title>
<link rel="stylesheet" href="../css/common.css" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
<validator:javascript formName="frm_pubPayment" staticJavascript="false" xhtml="true" cdata="false"></validator:javascript>
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
		util_confirmAlert("<l:mapping programId="exms_common" objId="confirm_logout"></l:mapping>", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "<c:url value='/ed/user/logOut.do'></c:url>";
	}
	
	//등록화면으로 이동
	function fn_movePubPaymentInsert(){
		var form = document.frm_pubPayment;
		form.action = "<c:url value='/ed/rcv/movePubPaymentReg.do'></c:url>";
		form.target = "_top";
		form.submit();
	}
	
	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPagePubPayment();
	}
	
	//조회 처리 함수 :: Query processing function
	function fn_selectListPagePubPayment(){
		var form = document.frm_pubPayment;
		
		util_showExecutionImage();
		
		//상세, 수정에서 온 경우
		if(form.isBack.value == "Y"){
			util_initFormValue(form.childNodes, form.searchConditions.value);
		} else {
			form.currentPageNo.value = 1;
		}
		
		//trim 처리
		form.bidNo.value = form.bidNoTemp.value.trim();
		form.action = "<c:url value='/ed/rcv/selectListPubPayment.do'></c:url>";
		form.target = "PubPaymentFrame";
		
		if(!validateFrm_pubPayment(form)){
			return;
		} else {
			form.submit();
		}
	}
	
	function fn_goPage(exDocType) {

		var form = document.frm_pubPayment;
		
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
			<img src="../images/admin_top.jpg" alt="top">
		</div>
		<div class="gnb">
			${ExmsLangCodeSelectDivStr}
		</div>
		<div class="con_wrap">
			<div class="menu">
				<ul>
					<li class="depth1_on"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth1"></l:mapping></p> 
						<ul>
							<li class="depth2"><a href="javascript:fn_logOut();"><l:mapping programId="exms_leftMenu" objId="menu_depth1_1"></l:mapping> </a></li>
							<c:if test="${userAuth=='A' }">
							<li class="depth2"><a href="/ed/user/moveUser.do"><l:mapping programId="exms_leftMenu" objId="menu_depth1_2"></l:mapping> </a></li>
							</c:if>
							<li class="depth2"><a href="/ed/user/moveUserDetail.do"><l:mapping programId="exms_leftMenu" objId="menu_depth1_3"></l:mapping> </a></li>
						</ul>
					</li>
					<c:if test="${userAuth eq 'M' }">
					<li class="depth1_on"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth2"></l:mapping></p> 
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
					</li>
					</c:if>
					<c:if test="${userAuth ne 'A'}">
					<li class="depth1_none"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth4"></l:mapping> </p>
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
					</li>
					</c:if>
					<c:if test="${userAuth=='A' }">
						<li class="depth1_none"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth5"></l:mapping> </p>
							<ul>
								<li class="depth2"><a href="/ed/master/moveLangList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_1"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveMappingInfoList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_2"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveCodeTypeList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_3"></l:mapping> </a></li>
								<li class="depth2"><a href="/ed/master/moveCodeList.do"><l:mapping programId="exms_leftMenu" objId="menu_depth5_4"></l:mapping> </a></li>
							</ul>
						</li>
					</c:if>
				</ul>
			</div><!-- //menu END -->
			
			<div class="content" id="contents">
				<h1 class="h1_title"><l:mapping programId="PubPayment" objId="title"></l:mapping> </h1>
				<form:form name="frm_pubPayment" modelAttribute="RcvSVO" method="post" id="frm_pubPayment">
					<div class="tableTy2">
						<div class="dataArea">
							<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
							<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
							<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
							<input type="hidden" name="bidNo" value="${RcvSVO.bidNo}">
							<input type="hidden" name="bidModSeq" value="${RcvSVO.bidModSeq}">
							<input type="hidden" name="exDocType" />
							<input type="hidden" name="bizRegNo" value="${RcvSVO.bizRegNo}">
							
							<table class="data">
								<caption><l:mapping programId="PubPayment" objId="title"></l:mapping> </caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: *">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine"><label for="bidNoTemp"><l:mapping programId="PubPayment" objId="bidNo"></l:mapping> </label></th>
										<td><input type="text" class="text"  style="width: 80%" id="bidNoTemp" name="bidNoTemp" maxlength="11"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine"><label for="bidNm"><l:mapping programId="PubPayment" objId="bidNm"></l:mapping> </label></th>
										<td><input type="text" class="text"  style="width: 80%" name="bidNm" id="bidNm" maxlength="200"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine"><label for="supplierNm"><l:mapping programId="PubPayment" objId="supplierNm"></l:mapping> </label></th>
										<td><input type="text" class="text"  style="width: 80%" name="supplierNm" id="supplierNm"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine"><label for="startDateStr"><l:mapping programId="PubPayment" objId="regDate"></l:mapping> </label></th>
										<td class="period">
											<input type="text" name="startDateStr" id="startDateStr" class="article100_text" maxlength="8" style="width:65px" value="<l:date dateValue='${RcvSVO.startDate }'></l:date>"
														onkeydown="javascript:util_checkNumber(this, event)" onFocus="javascript:util_setDateFormat(this)"
														onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																		util_checkObjDayWithHidden(this, document.frm_pubPayment.startDate, document.frm_pubPayment.endDateStr, 'before',valiNoMatchDateMsg)">
											<input type="hidden" name="startDate" id="startDate" value="${RcvSVO.startDate}">
											<a href="#"><img src="<c:url value='../images/common/ico_calendar.gif'></c:url>" 
												class="pl5 vM"
												onclick="javascript:Calendar_D(document.frm_pubPayment.startDateStr, document.frm_pubPayment.startDate);return false;" alt="calendar"></a>
											~
											<input type="text" name="endDateStr" id="endDateStr" class="article100_text" maxlength="8" style="width:65px" value="<l:date dateValue='${RcvSVO.endDate }'></l:date>"
														onkeydown="javascript:util_checkNumber(this, event)" onFocus="javascript:util_setDateFormat(this)"
														onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																	util_checkObjDayWithHidden(this, document.frm_pubPayment.endDate, document.frm_pubPayment.startDateStr, 'after', valiNoMatchDateMsg)">
											<input type="hidden" name="endDate"  id="endDate" value="${RcvSVO.endDate}">  <a href="#"><img src="<c:url value='../images/common/ico_calendar.gif'></c:url>"
														class="pl5 vM" onClick="javascript:Calendar_D(document.frm_pubPayment.endDateStr, document.frm_pubPayment.endDate);return false;" alt="calendar"></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="fR mt15 mb20">
						<form:select path="recordCountPerPage" cssClass="article_selectbox">
							<form:option value="10">
								<l:mapping objId="common_10result_text" programId="COMMON"></l:mapping>
							</form:option>
							<form:option value="20">
								<l:mapping objId="common_20result_text" programId="COMMON"></l:mapping>
							</form:option>
							<form:option value="30">
								<l:mapping objId="common_30result_text" programId="COMMON"></l:mapping>
							</form:option>
							<form:option value="50">
								<l:mapping objId="common_50result_text" programId="COMMON"></l:mapping>
							</form:option>
						</form:select>
						<span class="btnTy3"> <input type="button" class="btn" value="<l:mapping programId="PubPayment" objId="srchBtn"></l:mapping> " onclick="javascript:fn_selectListPagePubPayment();"></span>
					</div>
					<iframe name="PubPaymentFrame" id="PubPaymentFrame" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
				</form:form>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="PubPayment" objId="insertPubPayment"></l:mapping> " onclick="javascript:fn_movePubPaymentInsert();"></span>
				</div>
			</div><!-- //content END -->
			<c:out value="${footer}" escapeXml="false"></c:out>
		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->
</body>
</html>