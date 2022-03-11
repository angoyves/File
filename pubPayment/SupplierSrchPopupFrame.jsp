<%--
 /**
  * @Description : 조달업체 프레임 조회 (popup) : Supplier Search Frame (popup) 
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
<link rel="stylesheet" href="<c:url value='/css/sub.css'></c:url>" media="all">
<c:out value="${commonScript}" escapeXml="false"></c:out>
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

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		// 처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("SupplierSrchPopupFrame", 100);
		}else{
			util_resizeFrame("SupplierSrchPopupFrame");
		}
		util_initCompSearchConditions('frm_supplierInfo_insert');
	}

	function fn_selectSupplier(bizRegNo, supplierNm){
		parent.window.opener.document.frm_pubPm_insert.bizRegNo.value = bizRegNo;
		parent.window.opener.document.frm_pubPm_insert.supplierNm.value = util_decodeQuot(supplierNm);
		parent.window.close();
	}

</script>
</head>
<body onload="javascript:fn_onLoad()">
<div id="frameDiv">
<!-- <div class="content"> -->
	<div class="tableTy1">
			<table class="data rowEven">
				<caption><l:mapping programId="SupplierSrchPopup" objId="title"></l:mapping></caption>
				<colgroup>
					<col style="width: 30%">
					<col style="width: 70%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><l:mapping programId="SupplierSrchPopupFrame" objId="bizRegNo"></l:mapping></th>
						<th scope="col"><l:mapping programId="SupplierSrchPopupFrame" objId="supplierNm"></l:mapping></th>
					</tr>
				</thead>
				<tbody>
					<c:forEach items="${RcvSVO.rcvQVOList}" var="resultInfo" varStatus="status">
						<tr>
							<td class="tC"><a href="#" onclick="fn_selectSupplier('${resultInfo.bizRegNo}', '<tf:replaceSpChr replaceStr="${resultInfo.supplierNm}"/>');">${resultInfo.bizRegNo}</a></td>
							<td class="tL">${resultInfo.supplierNm}</td>
						</tr>
					</c:forEach>
					<c:if test="${RcvSVO.totalRecordCount <= 0}">
						<tr>
							<td colspan="2" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></l:mapping></td>
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
			<tf:pagination formName="frm_supplierInfo_insert" listURL="/ed/rcv/pubSupplierSrchPopupFrame.do" paginationInfo="${RcvSVO}" target="SupplierSrchPopupFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>