<%
  /**
   * @Description : 파일 업로드/다운로드 등록화면
   * @Modification Information
   * @
   * @   수정일       수정자            수정내용
   * @ ----------    --------    -----------------------
   * @ 2014.09.20     박상우            초기작성
   *
   */
%>

<%@ page contentType="text/html; charset=utf-8"%>
<%@ include file="/WEB-INF/jsp/com/TagLibraries.jsp" %>
<link rel="stylesheet" type="text/css" href="${contextPath}css/common${arCss}">
<link rel="stylesheet" type="text/css" href="${contextPath}css/layout${arCss}">
<link rel="stylesheet" type="text/css" href="${contextPath}css/component${arCss}">
<script type="text/javascript">

	var fileIndex = 0;
	/* ********************************************************
	 * 파일태그 추가
	 ******************************************************** */
	function fn_addFile(){

		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		// 파일은 5개까지
		if(tableLength >= 5){
			util_messageAlert("<l:mapping programId="FileUpDnInsert" objId="msg_count_limit" />");
			return;
		}

		// 기존에 추가된 파일태그에 값이 없으면 리턴
		for(var i = 1; i <= fileIndex; i++){

			var compareFileObj = document.getElementById("file" + i);

			if(compareFileObj != null &&
			   compareFileObj.value == ""){

				util_messageAlert("<l:mapping programId="COMMON" objId="msg_select_exist_file" />");
				return;
			}

		}
		fileIndex++;
		fn_addFileRow(fileIndex, tableLength);

	}

	/* ********************************************************
	 * 파일태그 추가(인텍스)
	 ******************************************************** */
	function fn_addFileRow(paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");
		var rowObj = tableObj.insertRow(tableIndex);
		var cellObj = rowObj.insertCell(0);
		cellObj.style.border = "0px";

		var htmlStr  = "<input type=\"file\" id=\"file" + paramFileIndex + "\" name=\"file" + paramFileIndex + "\"  size=\"60\" onchange=\"javascript:fn_checkFileName(this, " + paramFileIndex + "," + tableIndex + ")\">";
		    htmlStr += "&nbsp;<input type=\"button\" class=\"form_button\" onclick=\"javascript:fn_deleteFileRow(this.parentNode.parentNode)\" value=\"<l:mapping programId="FileUpDnInsert" objId="cancel_attach" />\">";
        cellObj.innerHTML = htmlStr;

	}

	/* ********************************************************
	 * 파일태그 삭제
	 ******************************************************** */
	function fn_deleteFileRow(trObj){

		var tableObj = document.getElementById("fileTable");
		var trIndex = trObj.sectionRowIndex;

		tableObj.deleteRow(trIndex);

	}

	/* ********************************************************
	 * 파일명 체크
	 ******************************************************** */
	function fn_checkFileName(fileObj, paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");

		var fileName = "";
		if(navigator.userAgent.indexOf("Firefox") > -1 ){

			fileName = fileObj.value;

		}else{

			var fileName = fileObj.value;
			fileName = fileName.substring(fileName.lastIndexOf("\\") + 1);

		}

		/*
		 * 중복파일 검색 시작
		 */
		// 기존에 추가된 파일태그에 값이 없으면 리턴
		for(var i = 1; i <= fileIndex; i++){

			var compareFileObj = document.getElementById("file" + i);

			if(compareFileObj != null){

				var compareFileObj = document.getElementById("file" + i);
				var compareFileName = "";
				if(navigator.userAgent.indexOf("Firefox") > -1 ){

					var compareFileName = compareFileObj.value;

				}else{

					var compareFileName = compareFileObj.value;
					compareFileName = compareFileName.substring(compareFileName.lastIndexOf("\\") + 1);

				}

				if(paramFileIndex != i &&
				   fileName == compareFileName){

					util_messageAlert("<l:mapping programId="COMMON" objId="msg_duplicate_file_name" />");

					if(navigator.userAgent.indexOf("MSIE") > -1 ){
						fn_deleteFileRow(fileObj.parentNode.parentNode);
						fn_addFileRow(paramFileIndex, tableIndex);
					}else{
						fileObj.value = "";
					}

				}

			}

		}
		/*
		 * 중복파일 검색 끝
		 */

		/*
		 * 파일명 유효성 검증 시작
		 */
		var maskStr = "^[0-9|ㄱ-ㅎ|ㅏ-ㅣ|가-힝|+-|_|.| |()]*$";
		var regPat = new RegExp(maskStr);
		var result = matchPattern(fileName, regPat);

		if(result == null){

			var checkMaskStr = unescape(replaceAll("<l:mapping programId="COMMON" objId="errors_invalid_file_name" />","\\","%"));
			var checkMaskStr = extractMaskStrs(maskStr, checkMaskStr);

			util_messageAlert(checkMaskStr);

			if(navigator.userAgent.indexOf("MSIE") > -1 ){
				fn_deleteFileRow(fileObj.parentNode.parentNode);
				fn_addFileRow(paramFileIndex, tableIndex);
			}else{
				fileObj.value = "";
			}
		}
		/*
		 * 파일명 유효성 검증 끝
		 */

	}

	/* ********************************************************
	 * 선택하지 않은 파일이 있는지 확인
	 ******************************************************** */
	function fn_checkSelectedFile(){

		var result = true;

		for(i = 0; i <= fileIndex;i++){

			var fileObj = document.getElementById("file" + i);
			if(fileObj != null &&
			   fileObj.value == ""){
				util_messageAlert("<l:mapping programId="COMMON" objId="msg_no_value_file" />", fileObj);
				return false;
			}

		}

		return result;

	}

	/* ********************************************************
	 * 초기화
	 ******************************************************** */
	function fn_initFiles(){

		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		for(var i = tableLength - 1; i >= 0; i--){
			tableObj.deleteRow(i);
		}

		fileIndex = 0;

	}

</script>

<tr>
	<th class="tL">
		<label for="cont">
			<l:mapping programId="FileUpDnInsert" objId="attach_file" />
		</label>
	</th>
	<td colspan="3">
		<l:mapping programId="FileUpDnInsert" objId="msg_file_max_count_size" /><br>
		<input type="button" class="form_button" onclick="javascript:fn_addFile()" value="<l:mapping programId="FileUpDnInsert" objId="add_file" />">
		<table name="fileTable" id="fileTable" class="file_table">
		</table>
	</td>
</tr>

