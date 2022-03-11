<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><l:mapping programId="User" objId="title"></l:mapping></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<link rel="stylesheet" href="../css/sub.css" media="all">
<script type="text/javascript" src="../jscommon/font.js"></script>
<script type="text/javascript" src="../jscommon/alert.js"></script>
<script type="text/javascript" src="../jscommon/alertExms.js"></script>
<script type="text/javascript" src="../jscommon/pagination.js"></script>
<script type="text/javascript" src="../jscommon/frame.js"></script>
<script type="text/javascript" src="../jscommon/ajax.js"></script>
<script type="text/javascript" src="../jscommon/event.js"></script>
<c:out value="${commonScript}" escapeXml="false"></c:out>
<script type="text/javaScript" language="javascript">

	//화면초기화 :: Screen initialization
	function fn_onLoad(){
		//처리중 이미지 제거
		util_hideExecutionAll(parent.document);
		if(document.getElementById("frameDiv").scrollHeight < 150){
			util_resizeFrameBySize("UserFrame", 100);
		}else{
			util_resizeFrame("UserFrame");
		}
		util_initCompSearchConditions('frm_user');
	}
	 
	//상세화면 이동 처리 함수 :: More screen-handling functions
	function fn_moveUserDetail(userId){
		var form = parent.document.frm_user;
		form.userId.value = userId;
		form.target = "_top";
		form.action = "/ed/user/moveUserDetailAdm.do";
		form.submit();
	}

</script>
</head>
<body onLoad="javascript:fn_onLoad();">
<div id="frameDiv">
	<!-- <div class="content"> -->
	<div class="tableTy1">
		<form name="frm_user_list" modelAttribute="UserSVO" method="post">
			<table class="data rowEven">
				<caption><l:mapping programId="User" objId="title"></l:mapping></caption>
				<colgroup>
					<col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 15%">
					<col style="width: 10%">
				</colgroup>
				<thead>
					<tr>
						<th scope="col"><l:mapping programId="UserFrame" objId="userId"></l:mapping></th>
						<th scope="col"><l:mapping programId="UserFrame" objId="supplierNm"></l:mapping></th>
						<th scope="col"><l:mapping programId="UserFrame" objId="telNo"></l:mapping></th>
						<th scope="col"><l:mapping programId="UserFrame" objId="eMail"></l:mapping></th>
						<th scope="col"><l:mapping programId="UserFrame" objId="dateOfApplication"></l:mapping></th>
						<th scope="col"><l:mapping programId="UserFrame" objId="approvalStatus"></l:mapping></th>
					</tr>
				</thead>
				<tbody>
					<c:forEach items="${UserSVO.userQVOList}" var="resultInfo" varStatus="status">
						<tr>
							<td class="tL"><a href="#" onClick="javascript:fn_moveUserDetail('${resultInfo.userId}');">${resultInfo.userId}</a></td>
							<td class="tL">${resultInfo.supplierNm}</td>
							<td class="tL">${resultInfo.telNo}</td>
							<td class="tL">${resultInfo.eMail}</td>
							<td class="tC"><l:date dateValue="${resultInfo.regDt}"></l:date></td>
							<td class="tC">
							<c:choose>
								<c:when test="${resultInfo.acceptYn=='Y'}">
	                       			<l:mapping programId="UserFrame" objId="approvalY"></l:mapping>
	                       		</c:when>
								<c:when test="${resultInfo.acceptYn=='N'}">
	                       		 	<l:mapping programId="UserFrame" objId="approvalN"></l:mapping>
	                       		</c:when>
								<c:when test="${resultInfo.acceptYn=='R'}">
	                       		 	<span class="bold"><font color="F15F5F"><l:mapping programId="UserFrame" objId="approvalR"></l:mapping></font></span>
	                       		</c:when>
							</c:choose>
							</td>
						</tr>
					</c:forEach>
					<c:if test="${UserSVO.totalRecordCount <= 0}">
						<tr>
							<td colspan="6" style="width: 740px" align="center"><l:mapping programId="COMMON" objId="common_no_result_msg"></l:mapping></td>
						</tr>
					</c:if>
				</tbody>
			</table>
		</form>
	</div>
	
	<!-- 네비게이션 영역 시작  -->
	<div class="pageListNum">
		<tfa:CurrentPage pageInfo="${UserSVO}"></tfa:CurrentPage>
	</div>
	<div class="boardNavigation" style="text-align: center;"> 
		<ul class="page">
			<tf:pagination formName="frm_user" listURL="/ed/user/selectListPageUser.do" paginationInfo="${UserSVO}" target="UserFrame"></tf:pagination>
		</ul>
	</div>
</div>
</body>
</html>