<%--
 /**
  * @Description : 입찰공고 프레임 조회 (popup) : Bid Search Frame (popup) 
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
<title><l:mapping programId="PubSrchPopup" objId="title"></l:mapping></title>
<link rel="stylesheet" href="<c:url value='/css/common.css'></c:url>" media="all">
<link rel="stylesheet" href="<c:url value='/css/sub.css'></c:url>" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
<script type="text/javascript" src="${contextPath}js/common/font.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alert.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alertExms.js"></script>
<script type="text/javascript" src="${contextPath}js/common/validation.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/frame.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/ajax.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/string.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/prototype.js"></script>
<script type="text/javascript" src="${contextPath}js/common/event.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/pagination.js"></script>
<script type="text/javascript" src="${contextPath}js/common/calendar.js"></script>
<script type="text/javascript" src="${contextPath}js/common/date.js"></script>
<script type="text/javaScript" language="javascript">

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		// 처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("PubSrchPopupFrame", 100);
		}else{
			util_resizeFrame("PubSrchPopupFrame");
		}
		util_initCompSearchConditions('frm_bidInfo_insert');
	}

	function fn_selectInst(bidNo, bidModSeq, bidNm, guarBidAmt, guarBidCurr, onOffType){
		
		if (onOffType == "FF") {
			parent.fn_messageAlert();
			return;
		}
		
		parent.window.opener.document.frm_pubPm_insert.bidNo.value = bidNo;
		parent.window.opener.document.frm_pubPm_insert.bidModSeq.value = bidModSeq;
		parent.window.opener.document.frm_pubPm_insert.bidNm.value = util_decodeQuot(bidNm);
		parent.window.opener.document.frm_pubPm_insert.guarBidAmt.value = guarBidAmt;
		parent.window.opener.document.frm_pubPm_insert.guarBidCurr.value = guarBidCurr;
		parent.window.close();
	}

</script>
</head>
<body onload="javascript:fn_onLoad();">
<div id="frameDiv">
	<!-- <div class="content"> -->
	<div class="tableTy1">
			<table class="data rowEven">
				<caption><l:mapping programId="PubSrchPopup" objId="title"></l:mapping></caption>
				<colgroup>
					<col style="width: 20%">
					<col style="width: 40%">
					<col style="width: 20%">
					<col style="width: 20%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><l:mapping programId="PubSrchPopupFrame" objId="bidNo"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubSrchPopupFrame" objId="bidNm"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubSrchPopupFrame" objId="pmt_guarBidAmt"></l:mapping></th>
						<th scope="col"><l:mapping programId="PubSrchPopupFrame" objId="bdRcvEndDt"></l:mapping></th>
					</tr>
				</thead>
				<tbody>
					<c:forEach items="${RcvSVO.rcvQVOList}" var="resultInfo" varStatus="status">
					<input type="hidden" name="todayTime" value="${RcvSVO.todayTime}">
					<input type="hidden" name="bdRcvEndDt" value="${resultInfo.bdRcvEndDt}">
						<tr>
						<c:choose>
							<c:when test="${RcvSVO.todayTime < resultInfo.bdRcvEndDt }">
								<td class="tC"><a href="#" onclick="fn_selectInst('${resultInfo.bidNo}','${resultInfo.bidModSeq}','<tf:replaceSpChr replaceStr="${resultInfo.bidNm}"/>','${resultInfo.guarBidAmt}','${resultInfo.guarBidCurr}', '${resultInfo.onOffType }');">${resultInfo.bidNo}-${resultInfo.bidModSeq}</a></td>
							</c:when>
							<c:otherwise>
								<td class="tC">${resultInfo.bidNo}-${resultInfo.bidModSeq}</td>
							</c:otherwise>
						</c:choose>
							<td class="tL">${resultInfo.bidNm}</td>
							<td class="tR"><l:number caliberValue="${resultInfo.guarBidAmt}"></l:number>&nbsp;${resultInfo.guarBidCurr}</td>
							<td class="tC"><l:date dateValue="${resultInfo.bdRcvEndDt}"></l:date></td>
						</tr>
					</c:forEach>
					<c:if test="${RcvSVO.totalRecordCount <= 0}">
						<tr>
							<td colspan="4" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></l:mapping></td>
						</tr>
					</c:if>
				</tbody>
			</table>
	</div>

	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${RcvSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_bidInfo_insert" listURL="/ed/rcv/pubPaymentSrchListPopupFrame.do" paginationInfo="${RcvSVO}" target="PubSrchPopupFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>