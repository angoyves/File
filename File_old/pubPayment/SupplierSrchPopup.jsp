<%--
 /**
  * @Description : 조달업체 조회 (popup) : Supplier Search List (popup) 
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
<title>><l:mapping programId="SupplierSrchPopup" objId="title"></l:mapping></title>
<link rel="stylesheet" href="<c:url value='/css/common.css'></c:url>" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
<validator:javascript formName="frm_supplierInfo_insert" staticJavascript="false" xhtml="true" cdata="false"></validator:javascript>
<script type="text/javascript" src="${contextPath}js/common/font.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alert.js"></script>
<script type="text/javascript" src="${contextPath}js/common/alertExms.js"></script>
<script type="text/javascript" src="${contextPath}js/common/validation.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/frame.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/ajax.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/string.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/event.js" ></script>
<script type="text/javascript" src="${contextPath}js/common/pagination.js"></script>
<script type="text/javaScript" language="javascript">

	//화면 로드 시 :: On load
	function fn_onLoad(){
		fn_selectListPageSupplierSrch();
	}

	//조회 처리 함수 :: Query processing function
	function fn_selectListPageSupplierSrch(){
		var form = document.frm_supplierInfo_insert;
		form.currentPageNo.value = 1;
		
		var bizRegNoSc = form.bizRegNoTemp.value;
		var supplierNmSc = form.supplierNm.value;

		if(bizRegNoSc == '' && supplierNmSc == ''){
			util_messageAlert("<l:mapping programId="SupplierSrchPopup" objId="srchCondition"></l:mapping>", null);
		} else {
			form.bizRegNo.value = form.bizRegNoTemp.value.trim();
			form.action = "<c:url value='/ed/rcv/pubSupplierSrchPopupFrame.do'></c:url>";
			form.target = "SupplierSrchPopupFrame";
			form.submit();
		}
	}
</script>
</head>
<body>
<div id="popup_main">
	<div id="popWrap">
		<!-- Layout : header Area -->
		<div class="popHeader" id="pop_header">
			<h1 class="title"><l:mapping programId="SupplierSrchPopup" objId="title"></l:mapping></h1>
			<button class="Close" title="<l:mapping programId="SupplierSrchPopup" objId="closeBtn"></l:mapping>" onclick="window.close();"><l:mapping programId="SupplierSrchPopup" objId="closeBtn"></l:mapping></button>
		</div>
		<!-- // Layout : header Area -->

		<!-- Layout : container Area -->
		<div class="popContainer" id="popup_contents">
			<!-- 입력폼 // -->
			<form:form name="frm_supplierInfo_insert" modelAttribute="RcvSVO" method="post">
				<div class="tableTy2">
					<div class="dataArea">
						<span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span>
						<!-- 라운드 디자인을 위함. -->
						<input type="hidden" name="searchConditions" value="${RcvSVO.searchConditions}">
						<input type="hidden" name="currentPageNo" value="${RcvSVO.currentPageNo}">
						<input type="hidden" name="isBack" value="${RcvSVO.isBack}">
						<input type="hidden" name="bizRegNo" value="${RcvSVO.bizRegNo}">
						<table class="data">
							<colgroup>
								<col style="width: 20%">
								<col style="width: 80%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row"><em class="pointTxt2" title="<l:mapping programId="SupplierSrchPopup" objId="bizRegNo"></l:mapping>"></em><label for="bizRegNoTemp"><l:mapping programId="SupplierSrchPopup" objId="bizRegNo"></l:mapping></label></th>
									<td>
										<input type="text" id="bizRegNoTemp" name="bizRegNoTemp" class="text" maxlength="11" size="80%" value="${RcvSVO.bizRegNoTemp}"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageSupplierSrch()', '^[^<>]*$', 14, document.frm_supplierInfo_insert.supplierNm);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
								<tr>
									<th scope="row"><em class="pointTxt2" title="<l:mapping programId="SupplierSrchPopup" objId="supplierNm"></l:mapping>"></em><label for="supplierNm"><l:mapping programId="SupplierSrchPopup" objId="supplierNm"></l:mapping></label></th>
									<td>
										<input type="text" name="supplierNm" id="supplierNm" class="text" maxlength="200" size="80%" value="${RcvSVO.supplierNm}"
											onkeypress="javascript:util_enterKeySearchWithCheckValidation(this, event, 'fn_selectListPageSupplierSrch()', '^[^<>]*$', 14, document.frm_supplierInfo_insert.bizRegNoTemp);"
											onblur="javascript:util_checkValidation(this, '^[^<>]*$',14);">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- //입력폼 끝 -->

				<div class="fR mt15 mb20">
					<span class="btnTy3"><input type="button" class="btn" value="<l:mapping programId="SupplierSrchPopup" objId="srchBtn"></l:mapping>" onclick="javascript:fn_selectListPageSupplierSrch();"></span>
				</div>
				<iframe name="SupplierSrchPopupFrame" id="SupplierSrchPopupFrame" width="100%" height="180px" frameborder="0" scrolling="no"></iframe>
			</form:form>
		</div>
		<!-- // Layout : container Area -->
		<!-- Layout : Button Area -->
		<div class="popFooter">
			<span class="btnTy4"><button class="btn" onclick="window.close();" title="<l:mapping programId="SupplierSrchPopup" objId="closeBtn"></l:mapping>"><l:mapping programId="SupplierSrchPopup" objId="closeBtn"></l:mapping></button></span>
		</div>
		<!-- // Layout : Button Area -->
	</div>
</div>
</body>
</html>