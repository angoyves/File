<%--
 /**
  * @Description : 입찰공고 조회 (popup) : Bid Search List (popup) 
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
<validator:javascript formName="frm_bidInfo_insert" staticJavascript="false" xhtml="true" cdata="false"></validator:javascript>
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

	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPagePubPmBidInfo();
	}
	
	//조회 처리 함수 :: Query processing function
	function fn_selectListPagePubPmBidInfo(){
		var form = document.frm_bidInfo_insert;
		form.currentPageNo.value = 1;
		
		//trim 처리
		form.bidNo.value = form.bidNoTemp.value.trim();
		form.action = "<c:url value='/ed/rcv/pubPaymentSrchListPopupFrame.do'></c:url>";
		form.target = "PubSrchPopupFrame";
		form.submit();
	}

	function fn_messageAlert() {
		util_messageAlert("<l:mapping programId="PubSrchPopup" objId="msg1"/>");
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad()">
<div id="popup_main">
	<div id="popWrap">
		<!-- Layout : header Area -->
		<div class="popHeader" id="pop_header">
			<h1 class="title"><l:mapping programId="PubSrchPopup" objId="title"></l:mapping></h1>
			<button class="Close" title="<l:mapping programId="PubSrchPopup" objId="closeBtn"></l:mapping>" onclick="window.close();"><l:mapping programId="PubSrchPopup" objId="closeBtn"></l:mapping></button>
		</div>
		<!-- // Layout : header Area -->

		<!-- Layout : container Area -->
		<div class="popContainer" id="popup_contents">
			<!-- 입력폼 // -->
			<form:form name="frm_bidInfo_insert" modelAttribute="RcvSVO" method="post" id="frm_bidInfo_insert">
				<div class="tableTy2">
					<div class="dataArea">
						<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
						<!-- 라운드 디자인을 위함. -->
						<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
						<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
						<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
						<input type="hidden" name="bidNo" value="${RcvSVO.bidNo}">
						<table class="data">
							<colgroup>
								<col style="width: 20%">
								<col style="width: 80%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row">
										<label for="bidNoTemp"><l:mapping programId="PubSrchPopup" objId="bidNo"></l:mapping></label>
											<em class="pointTxt2" title="<l:mapping programId="PubSrchPopup" objId="title"></l:mapping>"></em>
									</th>
									<td>
										<input type="text" id="bidNoTemp" name="bidNoTemp" class="text" maxlength="11" size="80%" value="${RcvSVO.bidNoTemp}"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageCtDocBidInfo()', '^[^<>]*$', 14, document.frm_bidInfoCt_insert.bidNm;"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="bidNm"><l:mapping programId="PubSrchPopup" objId="bidNm"></l:mapping></label>
											<em class="pointTxt2" title="<l:mapping programId="PubSrchPopup" objId="bidNm"></l:mapping>"></em>
									</th>
									<td>
										<input type="text" id="bidNm" name="bidNm" class="text" maxlength="200" size="80%" value="${RcvSVO.bidNm}"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageCtDocBidInfo()', '^[^<>]*$', 14, document.frm_bidInfoCt_insert.bidNoTemp);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14); ">
									</td>
								</tr>
								<tr>
									<th scope="row" class="noLine"><label for="startDateStr"><l:mapping programId="PubSrchPopup" objId="bdRcvEndDt"></l:mapping></label></th>
									<td class="period">
										<input type="text" name="startDateStr" id="startDateStr" class="article100_text" maxlength="8" style="width:65px" value="<l:date dateValue='${RcvSVO.startDate }'></l:date>"
													onkeydown="javascript:util_checkNumber(this, event)" onfocus="javascript:util_setDateFormat(this)"
													onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																	util_checkObjDayWithHidden(this, document.frm_bidInfo_insert.startDate, document.frm_bidInfo_insert.endDateStr, 'before',valiNoMatchDateMsg)">
										<input type="hidden" name="startDate" id="startDate" value="${RcvSVO.startDate}">
										<a href="#"><img src="<c:url value='/images/common/ico_calendar.gif'></c:url>" 
											class="pl5 vM"
											onclick="javascript:Calendar_D(document.frm_bidInfo_insert.startDateStr, document.frm_bidInfo_insert.startDate);return false;" alt="calendar"></a>
										~
										<input type="text" name="endDateStr" id="endDateStr" class="article100_text" maxlength="8" style="width:65px" value="<l:date dateValue='${RcvSVO.endDate }'></l:date>"
													onkeydown="javascript:util_checkNumber(this, event)" onfocus="javascript:util_setDateFormat(this)"
													onblur="javascript:util_checkDateFormat(this, valiDateMsg);
																util_checkObjDayWithHidden(this, document.frm_bidInfo_insert.endDate, document.frm_bidInfo_insert.startDateStr, 'after', valiNoMatchDateMsg)">
										<input type="hidden" name="endDate"  id="endDate" value="${RcvSVO.endDate}">  <a href="#"><img src="<c:url value='/images/common/ico_calendar.gif'></c:url>"
													class="pl5 vM" onclick="javascript:Calendar_D(document.frm_bidInfo_insert.endDateStr, document.frm_bidInfo_insert.endDate);return false;" alt="calendar"></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- //입력폼 끝 -->

				<div class="fR mt15 mb20">
					<span class="btnTy3"><input type="button" class="btn" value="<l:mapping programId="PubSrchPopup" objId="srchBtn"></l:mapping>" onclick="javascript:fn_selectListPagePubPmBidInfo();"></span>
				</div>
				<div class="btnAreaLeft mt5">
	                <p class="fL" style="color: #FF0000;">※ <l:mapping programId="PubSrchPopup" objId="bdRcvEndDt_info"></l:mapping></p>
	            </div>
				<iframe name="PubSrchPopupFrame" id="PubSrchPopupFrame" width="100%" height="180px" frameborder="0" scrolling="no"></iframe>
			</form:form>
		</div>
		<!-- // Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><button class="btn" onclick="window.close();" title="<l:mapping programId="PubSrchPopup" objId="closeBtn"></l:mapping>"><l:mapping programId="PubSrchPopup" objId="closeBtn"></l:mapping></button></span>
		</div>
		<!-- // Layout : Button Area -->
	</div>
</div>
</body>
</html>