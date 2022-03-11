<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/layout.css">
<link rel="stylesheet" type="text/css" href="css/component.css">
<script type="text/javascript">

	var fileIndex = 0;
	
	function fn_addFile(){

		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;
		//var tableLength = 5;

		if(tableLength >= 5){
			util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>");
			return;
		}

		for(var i = 1; i <= fileIndex; i++){

			var compareFileObj = document.getElementById("file" + i);

			if(compareFileObj != null &&
			   compareFileObj.value == ""){

				util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>");
				return;
			}

		}
		fileIndex++;
		fn_addFileRow(fileIndex, tableLength);

	}
	
	function fn_addFileRow(paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");
		var rowObj = tableObj.insertRow(tableIndex);
		var cellObj = rowObj.insertCell(0);
		cellObj.style.border = "0px";

		var htmlStr  = "<input type=\"file\" id=\"file" + paramFileIndex + "\" name=\"file" + paramFileIndex + "\"  size=\"60\" onchange=\"javascript:fn_checkFileName(this, " + paramFileIndex + "," + tableIndex + ")\">";
		    htmlStr += "&nbsp;<input type=\"button\" class=\"form_button\" onclick=\"javascript:fn_deleteFileRow(this.parentNode.parentNode)\" value=\"<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>\">";
        cellObj.innerHTML = htmlStr;

	}
	
	function fn_deleteFileRow(trObj){

		var tableObj = document.getElementById("fileTable");
		var trIndex = trObj.sectionRowIndex;

		tableObj.deleteRow(trIndex);

	}

	function fn_checkFileName(fileObj, paramFileIndex, tableIndex){

		var tableObj = document.getElementById("fileTable");

		var fileName = "";
		if(navigator.userAgent.indexOf("Firefox") > -1 ){

			fileName = fileObj.value;

		}else{

			var fileName = fileObj.value;
			fileName = fileName.substring(fileName.lastIndexOf("\\") + 1);

		}

		
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

					/*util_messageAlert("<l:mapping programId="COMMON" objId="msg_duplicate_file_name" />");*/
					util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>");

					if(navigator.userAgent.indexOf("MSIE") > -1 ){
						fn_deleteFileRow(fileObj.parentNode.parentNode);
						fn_addFileRow(paramFileIndex, tableIndex);
					}else{
						fileObj.value = "";
					}

				}

			}

		}
		
		var maskStr = "^[0-9|ㄱ-ㅎ|ㅏ-ㅣ|가-힝|+-|_|.| |()]*$";
		var regPat = new RegExp(maskStr);
		var result = matchPattern(fileName, regPat);

		if(result == null){

			<!--var checkMaskStr = unescape(replaceAll("<l:mapping programId="COMMON" objId="errors_invalid_file_name" />","\\","%"));-->
			var checkMaskStr = unescape(replaceAll("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>","\\","%"));
			var checkMaskStr = extractMaskStrs(maskStr, checkMaskStr);

			util_messageAlert(checkMaskStr);

			if(navigator.userAgent.indexOf("MSIE") > -1 ){
				fn_deleteFileRow(fileObj.parentNode.parentNode);
				fn_addFileRow(paramFileIndex, tableIndex);
			}else{
				fileObj.value = "";
			}
		}

	}

	function fn_checkSelectedFile(){

		var result = true;

		for(i = 0; i <= fileIndex;i++){

			var fileObj = document.getElementById("file" + i);
			if(fileObj != null &&
			   fileObj.value == ""){
				//util_messageAlert("<l:mapping programId="COMMON" objId="msg_no_value_file" />", fileObj);
				util_messageAlert("<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>", fileObj);
				return false;
			}

		}

		return result;

	}

	function fn_initFiles(){

		var tableObj = document.getElementById("fileTable");
		var tableLength = tableObj.rows.length;

		for(var i = tableLength - 1; i >= 0; i--){
			tableObj.deleteRow(i);
		}

		fileIndex = 0;

	}
	function fn_open(){
		 
		var openParam = "width=845px,toolbar=no,menubar=no,resizable=no,scrollbars=yes,copyhistory=no,location=no";
		window.open('', 'Popup', openParam);
	
		var form = document.frm_pub;
		
		form.target = "Popup";
		form.action = "/report1.do";
		form.submit();
	}

</script>

<tr>
	<th class="tL">
		<label for="cont">
			<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>
		</label>
	</th>
	<td colspan="3">
		<!--Vous ne pouvez telecharger que trois fichiers au maximun ...<br>-->
        <l:mapping programId="FileUpDnInsert" objId="msg_file_max_count_size" /><br>
		<input type="button" class="form_button" onclick="fn_addFile()" value="<?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'repCom', $ObjId = 'menu_depth3_2'); ?>">
        <!--<input type="button" class="form_button" onclick="fn_open()" value="Ounvrir un Ficher">-->
		<table name="fileTable" id="fileTable" class="file_table">
		</table>
	</td>
</tr>


