<%--
 /**
  * @Description : 입찰공고서대금 프레임 조회 : PubPayment Frame
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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><l:mapping programId="PubPayment" objId="title"></l:mapping></title>
<link rel="stylesheet" href="<c:url value='/css/common.css'></c:url>" media="all">
<link rel="stylesheet" href="<c:url value='/css/sub.css'></c:url>" media="all">
<script type="text/javascript" src="${contextPath}js/common/font.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alert.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alertExms.js"></script>
<script type="text/javascript" src="${contextPath}js/common/pagination.js"></script>
<script type="text/javascript" src="${contextPath}js/common/frame.js"></script>
<script type="text/javascript" src="${contextPath}js/common/ajax.js"></script>
<script type="text/javascript" src="${contextPath}js/common/event.js"></script>
<c:out value="${commonScript}" escapeXml="false"></c:out>
<script type="text/javaScript" language="javascript">
	
	function fn_onLoad(){
		util_hideExecutionAll(parent.document);
		util_resizeFrame("PubPaymentFrame");
		util_initCompSearchConditions('frm_pubPayment');
	}
	
	//상세화면 이동 처리 함수 :: 
	function fn_movePubPaymentDetail(bidNo, exDocType, bidModSeq, bizRegNo){
		var form = parent.document.frm_pubPayment;
		form.bidNo.value = bidNo;
		form.exDocType.value = exDocType;
		form.bidModSeq.value = bidModSeq;
		form.bizRegNo.value = bizRegNo;
		form.target = "_top";
		form.action = "<c:url value='/ed/rcv/movePubPaymentDetail.do'></c:url>";
		form.submit();
	}

</script>
</head>
<body onload="javascript:fn_onLoad()">
<div id="frameDiv">
<!-- <div class="content"> -->
	<div class="tableTy1">
		<form:form name="frm_pubPayment_list" modelAttribute="RcvSVO" method="post">
			<table class="data rowEven">
				<caption><l:mapping programId="PubPayment" objId="DBF"></l:mapping></caption>
				<colgroup>
					<col style="width: 17%">
					<col style="width: 30%">
					<col style="width: 18%">
					<col style="width: 15%">
					<col style="width: 20%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><l:mapping programId="PubPaymentFrame" objId="bidNo"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubPaymentFrame" objId="bidNm"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubPaymentFrame" objId="guarBidAmt"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubPaymentFrame" objId="supplierNm"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubPaymentFrame" objId="regDate"></l:mapping></th>
					</tr>
				</thead>
				<tbody>
					<c:forEach items="${RcvSVO.rcvQVOList}" var="resultInfo" varStatus="status">
						<tr>
							<td class="tC"><a href="#" onclick="javascript:fn_movePubPaymentDetail('${resultInfo.bidNo}','${resultInfo.exDocType}','${resultInfo.bidModSeq}','${resultInfo.bizRegNo }');">${resultInfo.bidNo}-${resultInfo.bidModSeq}</a></td>
							<td class="tL">${resultInfo.bidNm}</td>
							<td class="tR"><l:number caliberValue="${resultInfo.guarBidAmt}"></l:number>&nbsp;${resultInfo.guarBidCurr}</td>
							<td class="tL">${resultInfo.supplierNm}</td>
							<td class="tC"><l:date dateValue="${resultInfo.regDt}"></l:date></td>
						</tr>
					</c:forEach>
					<c:if test="${RcvSVO.totalRecordCount <= 0}">
						<tr>
							<td colspan="5" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></l:mapping></td>
						</tr>
					</c:if>
				</tbody>
			</table>
		</form:form>
	</div>

	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${RcvSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_pubPayment" listURL="/ed/rcv/selectListPubPayment.do" paginationInfo="${RcvSVO}" target="PubPaymentFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>