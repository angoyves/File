/**
 * 키를 누를때 값 삭제
 *
 * @param object
 * @param event
 * @returns void
 */
function util_deletePressed_S(obj, event){

	if(event.keyCode == 46){
		obj.value = "";
	}

}

/**
 * 키를 누를때 값 삭제
 *
 * @param object1
 * @param object2
 * @param event
 * @returns void
 */
function util_deletePressed_D(obj1, obj2, event){

	if(event.keyCode == 46){
		obj1.value = "";
		obj2.value = "";
	}

}

/**
 * 엔터 친 경우 조회
 *
 * @param event
 * @param 함수 이름
 * @returns void
 */
function util_enterKeySearch(event, funcName){

	if(event.keyCode == 13){
		window.eval(funcName);
	}

}

/**
 * 엔터 친 경우 마스크 확인 후 조회
 *
 * @param object
 * @param event
 * @param 함수 이름
 * @param 마스크
 * @param 포커스를 옮길 오브젝트
 * @returns void
 */
function util_enterKeySearchWithCheckMask(obj, event, funcName, maskStr, targetObj){

	// 엔터 친 경우
	if(event.keyCode == 13){

		// 패스여부 플래그
		var isPass = true;

		// 마스크 체크
		var regPat = new RegExp(maskStr);
		var result = matchPattern(obj.value, regPat);

		// 마스크에 통과 안된 경우
		if(result == null){

			targetObj.focus();
			isPass = false;

		}

		// 패스통과 하면 조회 쿼리 실행
		if(isPass){

			window.eval(funcName);

		}

	}

}

/**
 * 엔터 친 경우 길이 확인 후 조회
 *
 * @param object
 * @param event
 * @param 함수 이름
 * @param 길이
 * @param 포커스를 옮길 오브젝트
 * @returns void
 */
function util_enterKeySearchWithCheckLength(obj, event, funcName, length, targetObj){

	// 엔터 친 경우
	if(event.keyCode == 13){

		// 패스여부 플래그
		var isPass = true;

		// 길이 체크 시작
		var valueSize = 0;
		for ( var i = 0; i < obj.value.length; i++) {

			var charCode = obj.value.charCodeAt(i);

			// 한글이 아닌 경우
			if( !( ( 0xAC00 <= charCode && charCode <= 0xD7A3 ) || ( 0x3131 <= charCode && charCode <= 0x318E ) ) ) {
				valueSize++;
		    }
			// 한글인 경우 오라클에서는 UTF-8이 3바이트 처리된
			else{
				valueSize+=3;
		    }

		}

		// 길이 초과시
		if(valueSize > length){

			targetObj.focus();
			isPass = false;

		}

		// 패스통과 하면 조회 쿼리 실행
		if(isPass){

			window.eval(funcName);

		}

	}

}

/**
 * 엔터 친 경우 마스크, 길이 확인 후 조회
 *
 * @param object
 * @param event
 * @param 함수 이름
 * @param 마스크
 * @param 길이
 * @param 포커스를 옮길 오브젝트
 * @returns void
 */
function util_enterKeySearchWithCheckValidation(obj, event, funcName, maskStr, length, targetObj){

	// 엔터 친 경우
	if(event.keyCode == 13){

		// 패스여부 플래그
		var isPass = true;

		// 마스크 체크
		var regPat = new RegExp(maskStr);
		var result = matchPattern(obj.value, regPat);

		// 마스크에 통과 안된 경우
		if(result == null){

			targetObj.focus();
			isPass = false;

		}

		// 길이 체크 시작
		var valueSize = 0;
		for ( var i = 0; i < obj.value.length; i++) {

			var charCode = obj.value.charCodeAt(i);

			// 한글이 아닌 경우
			if( !( ( 0xAC00 <= charCode && charCode <= 0xD7A3 ) || ( 0x3131 <= charCode && charCode <= 0x318E ) ) ) {
				valueSize++;
		    }
			// 한글인 경우 오라클에서는 UTF-8이 3바이트 처리된
			else{
				valueSize+=3;
		    }

		}

		// 길이 초과시
		if(valueSize > length){

			targetObj.focus();
			isPass = false;

		}

		// 패스통과 하면 조회 쿼리 실행
		if(isPass){

			window.eval(funcName);

		}

	}

}

/**
 * 폼에 있는 필수 텍스트 오브젝트의 trim 처리
 *
 * @param void
 * @returns void
 */
function util_trimRequiredValue(){

	var quoStrs = String(required).split("\"");

	for(var i = 1; i < quoStrs.length; i+=8){

		var tagName = quoStrs[i];
		var inputObjs = document.getElementsByTagName("input");

		for(var j = 0; j < inputObjs.length; j++){

			if(inputObjs[j].type == "text" &&
			   inputObjs[j].name == tagName){

				inputObjs[j].value = inputObjs[j].value.trim();

			}

		}

		inputObjs = document.getElementsByTagName("textarea");

		for(var j = 0; j < inputObjs.length; j++){

			if(inputObjs[j].name == tagName){

				inputObjs[j].value = inputObjs[j].value.trim();

			}

		}

	}

}


/**
 * 날짜형의 스트링을 숫자형으로 변경
 *
 * @param date object
 * @return void
 */
function util_setDateFormat(dateObj){

	dateObj.value = dateObj.value.replaceAll(dateSeparater, "");
	dateObj.select();

}

/**
 * 전화번호의 스트링을 숫자형으로 변경
 *
 * @param date object
 * @return void
 */
function util_setTelNoFormat(telNoObj){

	telNoObj.value = telNoObj.value.replaceAll(" ", "");
	telNoObj.select();

}

/**
 * 화폐형의 스트링을 숫자형으로 변경
 *
 * @param date object
 * @return void
 */
function util_setMoneyFormat(moneyObj){

	moneyObj.value = moneyObj.value.replaceAll(caliberSeparater, "");
	moneyObj.select();

}


