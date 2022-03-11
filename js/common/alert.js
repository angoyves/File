/**
 * offset 설정
 *
 * @param contentsObj
 * @returns offsetObj
 */
function util_setOffset(contentsObj, documentObj){

	var offsetObj   = new Object();
	offsetObj.left = contentsObj.offsetLeft;
	offsetObj.top = contentsObj.offsetTop;
	offsetObj.width = contentsObj.offsetLeft + contentsObj.offsetWidth;
	offsetObj.height = contentsObj.offsetTop + contentsObj.offsetHeight;
	offsetObj.centerLeft = contentsObj.offsetLeft + (contentsObj.offsetWidth / 2);

	/*
	 * 높이 가운데 정렬 시작
	 */
	var scrollTop = 0;
	var scrollHeight= 0;
	if(navigator.userAgent.indexOf("MSIE") > -1 ){
		scrollTop = documentObj.documentElement.scrollTop;
		scrollHeight = documentObj.documentElement.offsetHeight;
	}else{

		// 아이프레임에서 하는 경우에는 부모창의 높이를 구해야 한다.

		if(document == documentObj){
			//scrollTop = window.scrollY;
			scrollTop =  (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
			scrollHeight = window.screen.height;
		}else{
			//scrollTop = parent.window.scrollY;
			scrollTop =  (parent.window.pageYOffset !== undefined) ? parent.window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
			scrollHeight = parent.window.screen.height;
		}

	}
	offsetObj.centerTop = scrollTop + (scrollHeight / 2);
	/*
	 * 높이 가운데 정렬 끝
	 */

	offsetObj.executionImageLeft = offsetObj.centerLeft - 16;
	offsetObj.executionImageTop = offsetObj.centerTop - 16;
	offsetObj.messageAlertLeft = offsetObj.centerLeft - 150;
	offsetObj.messageAlertTop = offsetObj.centerTop;

	return offsetObj;

}

/**
 * 배경 레이어 설정
 *
 * @param offsetObj
 * @param documentObj
 * @returns layerDivObj
 */
function util_setLayerDIv(offsetObj, documentObj){

	if(documentObj.getElementById("layerDiv") != null){
		return;
	}

	var layerDivObj = documentObj.createElement("div");
	layerDivObj.setAttribute("id", "layerDiv");

	var left = offsetObj.left;
	var top = offsetObj.top;

	var width;

	if(documentObj.getElementById("contents") != null){
		width = documentObj.getElementById("contents").offsetWidth;
	}else if(documentObj.getElementById("popup_contents") != null){
		width = documentObj.getElementById("popup_contents").offsetWidth;
	}

	var height = offsetObj.height;

	var styleStr = "position:absolute; filter:alpha(opacity=50); opacity:0.5; background-color:#ffffff; ";
	styleStr    += "left:" + left + "px; top:" + top + "px; width:" + width + "px; height:" + height + "px;";

	layerDivObj.setAttribute("style", styleStr);

	documentObj.getElementsByTagName("body")[0].appendChild(layerDivObj);

	return layerDivObj;

}

/**
 * 처리중 이미지 보여주기
 *
 * @param offsetObj
 * @returns imageObj
 */
function util_getExecutionImage(offsetObj, documentObj){

	var imageObj = documentObj.createElement("img");
	imageObj.setAttribute("id", "executionImageImg");
//	imageObj.setAttribute("src", contextPath + "images/execution.gif");
	//imageObj.setAttribute("src", "C:/wamp/www/Portal/AGesCom/file/images/common/loading.gif");
	imageObj.setAttribute("src", "../images/common/loading.gif");

	var top;

	if(documentObj.getElementById("contents") != null){
		top = offsetObj.executionImageTop;
	}else if(documentObj.getElementById("popup_contents") != null){
		top = documentObj.getElementById("popup_contents").offsetHeight / 2;
	}

    imageObj.setAttribute("style",
			              "position:absolute; width:32px; height:32px; left:" + offsetObj.executionImageLeft + "px; top:" + top + "px;");

	return imageObj;

}

/**
 * offset 만들어서 리턴
 *
 * @param documentObj
 * @returns 컨텐트 offset
 */
function util_getContentsOffSet(documentObj){

	var contentsObj = null;
	
	if(documentObj.getElementById("contents") != null){
		contentsObj =  documentObj.getElementById("contents");
	}else if(documentObj.getElementById("popup_contents") != null){
		contentsObj =  documentObj.getElementById("popup_contents");
	}else{
		contentsObj =  documentObj.getElementById("messageAlertBody");
	}
	
	return util_setOffset(contentsObj, documentObj);

}

/**
 * offset 만들어서 리턴(팝업)
 *
 * @param documentObj
 * @returns 컨텐트 offset
 */
function util_getContentsOffSetOnPopup(documentObj){

	var contensObj =  documentObj.getElementById("popup_contents");
	return util_setOffset(contensObj, documentObj);

}

/**
 * MessageAlertDiv 리턴
 *
 * @param documentObj
 * @returns messageAlertDiv
 */
function util_getMessageAlertDiv(documentObj, htmlStr, left, top, divType){

	if(documentObj.getElementById("messageAlertDiv") != null){
		return;
	}
	
	var messageAlertDivObj = documentObj.createElement("div");
	messageAlertDivObj.setAttribute("id", "messageAlertDiv");
	
	messageAlertDivObj.setAttribute("class", "boxTy6");

//	var styleStr = "position:absolute; width:300px;";
	var styleStr = "z-index:3; position:absolute;";
	//styleStr    += "left:" + left + "px; top:" + top + "px;";
	styleStr    += "left:" + left + "px;";

	messageAlertDivObj.setAttribute("style", styleStr);

	messageAlertDivObj.innerHTML = htmlStr;

	documentObj.getElementsByTagName("body")[0].appendChild(messageAlertDivObj);

	var messageDivHeight = documentObj.getElementById("messageDiv").offsetHeight;
	var messageDivWidth = documentObj.getElementById("messageDiv").offsetWidth;

	//var alertMainObjWidth = Number(messageDivWidth) + 100;
	var alertMainObjWidth = Number(messageDivWidth);
	var alertMainObjHeight = Number(messageDivHeight) + 45;

	//documentObj.getElementById("alert_main").style.width = alertMainObjWidth + "px";
	documentObj.getElementById("alert_main").style.height = alertMainObjHeight + "px";
	
	//documentObj.getElementById("messageAlertDiv").style.width = alertMainObjWidth + "px";
	
	if(documentObj.getElementById("popup_contents") != null){
		messageAlertDivObj.style.top = ((top  / 2) - 100) + "px";
	}else{
		messageAlertDivObj.style.top = top - (alertMainObjHeight / 2) - 100 + "px";
	}

	// IE에서는 keydown으로 하면 자동으로 클릭이 되므로 처리
	if(navigator.userAgent.indexOf("MSIE") > -1 && event != null){

		if(event.keyCode != 0){
			event.keyCode = 0;
		}

	}

	if(divType == "alert"){
		var tempFocusObj = documentObj.getElementById("messageAlertBtn");
		setTimeout(function(){tempFocusObj.focus();tempFocusObj.selected = true;},10);
	}else if(tempFocusObj == "confirm"){
		var focusObj = documentObj.getElementById("confirmOkBtn");
		setTimeout(function(){tempFocusObj.focus();tempFocusObj.selected = true;},10);
	}

	return messageAlertDivObj;

}

/**
 * 레이어 이미지 리턴
 *
 * @param documentObj
 * @returns layerDivObj
 */
function util_appendLayerDiv(documentObj){

	var offsetObj = util_getContentsOffSet(documentObj);
	return util_setLayerDIv(offsetObj, documentObj);

}

/**
 * 레이어 이미지 리턴(팝업)
 *
 * @param documentObj
 * @returns layerDivObj
 */
function util_appendLayerDivOnPopup(documentObj){

	var offsetObj = util_getContentsOffSetOnPopup(documentObj);
	return util_setLayerDIv(offsetObj, documentObj);

}

/**
 * 배경 레이어 숨김
 *
 * @param documentObj
 * @returns void
 */
function util_hideExecutionLayer(documentObj){

	var layerDivObj = documentObj.getElementById("layerDiv");
	if(layerDivObj != null){
		documentObj.getElementsByTagName("body")[0].removeChild(layerDivObj);
	}

}

/**
 * 처리중 이미지 보여주기
 *
 * @param void
 * @returns void
 */
function util_showExecutionImage(){

	var offsetObj = util_getContentsOffSet(document);
	var imageObj = util_getExecutionImage(offsetObj, document);

	if(document.getElementById("executionImageImg") != null){
		return;
	}

	document.getElementsByTagName("body")[0].appendChild(imageObj);
	util_appendLayerDiv(document);

}

/**
 * 처리중 이미지 보여주기(iframe)
 *
 * @param void
 * @returns void
 */
function util_showExecutionImageOnParent(){

	var offsetObj = util_getContentsOffSet(parent.document);
	var imageObj = util_getExecutionImage(offsetObj, parent.document);

	if(parent.document.getElementById("executionImageImg") != null){
		return;
	}

	parent.document.getElementsByTagName("body")[0].appendChild(imageObj);
	util_appendLayerDiv(parent.document);

}

/**
 * 처리중 이미지 보여주기(팝업)
 *
 * @param void
 * @returns void
 */
function util_showExecutionImageOnPopup(){

	var offsetObj = util_getContentsOffSetOnPopup(document);
	var imageObj = util_getExecutionImage(offsetObj, document);

	if(document.getElementById("executionImageImg") != null){
		return;
	}

	document.getElementsByTagName("body")[0].appendChild(imageObj);
	util_appendLayerDivOnPopup(document);

}

/**
 * 처리중 이미지 숨김
 *
 * @param documentObj
 * @returns void
 */
function util_hideExecutionImage(documentObj){

	var imgObj = documentObj.getElementById("executionImageImg");
	documentObj.getElementsByTagName("body")[0].removeChild(imgObj);

}

/**
 * 처리중 이미지&레이어 숨김
 *
 * @param documentObj
 * @returns void
 */
function util_hideExecutionAll(documentObj){

	var imgObj = documentObj.getElementById("executionImageImg");
	var layerDivObj = documentObj.getElementById("layerDiv");

	if(layerDivObj != null){
		util_hideExecutionLayer(documentObj);
	}
	if(imgObj != null){
		util_hideExecutionImage(documentObj);
	}

}

/**
 * 메세지 div 숨김
 *
 * @param documentObj
 * @returns void
 */
function util_hideMessageAlert(documentObj){

	var layerDivObj = documentObj.getElementById("messageAlertDiv");
	documentObj.getElementsByTagName("body")[0].removeChild(layerDivObj);

}

/**
 * 메세지 div 만들기
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param paramFocusObjName
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDiv(documentObj, paramHtmlStr, paramFocusObjName){

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";

	if(paramFocusObjName == null){
		htmlStr += "				<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlert(event)\" value=\"" + confirmStr + "\">";
	}else{
		htmlStr += "				<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlert(event, '" + paramFocusObjName + "')\" value=\"" + confirmStr + "\">";
	}

	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 div 만들기 자식 프레임에 포커스
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param paramFocusObjName
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDivFocusChild(documentObj, paramHtmlStr, paramFocusObjName, frameName, useId){

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	if(useId == null){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertFocusChild(event, '" + paramFocusObjName + "', '" + frameName + "')\" value=\"" + confirmStr + "\">";
	}else if(useId != null && useId == "Y"){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertFocusChild(event, '" + paramFocusObjName + "', '" + frameName + "', 'Y')\" value=\"" + confirmStr + "\">";
	}
	
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";
	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 div 만들기(팝업)
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param paramFocusObjName
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDivOnPopup(documentObj, paramHtmlStr, paramFocusObjName){

	var offsetObj = util_getContentsOffSetOnPopup(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";

	if(paramFocusObjName == null){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlert(event)\" value=\"" + confirmStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlert(event, '" + paramFocusObjName + "')\" value=\"" + confirmStr + "\">";
	}

	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";
	
	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 div 만들기(" + confirmStr + "만)
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param confirmScript
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDivNoConfirm(documentObj, paramHtmlStr, confirmScript){

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";

	htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"" + confirmScript + "\" value=\"" + confirmStr + "\">";

	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";
	
	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 div 만들기(함수 실행)
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param execStr
 * @param paramFocusObjName
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDivWithExec(documentObj, paramHtmlStr, execStr, paramFocusObjName){

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";

	if(paramFocusObjName == null){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertWithExec(event, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertWithExec(event, '" + execStr + "', '" + paramFocusObjName + "')\" value=\"" + confirmStr + "\">";
	}

	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";
	
	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 div 만들기(함수 실행, 팝업)
 *
 * @param documentObj
 * @param paramHtmlStr
 * @param execStr
 * @param paramFocusObjName
 * @returns messageAlertDivObj
 */
function util_makeMessageAlertDivWithExecOnPopup(documentObj, paramHtmlStr, execStr, paramFocusObjName, isSuccess){

	var offsetObj = util_getContentsOffSetOnPopup(documentObj);

	var htmlStr = "";
	
	if(isSuccess=="Y"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval3\">";
	}else if(isSuccess=="N"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval4\">";
	}else{
		htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	}
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";

	if(paramFocusObjName == null){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertWithExec(event, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_closeAlertWithExec(event, '" + execStr + "', '" + paramFocusObjName + "')\" value=\"" + confirmStr + "\">";
	}

	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	return util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * 메세지 창
 *
 * @param paramMessage
 * @param paramFocusObj
 * @returns void
 */
var focusObj = null;
function util_messageAlert(paramMessage, paramFocusObj){

	focusObj = null;

	util_appendLayerDiv(document);

	var message = paramMessage;

	if(paramFocusObj != null){
		focusObj = paramFocusObj;
	}

	if(document.getElementById("contents") != null){
		util_makeMessageAlertDiv(document, message);
	}else{
		util_makeMessageAlertDivOnPopup(document, message);
	}


}

/**
 * 메세지 창(iframe)
 *
 * @param paramMessage
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertOnParent(paramMessage, paramFocusObjName){

	parent.focusObj = null;

	util_appendLayerDiv(parent.document);

	var message = paramMessage;
	util_makeMessageAlertDiv(parent.document, paramMessage, paramFocusObjName);

}

/**
 * 메세지 창(함수 실행)
 *
 * @param paramMessage
 * @param execStr
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertWithExec(paramMessage, execStr, paramFocusObj){

	focusObj = null;

	util_appendLayerDiv(document);

	var message = paramMessage;

	if(paramFocusObj != null){
		focusObj = paramFocusObj;
	}

	util_makeMessageAlertDivWithExec(document, message, execStr);

}

/**
 * 메세지 창(함수 실행, 차일드 프레임)
 *
 * @param paramMessage
 * @param execStr
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertWithExecOnParent(paramMessage, execStr, paramFocusObj){

	parent.focusObj = null;

	util_appendLayerDiv(parent.document);

	var message = paramMessage;

	if(paramFocusObj != null){
		focusObj = paramFocusObj;
	}

	util_makeMessageAlertDivWithExec(parent.document, message, execStr);

}

/**
 * 메세지 창(함수 실행, 팝업)
 *
 * @param paramMessage
 * @param execStr
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertWithExecOnPopup(paramMessage, execStr, paramFocusObj, isSuccess){

	focusObj = null;

	util_appendLayerDivOnPopup(document);

	var message = paramMessage;

	if(paramFocusObj != null){
		focusObj = paramFocusObj;
	}

	util_makeMessageAlertDivWithExecOnPopup(document, message, execStr, focusObj, isSuccess);

}

/**
 * 메세지 창(팝업)
 *
 * @param paramMessage
 * @param execStr
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertOnPopup(paramMessage, paramFocusObj){

	focusObj = null;

	util_appendLayerDivOnPopup(document);

	var message = paramMessage;

	if(paramFocusObj != null){
		focusObj = paramFocusObj;
	}

	util_makeMessageAlertDivOnPopup(document, message);

}

/**
 * 메세지 창 닫기
 *
 * @param event
 * @param focusObjName
 * @returns void
 */
function util_closeAlert(event, focusObjName){

	util_hideMessageAlert(document);
	util_hideExecutionLayer(document);

	if(focusObj != null){

		if (focusObj.type == "select-one") {
			setTimeout(function(){focusObj.focus();focusObj[0].selected = true;},10);
		}else if (focusObj.type == "button"){
			setTimeout(function(){focusObj.focus();},10);
		}else{
			setTimeout(function(){focusObj.focus();focusObj.select();},10);
		}


	}else if(focusObjName != null){

		focusObj = document.getElementsByName(focusObjName)[0];

		if (focusObj.type == "select-one") {
			setTimeout(function(){focusObj.focus();focusObj[0].selected = true;},10);
		}else if (focusObj.type == "button"){
			setTimeout(function(){focusObj.focus();},10);
		}else{
			setTimeout(function(){focusObj.focus();focusObj.select();},10);
		}


	}

}

/**
 * 메세지 창 닫기, 자식 프레임 포커스
 *
 * @param event
 * @param focusObjName
 * @returns void
 */
function util_closeAlertFocusChild(event, focusObjName, frameName, useId){

	util_hideMessageAlert(document);
	util_hideExecutionLayer(document);

	var childFrame = document.getElementsByName(frameName)[0];
	var focusObj;
	
	if(useId == null){
		focusObj = childFrame.contentDocument.getElementsByName(focusObjName)[0];
	}else if(useId != null && useId == "Y"){
		focusObj = childFrame.contentDocument.getElementById(focusObjName);
	}

	if (focusObj.type == "select-one") {
		setTimeout(function(){focusObj.focus();focusObj[0].selected = true;},10);
	}else if (focusObj.type == "button"){
		setTimeout(function(){focusObj.focus();},10);
	}else{
		setTimeout(function(){focusObj.focus();focusObj.select();},10);
	}

}

/**
 * 메세지 창 닫기(함수 실행)
 *
 * @param event
 * @param execStr
 * @param focusObjName
 * @returns void
 */
function util_closeAlertWithExec(event, execStr, focusObjName){

	util_hideMessageAlert(document);
	util_hideExecutionLayer(document);

	if(focusObj != null){

		if (focusObj.type == "select-one") {
			setTimeout(function(){focusObj.focus();focusObj[0].selected = true;},10);
		}else{
			setTimeout(function(){focusObj.focus();focusObj.select();},10);
		}


	}else if(focusObjName != null){

		focusObj = document.getElementsByName(focusObjName)[0];

		if (focusObj.type == "select-one") {
			setTimeout(function(){focusObj.focus();focusObj[0].selected = true;},10);
		}else{
			setTimeout(function(){focusObj.focus();focusObj.select();},10);
		}

	}

	window.eval(execStr);

}

/**
 * 메세지 창(iframe), 포커스는 iframe으로
 *
 * @param paramMessage
 * @param paramFocusObj
 * @returns void
 */
function util_messageAlertOnParentFocusChild(paramMessage, paramFocusObjName, frameName, useId){

	parent.focusObj = null;

	util_appendLayerDiv(parent.document);

	var message = paramMessage;
	util_makeMessageAlertDivFocusChild(parent.document, paramMessage, paramFocusObjName, frameName, useId);

}

/**
 * DML 처리 결과
 *
 * @param resultMsg
 * @param destUrl
 * @returns void
 */
function util_showResult(resultMsg, destUrl,isSuccess){

	var documentObj = parent.document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);
	
	var htmlStr = "";
	
	if(isSuccess=="Y"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval3\">";
	}else if(isSuccess=="N"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval4\">";
	}else{
		htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	}
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + resultMsg + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_movePage('" + destUrl + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * DML 처리 결과
 *
 * @param resultMsg
 * @param destUrl
 * @returns void
 */
function util_showResultOnBody(resultMsg, destUrl){

	var documentObj = document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + resultMsg + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_movePage('" + destUrl + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");

}

/**
 * DML 처리 결과(팝업)
 *
 * @param resultMsg
 * @param destUrl
 * @returns void
 */
function util_showResultOnPopup(resultMsg, destUrl, isReturn,isSuccess){

	var documentObj = parent.document;

	util_appendLayerDivOnPopup(documentObj);

	var offsetObj = util_getContentsOffSetOnPopup(documentObj);
	var	htmlStr="";

	if(isSuccess=="Y"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval3\">";
	}else if(isSuccess=="N"){
		htmlStr += "	<div id=\"alert_main\" class=\"interval4\">";
	}else{
		htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	}
	
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + resultMsg + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(isReturn == "Y"){
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:fn_returnValues()\" value=\"" + confirmStr + "\">";		
	}else{
		htmlStr += "			<input class=\"btn\" id=\"messageAlertBtn\" type=\"button\" onclick=\"javascript:util_movePageOnPopup('" + destUrl + "')\" value=\"" + confirmStr + "\">";
	}
	htmlStr += "		</span>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "alert");
}

/**
 * 화면이동
 *
 * @param destUrl
 * @returns void
 */
function util_movePage(destUrl){

	parent.location.href = destUrl;

}

/**
 * 화면이동
 *
 * @param destUrl
 * @returns void
 */
function util_movePageOnPopup(destUrl){

	var form = document.getElementsByTagName("form")[0];
	form.submit();

}

/**
 * 선택 창
 *
 * @param paramHtmlStr
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_confirmAlert(paramHtmlStr, execStr, cancelExecStr){

	var documentObj = document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"confirmOkBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(true, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(cancelExecStr != null){
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "', '" + cancelExecStr + "' )\" value=\"" + cancelStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "')\" value=\"" + cancelStr + "\">";
	}
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";
	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "confirm");

}

/**
 * 선택 창(iframe)
 *
 * @param paramHtmlStr
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_confirmAlertOnParent(paramHtmlStr, execStr, cancelExecStr){

	var documentObj = parent.document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"confirmOkBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(true, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(cancelExecStr != null){
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "', '" + cancelExecStr + "' )\" value=\"" + cancelStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "')\" value=\"" + cancelStr + "\">";
	}
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "confirm");

}

/**
 * 선택 창(no submit)
 *
 * @param paramHtmlStr
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_confirmAlertNoSubmit(paramHtmlStr, execStr, cancelExecStr){

	var documentObj = document;

	util_appendLayerDiv(documentObj);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"confirmOkBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(true, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(cancelExecStr != null){
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(false, '" + execStr + "', '" + cancelExecStr + "' )\" value=\"" + cancelStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(false, '" + execStr + "')\" value=\"" + cancelStr + "\">";
	}
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "confirm");

}

/**
 * 선택 창(no submit, iframe)
 *
 * @param paramHtmlStr
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_confirmAlertNoSubmitOnParent(paramHtmlStr, execStr, cancelExecStr){

	var documentObj = parent.document;

	util_appendLayerDiv(parent.document);

	var offsetObj = util_getContentsOffSet(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"function_button\" id=\"confirmOkBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(true, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(cancelExecStr != null){
		htmlStr += "			<input class=\"function_button\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(false, '" + execStr + "', '" + cancelExecStr + "' )\" value=\"" + cancelStr + "\">";
	}else{
		htmlStr += "			<input class=\"function_button\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirmNoSubmit(false, '" + execStr + "')\" value=\"" + cancelStr + "\">";
	}
	htmlStr += "		</span>";
	htmlStr += "	</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "confirm");

}

/**
 * 선택 창(팝업)
 *
 * @param paramHtmlStr
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_confirmAlertOnPopup(paramHtmlStr, execStr, cancelExecStr){

	var documentObj = document;

	util_appendLayerDivOnPopup(documentObj);

	var offsetObj = util_getContentsOffSetOnPopup(documentObj);

	var htmlStr = "";
	htmlStr += "	<div id=\"alert_main\" class=\"interval2\">";
	htmlStr += "		<div class=\"pl49\" id=\"messageDiv\">";
	htmlStr += "			<p class=\"txt3 mb20 pl2 tL\">" + paramHtmlStr + "</p>";
	htmlStr += "		</div>";
	htmlStr += "		<div class=\"btnAreaTy1 pl49\">";
	htmlStr += "		<span class=\"btnTy4\">";
	htmlStr += "			<input class=\"btn\" id=\"confirmOkBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(true, '" + execStr + "')\" value=\"" + confirmStr + "\">";
	htmlStr += "		</span>";
	htmlStr += "		<span class=\"btnTy4\">";
	if(cancelExecStr != null){
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "', '" + cancelExecStr + "' )\" value=\"" + cancelStr + "\">";
	}else{
		htmlStr += "			<input class=\"btn\" id=\"comfirmCancelBtn\" type=\"button\" onclick=\"javascript:util_selectConfirm(false, '" + execStr + "')\" value=\"" + cancelStr + "\">";
	}
	
	htmlStr += "		</span>";
	htmlStr += "		</div>";
	htmlStr += "	</div>";

	util_getMessageAlertDiv(documentObj, htmlStr, offsetObj.messageAlertLeft, offsetObj.messageAlertTop, "confirm");

}


/**
 * confirm 선택
 *
 * @param confirmFlag
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_selectConfirm(confirmFlag, execStr, cancelExecStr){

	util_hideMessageAlert(document);
	util_hideExecutionLayer(document);

	if(confirmFlag){

		if(document.getElementById("contents") != null){
			util_showExecutionImage();
		}else{
			util_showExecutionImageOnPopup();
		}
		window.eval(execStr);

	}else{

		//util_hideExecutionLayer(document);

		if(cancelExecStr != null){
			window.eval(cancelExecStr);
		}

	}

}

/**
 * confirm 선택(no submit)
 *
 * @param confirmFlag
 * @param execStr
 * @param cancelExecStr
 * @returns void;
 */
function util_selectConfirmNoSubmit(confirmFlag, execStr, cancelExecStr){

	util_hideExecutionAll(document);

	if(confirmFlag){

		window.eval(execStr);

	}else{

		if(cancelExecStr != null){
			window.eval(cancelExecStr);
		}

	}

}

/**
 * frame 폼의 값을 parent 폼에 입력
 *
 * @param parentForm
 * @param childform
 * @param checkObjectName
 * @param targetObjects
 * @returns void
 */
function util_moveToParentFormWithChecked(parentForm, childform, checkObjectName, targetObjects){

	var checkObjects = document.getElementsByName(checkObjectName);

	var checkedIndex = 0;
	for(var i = 0; i < checkObjects.length; i++){

		if(checkObjects[i].checked){

			for(var j = 0; j < targetObjects.length; j++){

				var tempObj = document.getElementsByName(targetObjects[j])[i];

				if(tempObj != null){

					// 부모한테 같은 object가 있으면 삭제 시작
					parentObjs = parent.document.getElementsByName(tempObj.name);

					if(parentObjs != null &&
					   parentObjs[checkedIndex] != null){

						parentObjs[checkedIndex].value = tempObj.value;

					}else{

						var parentTempObj = parent.document.createElement("input");
						parentTempObj.type = "hidden";
						parentTempObj.name = tempObj.name;
						parentTempObj.value = tempObj.value;

						parentForm.appendChild(parentTempObj);

					}

				}

			}

			var tempCheckObj = parent.document.createElement("input");
			tempCheckObj.type = "hidden";
			tempCheckObj.name = checkObjects[i].name;
			tempCheckObj.value = checkedIndex;

			parentForm.appendChild(tempCheckObj);

			checkedIndex++;

		}

	}

}
