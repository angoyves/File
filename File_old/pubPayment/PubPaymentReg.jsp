<%--
 /**
  * @Description : 입찰공고서대금 등록 : Insert PubPayment
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
<validator:javascript formName="frm_pubPm_insert" staticJavascript="false" xhtml="true" cdata="false"></validator:javascript>
<script type="text/javascript" src="${contextPath}js/common/font.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alert.js"></script>
<script type="text/javascript" src="${contextPath}js/common/pagination.js"></script>
<script type="text/javascript" src="${contextPath}js/common/validation.js"></script>
<script type="text/javascript" src="${contextPath}js/common/frame.js"></script>
<script type="text/javascript" src="${contextPath}js/common/ajax.js"></script>
<script type="text/javascript" src="${contextPath}js/common/string.js"></script>
<script type="text/javascript" src="${contextPath}js/common/event.js"></script>
<script type="text/javascript">

	//로그아웃
	function fn_logOut(){
		util_confirmAlert("<l:mapping programId="exms_common" objId="confirm_logout"></l:mapping>", "submitLogout()");
	}
	function submitLogout(){
		window.top.location.href = "<c:url value='/ed/user/logOut.do'></c:url>";
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
			util_confirmAlert("<l:mapping programId="PubPaymentReg" objId="bidNo"></l:mapping> [" + form.bidNo.value + "-" + form.bidModSeq.value +"] " 
					+ "<l:mapping programId="COMMON" objId="common_save_msg_dbf"></l:mapping>" ,"fn_submitInsertPubPayment()");
		}
	 	
	 }
	
	 //Form Submit
	 function fn_submitInsertPubPayment(){
	
		 var form = document.frm_pubPm_insert;
		
		 //처리중 이미지 만들기
		 util_showExecutionImage();
		
		 form.action = "<c:url value='/ed/rcv/insertPubPayment.do'></c:url>";
		 form.target = "ResultFrame";
		 form.submit();
	 }
 
	//입찰공고번호 검색 팝업
	function fn_searchBidNo(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url = "<c:url value='/ed/rcv/pubPaymentSrchListPopup.do'></c:url>";
		window.open(url, 'pubBidSrchPop', openParam);
	}
	
	//조달업체 검색 팝업
	function fn_searchSupplier(){
		var openParam = "width=750px,height=600px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		var url    = "<c:url value='/ed/rcv/pubSupplierSrchPopup.do'></c:url>";
		window.open(url, 'pubSupplierSrchPop', openParam);
	}

	//목록으로 이동
	function fn_movePubPaymentList(){
		history.go(-1);
	}

	function fn_goPage(exDocType) {

		var form = document.frm_pubPm_insert;
		
		form.exDocType.value = exDocType;
		
		form.action = "<c:url value='/ed/rcv/moveCtDocList.do'></c:url>";
		form.target = "_top";
		form.submit();
	}

</script>
</head> 
<body  id="body_admin">
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
				<h1 class="h1_title"><l:mapping programId="PubPaymentReg" objId="title"></l:mapping></h1>
				<div class="tableTy1">
					<div class="dataArea">
						<form:form name="frm_pubPm_insert" modelAttribute="RcvSVO" method="post" encType="multipart/form-data">
						<input type="hidden" name="bidLot" value="NON" >
							<table class="data">
								<caption><l:mapping programId="PubPaymentReg" objId="title"></l:mapping></caption>
								<colgroup>
									<col style="width: 20%">
									<col style="width: *">
								</colgroup>
								<tbody>
									<tr>
										<th scope="row" class="noLine tL"><em class="pointTxt2" >*</em> <l:mapping programId="PubPaymentReg" objId="exDocType"></l:mapping></th>
										<td><l:mapping programId="PubPaymentReg" objId="DBF"></l:mapping><input type="hidden" name="exDocType" value="DBF"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bidNo"><em class="pointTxt2">*</em> <l:mapping programId="PubPaymentReg" objId="bidNo"></l:mapping></label></th>
										<td>
											<input type="text" class="text"  id="bidNo" style="width: 48%" name="bidNo" readonly="readonly">&nbsp;<input type="text" class="text"  id="bidModSeq" style="width: 20%" name="bidModSeq" readonly="readonly">
											<span class="btnTy3"><input type="button" class="btn" value="<l:mapping programId="PubPaymentReg" objId="srchBtn"></l:mapping>" onclick="javascript:fn_searchBidNo();"></span>
										</td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bidNm"><l:mapping programId="PubPaymentReg" objId="bidNm"></l:mapping></label></th>
										<td><input type="text" class="text"  id="bidNm" style="width: 70%" name="bidNm" readonly="readonly"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="guarBidAmt"><l:mapping programId="PubPaymentReg" objId="guarBidAmt"></l:mapping></label></th>
										<td><input type="text" class="text"  id="guarBidAmt" style="width: 20%" name="guarBidAmt" readonly="readonly">&nbsp;<input type="text" class="text"  id="guarBidCurr" style="width: 10%" name="guarBidCurr" readonly="readonly"></td>
									</tr>
									<tr>
										<th scope="row" class="noLine tL"><label for="bizRegNo"><em class="pointTxt2">*</em> <l:mapping programId="PubPaymentReg" objId="supplierNm"></l:mapping></label></th>
										<td>
											<input type="text" class="text"  id="bizRegNo" style="width: 20%" name="bizRegNo" readonly="readonly">
											&nbsp;<input type="text" class="text"  id="supplierNm" style="width: 48%" name="supplierNm" readonly="readonly">
											<span class="btnTy3"><input type="button" class="btn" value="<l:mapping programId="PubPaymentReg" objId="srchBtn"></l:mapping>" onclick="javascript:fn_searchSupplier();"></span>
										</td>
									</tr>
									<tr>
										<td style="display: none;">
											<jsp:include page="/WEB-INF/jsp/com/FileUpDnInsert.jsp" flush="false"></jsp:include>
										</td>
									</tr>
								</tbody>
							</table>
						</form:form>
					</div>
				</div>
				<div class="fR pt10 mb20">
					<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="PubPaymentReg" objId="insertPubPayment"></l:mapping>" onclick="javascript:fn_insertPubPayment();"></span>
					<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="PubPaymentReg" objId="cancelBtn"></l:mapping>" onclick="javascript:fn_movePubPaymentList();"></span>
				</div>
			</div><!-- //content END -->
			<c:out value="${footer}" escapeXml="false"></c:out>
		</div><!-- //con_wrap END -->
	</div><!-- //wrap END -->
</div><!-- //sitewrap END -->
<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</div><!-- //main END -->
</body>
</html>