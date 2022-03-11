/**
 * 특수문자를 제하고 숫자인지 체크
 *
 * @param String
 * @returns {Boolean}
 */
function util_isNumber(s) {
	
	var mask = "^[0-9]*\\" + caliberPoint + "?[0-9]*$";
	
	var regPat = new RegExp(mask);
	
	s += ''; // 문자열로 변환
	s = s.replace(/^\s*|\s*$/g, ''); // 좌우 공백 제거
	var result = matchPattern(s, regPat);

	if(result == null){
	
		return false;
		
	}
	
	return true;
}

// Trim whitespace from left and right sides of s.
function trim(s) {
    return s.replace( /^\s*/, "" ).replace( /\s*$/, "" );
}

/**
 * strTemp의 전체 strValue1을 strValue2로 변경
 *
 * @param strTemp
 * @param strValue1
 * @param strValue2
 * @return strTemp의 전체 strValue1을 strValue2로 변경 후 리턴
 */
function replaceAll(strTemp, strValue1, strValue2){

    while(1){
        if( strTemp.indexOf(strValue1) != -1 )
            strTemp = strTemp.replace(strValue1, strValue2);
        else
            break;
    }
    return strTemp;
}

/**
 * 유효한 정수타입인지 확인
 *
 * @param date object
 * @param message
 * @return void
 */
function util_checkIntNumberFormat(intObj, hiddenObj){
	
	if(intObj.value == ""){
		hiddenObj.value = "";
		return true;
	}
	
	util_addSeparater(intObj, hiddenObj);

}

/**
 * 유효한 금액타입인지 확인
 *
 * @param date object
 * @param message
 * @return void
 */
function util_checkFloatNumberFormat(floatObj, hiddenObj, pos, isRound, messageStr){

	if(floatObj.value.substring(0, 1) == "0" && floatObj.value.indexOf(caliberPoint) == -1 && floatObj.value.length > 1){
		if(messageStr == null){
			util_messageAlert(invalidMoneyMessage, floatObj);
		}else{
			util_messageAlert(messageStr, floatObj);
		}
		
		return false;
	}
	
	if(floatObj.value == ""){
		hiddenObj.value = "";
		return true;
	}
	
	if(!util_isNumber(floatObj.value, caliberPoint, "")){
		if(messageStr == null){
			util_messageAlert(invalidMoneyMessage, floatObj);
		}else{
			util_messageAlert(messageStr, floatObj);
		}
		
		return false;
	}
	
	if(Number(floatObj.value) < 0){
		if(messageStr == null){
			util_messageAlert(invalidMoneyMessage, floatObj);
		}else{
			util_messageAlert(messageStr, floatObj);
		}
		
		return false;
	}
		
	if(isRound){
		if(!util_round(floatObj, pos)){
		    return false;
        }
	}else{
		
		var floatValue = floatObj.value.split(caliberPoint)[1];
		var intValue = Number(floatObj.value.split(caliberPoint)[0]);

		if(floatValue != null &&
		   floatValue.length > pos){
			
			if(messageStr == null){
				util_messageAlert(invalidDecimalMessage.replace("{1}", pos), floatObj);
			}else{
				util_messageAlert(messageStr, floatObj);
			}
			
			return false;
		}
		
		floatObj.value = intValue + caliberPoint + floatValue;
		
	}
	
    util_addSeparater(floatObj, hiddenObj);
    
    return true;

}

/**
 * 유효한 금액타입인지 확인
 *
 * @param date object
 * @param message
 * @return void
 */
function util_checkFloatNumberFormatOnChild(floatObj, hiddenObj, pos, isRound, frameName, messageStr, useId){
	
	if(floatObj.value.substring(0, 1) == "0" && floatObj.value.indexOf(caliberPoint) == -1 && floatObj.value.length > 1){
		if(useId != null && useId == "Y"){
			util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.getAttribute("id"), frameName, "Y");
		}else{
			util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.name, frameName);
		}
		return false;
	}
	
	if(floatObj.value == ""){
		hiddenObj.value = "";
		return true;
	}
	
	if(Number(floatObj.value) < 0){
		
		if(messageStr == null){
			
			if(useId != null && useId == "Y"){
				util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.getAttribute("id"), frameName, "Y");
			}else{
				util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.name, frameName);
			}
			
		}else{
			
			if(useId != null && useId == "Y"){
				util_messageAlertOnParentFocusChild(messageStr, floatObj.getAttribute("id"), frameName, "Y");
			}else{
				util_messageAlertOnParentFocusChild(messageStr, floatObj.name, frameName);
			}
			
		}
		
		return false;
	}
		
	if(!util_isNumber(floatObj.value)){

		if(messageStr == null){
			
			if(useId != null && useId == "Y"){
				util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.getAttribute("id"), frameName, "Y");
			}else{
				util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.name, frameName);
			}
			
		}else{
			
			if(useId != null && useId == "Y"){
				util_messageAlertOnParentFocusChild(messageStr, floatObj.getAttribute("id"), frameName, "Y");
			}else{
				util_messageAlertOnParentFocusChild(messageStr, floatObj.name, frameName);
			}
			
		}
		
		return false;
	}
	
	if(isRound){
		if(!util_round(floatObj, pos)){
		    return false;
        }
	}else{
		
		var floatValue = floatObj.value.split(caliberPoint)[1];
		
		if(floatValue != null &&
		   floatValue.length > pos){
			
			if(messageStr == null){
				
				if(useId != null && useId == "Y"){
					util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.getAttribute("id"), frameName, "Y");
				}else{
					util_messageAlertOnParentFocusChild(invalidMoneyMessage, floatObj.name, frameName);
				}
				
			}else{
				
				if(useId != null && useId == "Y"){
					util_messageAlertOnParentFocusChild(messageStr, floatObj.getAttribute("id"), frameName, "Y");
				}else{
					util_messageAlertOnParentFocusChild(messageStr, floatObj.name, frameName);
				}
				
			}
			
			return false;
		}
		
	}

    util_addSeparater(floatObj, hiddenObj);
    
    return true;

}

