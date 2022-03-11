/**
 * DML 처리 결과
 *
 * @param resultMsg
 * @param destUrl
 * @returns void
 */
function util_showResultForExms(resultMsg, destUrl){


	var documentObj = parent.document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "<div id=\"alert_main\">";
	htmlStr += "	<div class=\"alert_window\" id=\"messageDiv\">";
	htmlStr += "		<p>" + resultMsg + "</p>";
	htmlStr += "	</div>";
	htmlStr += "	<div class=\"space10_blank\"></div>";
	htmlStr += "		<div class=\"button_area center_align\">";
	htmlStr += "			<input class=\"function_button\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_movePageForExms('" + destUrl + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</div>";
	htmlStr += "	</div>";
	htmlStr += "</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

	documentObj.getElementById("messageAlertBtn").focus();

}

/**
 * DML 처리 결과
 *
 * @param resultMsg
 * @param destUrl
 * @returns void
 */
function util_showResultOnPopupForExms(resultMsg, destUrl){

	var documentObj = parent.document;

	util_appendLayerDivOnPopup(documentObj);

	//var message = resultMsg;
	//message    += "<br><a href=\"javascript:util_movePage('" + destUrl + "')\">확인</a>";

	var messageAlertDivObj = documentObj.createElement("div");
	messageAlertDivObj.setAttribute("id", "messageAlertDiv");


	var offSetObj = util_getContentsOffSetOnPopup(documentObj);
	var left = offSetObj.centerWidth - 150;
	var top = offSetObj.centerHeight - 50;

	var styleStr = "position:absolute; width:300px;";
	styleStr    += "left:" + left + "px; top:" + top + "px;";

	messageAlertDivObj.setAttribute("style", styleStr);

	var htmlStr = "";
	htmlStr += "<div id=\"alert_main\">";
	htmlStr += "	<div class=\"alert_window\" id=\"messageDiv\">";
	htmlStr += "		<p>" + resultMsg + "</p>";
	htmlStr += "	</div>";
	htmlStr += "	<div class=\"space10_blank\"></div>";
	htmlStr += "		<div class=\"button_area center_align\">";
	htmlStr += "			<input class=\"function_button\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_movePageOnPopupForExms('" + destUrl + "')\" value=\"확인\">";
	htmlStr += "		</div>";
	htmlStr += "	</div>";
	htmlStr += "</div>";

	messageAlertDivObj.innerHTML = htmlStr;

	documentObj.getElementsByTagName("body")[0].appendChild(messageAlertDivObj);

	var messageDivHeight = documentObj.getElementById("messageDiv").offsetHeight;
	var messageDivWidth = documentObj.getElementById("messageDiv").offsetWidth;

	documentObj.getElementById("alert_main").style.height = Number(messageDivHeight) + 50 + "px";
	documentObj.getElementById("alert_main").style.width = Number(messageDivWidth) + 50 + "px";
	documentObj.getElementById("messageAlertBtn").focus();

}

function util_movePageForExms(destUrl){

//	var formObj = document.getElementsByTagName("form")[0];
//
//	formObj.target = "_top";
//	formObj.action = destUrl;
//	formObj.submit();

	parent.top.location.href = destUrl;
}

function util_movePageOnPopupForExms(destUrl){

	var formObj = document.getElementsByTagName("form")[0];

	formObj.submit();
}

