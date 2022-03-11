var compSearchConditions = "";
var elementIndex = 0;

/**
 * compSearchConditions 에 폼 엘리먼트 값 입력
 * 
 * @param 자식 노드 배열
 * @return void
 */
function util_addElementValue(targetChildNodes){

	for ( var i = 0; i < targetChildNodes.length; i++) {

		// searchCondition -> 폼 엘리먼트값, currentPageNo -> 다른 페이지를 보게 되므로 비교하면 안된다.
		if(targetChildNodes[i].name != "searchConditions" &&
		   targetChildNodes[i].name != "currentPageNo"){

			if(targetChildNodes[i].value != null){

				if(targetChildNodes[i].type == "checkbox" ||
				   targetChildNodes[i].type == "radio"){
					compSearchConditions += "[sep]" + targetChildNodes[i].name + "[sep]" + targetChildNodes[i].checked;
				}else if(targetChildNodes[i].type == "text" ||
						 targetChildNodes[i].type == "textarea" ||
						 targetChildNodes[i].type == "hidden" ||
						 targetChildNodes[i].type == "select-one"){
					compSearchConditions += "[sep]" + targetChildNodes[i].name + "[sep]" + targetChildNodes[i].value;
				}
			}

			/*
			 * 재귀호출
			 */
			if(targetChildNodes[i].hasChildNodes() &&
			   targetChildNodes[i].type != "select-one"){

				util_addElementValue(targetChildNodes[i].childNodes);

			}

		}

	}

}

/**
 * compSearchConditions에서 input object의 인덱스에 해당하는 값을 가져온다.
 * 
 * @param elementIndex
 * @param compSearchConditions
 * @return void
 */
function util_splitElementValue(elementIndex, compSearchConditions){

	var sts = compSearchConditions.split("[sep]");
	return sts[1 + (elementIndex * 2) + 1];

}

/**
 * 폼 엘리먼트 값 초기화
 * 
 * @param targetChildNodes
 * @param compSearchConditions
 * @return void
 */
function util_initFormValue(targetChildNodes, searchConditions){


	for ( var i = 0; i < targetChildNodes.length; i++) {

		// searchCondition -> 폼 엘리먼트값, currentPageNo -> 다른 페이지를 보게 되므로 비교하면 안된다.
		if(targetChildNodes[i].name != "searchConditions" &&
		   targetChildNodes[i].name != "currentPageNo"){

			if(targetChildNodes[i].type == "checkbox"){

				var tempValue = util_splitElementValue(elementIndex, searchConditions);
				if(tempValue == "true"){
					targetChildNodes[i].checked = true;
				}else{
					targetChildNodes[i].checked = false;
				}
				elementIndex++;

			}else if(targetChildNodes[i].type == "radio"){

				var tempValue = util_splitElementValue(elementIndex, searchConditions);
				if(tempValue == "true"){
					targetChildNodes[i].checked = true;
				}else{
					targetChildNodes[i].checked = false;
				}
				elementIndex++;

			}else if(targetChildNodes[i].type == "text" ||
					 targetChildNodes[i].type == "textarea" ||
					 targetChildNodes[i].type == "hidden" ||
					 targetChildNodes[i].type == "select-one"){

				var tempValue = util_splitElementValue(elementIndex, searchConditions);
				targetChildNodes[i].value = tempValue;
				elementIndex++;

			}

			/*
			 * 재귀호출
			 */
			if(targetChildNodes[i].hasChildNodes() &&
			   targetChildNodes[i].type != "select-one"){
				util_initFormValue(targetChildNodes[i].childNodes, searchConditions);

			}

		}

	}

}


/**
 * onload때 부모 프레임에 compSearchConditions 에 폼 엘리먼트 값 입력
 * 
 * @param 부모 폼이름
 * @return void
 */
function util_initCompSearchConditions(formName){

	var formObj = parent.document.getElementsByName(formName)[0];
	util_addElementValue(formObj.childNodes);
	formObj.searchConditions.value = compSearchConditions;
	compSearchConditions = "";

}

/**
 * onload때 현재 프레임에 있는 compSearchConditions 에 폼 엘리먼트 값 입력
 * 
 * @param 폼이름
 * @return void
 */
function util_initCompSearchConditionsCurrentFrame(formName){

	var formObj = document.getElementsByName(formName)[0];
	util_addElementValue(formObj.childNodes);
	formObj.searchConditions.value = compSearchConditions;
	compSearchConditions = "";

}

/**
 * onload때 현재 프레임에 있는 compSearchConditions 에 폼 엘리먼트 값 입력
 * 
 * @param 부모 폼이름
 * @return void
 */
function util_checkSearchConditions(formName){

	var formObj = parent.document.getElementsByName(formName)[0];
	var targetChildNodes = formObj.childNodes;

	// compSearchConditions 에 폼 엘리먼트 값 입력
	util_addElementValue(targetChildNodes);

	// 폼에 있는 엘리먼트키/값 스트링과 searchConditions의 값이 일치하지 않는 경우
	if(formObj.searchConditions.value != compSearchConditions){

		checkResult = false;
		elementIndex = 0;
		util_initFormValue(targetChildNodes, formObj.searchConditions.value);

	}

	compSearchConditions = "";

}