/**
 * 반올림
 * @param 소스 오브젝트
 * @returns void
 */
function util_round(obj, pos){
	
	var result = true;

	var intValue = obj.value.split(caliberPoint)[0];
	var floatValue = obj.value.split(caliberPoint)[1];
	
	if(intValue.length > 17 - (pos + 2)){
		util_messageAlert(invalidDigitMessage.replace("{0}", 17 - (pos + 2)).replace("{1}", pos), obj);
		result =  false;
	}else{
		var posV = Math.pow(10, (pos ? pos : 2));
		
		if(caliberPoint != "."){
			obj.value = replaceAll(obj.value, caliberPoint, ".");
		}
		
		obj.value = Math.round(parseFloat(obj.value)*posV)/posV;
		
		if(caliberPoint != "."){
			obj.value = replaceAll(obj.value, ".", caliberPoint);
		}
		
	}
	
	return result;
	
}

/**
 * 숫자에  seperator 추가
 *
 * @param date object
 * @return void
 */
function util_addSeparater(strObj, hiddenObj){
	
	strObj.value = strObj.value.replaceAll(caliberSeparater, '');
	if(caliberPoint != "."){
		hiddenObj.value = replaceAll(strObj.value, caliberPoint, ".");	//hidden값에 값 설정
	}else{
		hiddenObj.value = strObj.value;	//hidden값에 값 설정
	}
	
	//단위 붙이기
	var countInt = 0;
	var countPoint = 0;

	if(strObj.value.indexOf(caliberPoint) > -1){
		countInt = strObj.value.substring(0, strObj.value.indexOf(caliberPoint));
		countPoint = strObj.value.substring(strObj.value.indexOf(caliberPoint) + 1);
	}else{
		countInt = strObj.value;
	}

	strObj.value = "";
	var unitCount = 0;
	for(var i = countInt.length ; i >0 ; i-=caliberDigits){

		var tempMoney = (countInt.substring(i-caliberDigits, i));

		if(unitCount > 0){
			strObj.value = String(tempMoney) + caliberSeparater + strObj.value;
		}else{
			strObj.value = String(tempMoney) + strObj.value;
		}
		unitCount++;

	}

	if(countPoint > 0){
		strObj.value += caliberPoint + countPoint;
	}
	
}

/**
 * 전화번호 포맷으로
 *
 * @param telNo object
 * @param message
 * @param telNo hidden object
 * @return void
 */
function util_checkTelNoFormat(telNoObj, message, telNoObjHidden){

	if(telNoObj.value == ""){

		telNoObjHidden.value = "";
		return;
	}

	if(!util_isNumber(telNoObj.value) || telNoObj.value.length != 8){

		util_messageAlert(message, telNoObj);
		//setTimeout(function(){dateObj.focus();dateObj.select();},10);

	}else{

		telNoObj.value = telNoObj.value.substring(0, 2) + " " + telNoObj.value.substring(2, 5) + " " +  telNoObj.value.substring(5, 8);

	}

	if(telNoObjHidden != null && telNoObjHidden.type == "hidden"){

		telNoObjHidden.value = telNoObj.value.substring(0, 2) + telNoObj.value.substring(3, 5) + telNoObj.value.substring(6, 8) + telNoObj.value.substring(9, 11);
	
	}

}

/**
 * 숫자에  seperator 추가
 *
 * @param date object
 * @return void
 */
function util_addFloatSeparater(floatValue){
	
	var returnStr = "";
	
	//단위 붙이기
	var countInt = 0;
	var countPoint = 0;
	
	if(floatValue.indexOf(".") > -1){
		countInt = floatValue.substring(0, floatValue.indexOf("."));
		countPoint = floatValue.substring(floatValue.indexOf(".") + 1);
	}else{
		countInt = floatValue;
	}

	floatValue = "";
	var unitCount = 0;
	
	for(var i = countInt.length ; i >0 ; i-=caliberDigits){
		
		var tempMoney = (countInt.substring(i-caliberDigits, i));

		if(unitCount > 0){
			floatValue = String(tempMoney) + caliberSeparater + floatValue;
		}else{
			floatValue = String(tempMoney) + floatValue;
		}
		unitCount++;

	}

	if(countPoint > 0){
		floatValue += caliberPoint + countPoint;
	}
	
	
	return floatValue;
	
}

/**
 * 숫자에  seperator 삭제
 *
 * @param date object
 * @return void
 */
function util_removeFloatSeparater(floatValueStr){
	
	var returnValue = floatValueStr;
	returnValue = returnValue.replaceAll(caliberSeparater, "");
	
	if(caliberPoint != "."){
		returnValue = returnValue.replaceAll(caliberPoint, ".");
	}
	
	return returnValue;
	
}

