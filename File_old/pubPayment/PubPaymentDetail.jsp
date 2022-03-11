<%--
 /**
  * @Description : 입찰공고서대금 상세 조회 : PubPayment Detail
  * @Modification Information
  * @
  * @   수정일       수정자            수정내용
  * @ ----------    --------    -----------------------
  * @ 2014.10.28     남하늬            초기작성
  *
  */
--%>

<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ include file ="/WEB-INF/jsp/com/TagLibraries.jsp" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>External-Linkage System for the receipt and certificate</title>
<link rel="stylesheet" href="/css/common.css" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
<script type="text/javascript" src="${contextPath}js/common/font.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alert.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alertExms.js"></script>
<script type="text/javascript" src="${contextPath}js/common/pagination.js"></script>
<script type="text/javascript" src="${contextPath}js/common/string.js"></script>
<script type="text/javascript" src="${contextPath}js/common/prototype.js"></script>
<script type="text/javascript" src="${contextPath}js/common/calendar.js"></script>
<script type="text/javascript" src="${contextPath}js/common/event.js"></script>
<script type="text/javascript" src="${contextPath}js/common/ajax.js"></script>
<script type="text/javascript" src="${contextPath}js/common/validation.js"></script>
<script type="text/javascript" src="${contextPath}js/common/file.js"></script>
<script type="text/javaScript" language="javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("<l:mapping programId="exms_common" objId="confirm_logout"></l:mapping>", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "<c:url value='/ed/user/logOut.do'></c:url>";
	}

	// 리스트 화면 처리 함수 :: List processing functions, screen
	function fn_moveList(){
		var form = document.frm_pubPayment_detail;
		form.isBack.value ="Y";
		form.target = "_top";
		form.action = "<c:url value='/ed/rcv/movePubPaymentList.do'></c:url>";
		form.submit();
	}

	function fn_goPage(exDocType) {

		var form = document.frm_pubPayment_detail;
		
		form.exDocType.value = exDocType;
		
		form.action = "<c:url value='/ed/rcv/moveCtDocList.do'></c:url>";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body id = "body_admin">
<div id="main">
<div id="sitewrap">
	<div id="wrap">
		<div class="top">
			<img src="/images/admin_top.jpg" alt="top">
		</div>
		<div class="gnb">
			${ExmsLangCodeSelectDivStr}
		</div>
		<div class="con_wrap">
			<div class="menu">
				<ul>
					<li class="depth1_on"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth1"></l:mapping> </p>
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
					<c:if test="${userAuth ne 'A' }">
					<li class="depth1_none"><p class="sline"><l:mapping programId="exms_leftMenu" objId="menu_depth4"></l:mapping> </p>
						<ul>
							<c:forEach items="${exDocMenu }" var="resultList" varStatus="vs">
								<c:choose>
									<c:when test="${userAuth eq 'I' && (resultList.cd eq 'TAX' || resultList.cd eq 'TCD' || resultList.cd eq 'BLC') }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'G' && (resultList.cd eq 'BRC' || resultList.cd eq 'FIR') }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'C' && (resultList.cd eq 'CNP') }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'R' && (resultList.cd eq 'LAW') }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${userAuth eq 'B' && (resultList.cd eq 'ASC' || resultList.cd eq 'CFC' || resultList.cd eq 'CDB') }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
									</c:when>
									<c:when test="${resultList.cd eq 'ETC' }">
										<li class="depth2"><a href="#" onclick="javascript:fn_goPage('${resultList.cd}')">${resultList.cdNmStr }</a></li>
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
				<h1 class="h1_title"><l:mapping programId="PubPaymentDetail" objId="title"></l:mapping></h1>
				<h2 class="bullet1"><l:mapping programId="PubPaymentDetail" objId="1stSubtitle"></l:mapping></h2>
				<form:form name="frm_pubPayment_detail" modelAttribute="RcvSVO" method="post">
					<div class="tableTy1">
						<div class="dataArea">
							<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
							<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
							<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
							<input type="hidden" name="bidNo" value="${RcvSVO.bidNo}">
							<input type="hidden" name="exDocType" />
							<table class="data">
								<caption><l:mapping programId="PubPaymentDetail" objId="1stSubtitle"></l:mapping></caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: 80%">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="exDocType"></l:mapping></th>
										<td>
										<c:choose>
											<c:when test="${RcvSVO.exDocType == 'DBF'}">
				                      			<l:mapping programId="PubPaymentDetail" objId="DBF"></l:mapping>
				                      		</c:when>
										</c:choose>
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="bidNo"></l:mapping></th>
										<td><c:out value="${RcvSVO.bidNo}" escapeXml="true"></c:out>-<c:out value="${RcvSVO.bidModSeq}" escapeXml="true"></c:out></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="bidNm"></l:mapping></th>
										<td><c:out value="${RcvSVO.bidNm}" escapeXml="true"></c:out></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="guarBidAmt"></l:mapping></th>
										<td><l:number caliberValue="${RcvSVO.guarBidAmt}"></l:number>&nbsp;<c:out value="${RcvSVO.guarBidCurr}" escapeXml="true"></c:out></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="supplierNm"></l:mapping></th>
										<td><c:out value="${RcvSVO.supplierNm}" escapeXml="true"></c:out></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="bizRegNo"></l:mapping></th>
										<td><c:out value="${RcvSVO.bizRegNo}" escapeXml="true"></c:out></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><l:mapping programId="PubPaymentDetail" objId="regDate"></l:mapping></th>
										<td><l:date dateValue="${RcvSVO.regDt}"></l:date></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<h2 class="bullet1 mt20"><l:mapping programId="PubPaymentDetail" objId="2ndSubtitle"></l:mapping></h2>
					<div class="tableTy1">
						<table class="data">
							<caption><l:mapping programId="PubPaymentDetail" objId="2ndSubtitle"></l:mapping></caption>
							<colgroup>
								<col style="width: 15%">
								<col style="width: 35%">
								<col style="width: 50%">
							</colgroup>
							<thead>
								<tr>
									<th scope="col"><l:mapping programId="PubPaymentDetail" objId="rowNum"></l:mapping></th>
									<th scope="col"><l:mapping programId="PubPaymentDetail" objId="exDocTypeNm"></l:mapping></th>
									<th scope="col"><l:mapping programId="PubPaymentDetail" objId="exDocTypePath"></l:mapping></th>
								</tr>
							</thead>
							<tbody>
								<c:forEach items="${attachList}" var="attachList" varStatus="status">
									<tr>
										<td class="tC"><c:out value="${attachList.seqNo}" escapeXml="true"></c:out></td>
										<td class="tC">
										<c:choose>
											<c:when test="${RcvSVO.exDocType == 'DBF'}">
				                       			<l:mapping programId="PubPaymentDetail" objId="DBF"></l:mapping>
				                       		</c:when>
										</c:choose>
										</td>
										<td class="tC">
											<a href="#" onclick="javascript:util_downloadFileByFullPath(&quot;<c:url value='/'></c:url>&quot;,&quot;${attachList.fileLoc}&quot;+&quot;${attachList.fileNm}&quot;,&quot;${attachList.fileNm}&quot;); return false;"><c:out value="${attachList.fileNm}" escapeXml="true"></c:out></a>
											<iframe name="attachFileFrame" width="0" height="0" frameborder="0"></iframe>
										</td>
									</tr>
								</c:forEach>
								<c:if test="${empty attachList}">
									<tr>
										<td colspan="3" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></l:mapping></td>
									</tr>
								</c:if>
							</tbody>
						</table>
					</div>
				</form:form>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="PubPaymentDetail" objId="listBtn"></l:mapping>" onClick="javascript:fn_moveList();"></span>
				</div>
			</div><!-- //content END -->
			<c:out value="${footer}" escapeXml="false"></c:out>
		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
</div><!-- //main END -->
</body>
</html>