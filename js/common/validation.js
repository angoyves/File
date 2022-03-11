
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
 * properties의 배열 메세지에서 필요한 메세지만 추출한다.
 *
 * @param paramMessage
 * @param targetField
 * @return properties의 배열 메세지에서 필요한 메세지만 추출한다.
 */
function extractMessage(obj, type){

	var messageArray;
	var resultMessage = "";

	if(type == "mask"){

		messageArray = new mask();

	}else if(type == "maxlength"){

		messageArray = new maxlength();

	}

    for (x in messageArray) {

    	if(obj.name == messageArray[x][0]){

    		if(obj.getAttribute("valName") != null){
    			resultMessage = obj.getAttribute("valName") + messageArray[x][1];
    		}else{
    			resultMessage = messageArray[x][1];
    		}

    	}

    }

    return resultMessage;


}

/**
 * 필수 확인
 *
 * @param 폼
 * @return 필수값이 입력되었는지 여부
 */
function validateRequired(form) {
    var isValid = true;
    var focusField = null;
    var i = 1;
    var fields = new Array();
    
    
    fields[0] = requiredMessage;
    oRequired = new required();

    for (x in oRequired) {
    	var field = form[oRequired[x][0]];
    	if (typeof(field) == 'undefined') {
    		continue;
    	}



    	// 배열일 경우
    	if(field.length > 1 &&
    	   (field[0].type == "text" ||
    	    field[0].type == "textarea")){

    		for(var j = 0; j < field.length; j++){

    			var targetField = field[j];

    			var value = targetField.value;

	            if (trim(value).length == 0) {

	                if (i == 1) {
	                	if (targetField.type != 'hidden') {
	                    	focusField = targetField;
	                    }
	                }

	                var isDuplicated = false;
	                var tempMessage = "";

	                if(targetField.getAttribute("valName") != null){
	                	tempMessage = targetField.getAttribute("valName") + oRequired[x][1];
	        		}else{
	        			tempMessage = oRequired[x][1];
	        		}

	                for(var k = 0; k <= i; k++){

	                	if(fields[k] == tempMessage){

	                		isDuplicated = true;

	                	}

	                }

	                if(!isDuplicated){
	                	fields[i++] = tempMessage;
	                }

	                isValid = false;
	            }

    		}

    	}else {

    		if (field.type == 'text' ||
	    	    field.type == 'textarea' ||
	            field.type == 'file' ||
	            field.type == 'select-one' ||
	            field.type == 'radio' ||
	            field.type == 'password' ||
	            field.type == 'hidden') {

	            var value = '';
				// get field's value
				if (field.type == "select-one") {
					var si = field.selectedIndex;
					if (si >= 0) {
						value = field.options[si].value;
					}
				} else {
					value = field.value;
				}

	            if (trim(value).length == 0) {

	                if (i == 1) {
	                	if (field.type != 'hidden') {
	                    	focusField = field;
	                    }
	                }
	                fields[i++] = oRequired[x][1];
	                isValid = false;
	            }
	      	} else if (form[oRequired[x][0]][0].type == 'radio') {
				var radioChecked = false;
				for (var j=0; j<form[oRequired[x][0]].length; j++) {
					if (form[oRequired[x][0]][j].checked) {
	                    radioChecked = true;
	                    break;
					}
				}
				if (!radioChecked) {
					if (i == 1) {
						focusField = form[oRequired[x][0]][0];
					}
					fields[i++] = oRequired[x][1];
					isValid = false;
				}
	        }

    	}

    }

    if (fields.length > 1) {
    	if (focusField != null) {
    		/*if (focusField.type == "select-one") {
    			setTimeout(function(){focusField.focus();focusField[0].selected = true;},10);
    		}else{
    			setTimeout(function(){focusField.focus();focusField.select();},10);
    		}*/
    		util_messageAlert(fields.join('<br>'), focusField);
       	}else{
       		util_messageAlert(fields.join('<br>'));
       	}

    }
    return isValid;
}

/**
 * Max Length 확인
 *
 * @param 폼
 * @return Max Length 넘지 않았는지 여부
 */
function validateMaxLength(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oMaxLength = new maxlength();
    for (x in oMaxLength) {
        var field = form[oMaxLength[x][0]];

        if (field != null &&
        	(field.type == 'text' ||
             field.type == 'textarea' ||
             field.type == 'password')) {

            var iMax = parseInt(oMaxLength[x][2]("maxlength"));
            if (field.value.length > iMax) {
                if (i == 0) {
                    focusField = field;
                }
                fields[i++] = oMaxLength[x][1];
                isValid = false;
            }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return isValid;
}

/**
 * Min Length 확인
 *
 * @param 폼
 * @return Min Length 넘지 않았는지 여부
 */
function validateMinLength(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oMinLength = new minlength();
    for (x in oMinLength) {
        var field = form[oMinLength[x][0]];

        if (field != null &&
            (field.type == 'text' ||
            field.type == 'textarea' ||
            field.type == 'password')) {

            var iMin = parseInt(oMinLength[x][2]("minlength"));
            if ((trim(field.value).length > 0) && (field.value.length < iMin)) {
                if (i == 0) {
                    focusField = field;
                }
                fields[i++] = oMinLength[x][1];
                isValid = false;
            }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return isValid;
}

function matchPattern(value, mask) {
   return mask.exec(value);
}

/**
 * check 확인
 *
 * @param 폼
 * @return check가 유효한지 여부
 */
function validateMask(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oMasked = new mask();
    for (x in oMasked) {
        var field = form[oMasked[x][0]];

        if (field != null &&
             (field.type == 'text' ||
             field.type == 'textarea' ||
             field.type == 'password') &&
             (field.value.length > 0)) {

            if (!matchPattern(field.value, oMasked[x][2]("mask"))) {
                if (i == 0) {
                    focusField = field;
                }
                fields[i++] = oMasked[x][1];
                isValid = false;
            }
        }
    }

    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return isValid;
}

/**
 * float 확인
 *
 * @param 폼
 * @return float값이 유효한지 여부
 */
function validateFloat(form) {
    var bValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oFloat = new FloatValidations();
    for (x in oFloat) {
    	var field = form[oFloat[x][0]];

        if (field != null &&
        	(field.type == 'text' ||
            field.type == 'textarea' ||
            field.type == 'select-one' ||
            field.type == 'radio')) {

        	var value = '';
			// get field's value
			if (field.type == "select-one") {
				var si = field.selectedIndex;
				if (si >= 0) {
				    value = field.options[si].value;
				}
			} else {
				value = field.value;
			}

            if (value.length > 0) {
                // remove '.' before checking digits
                var tempArray = value.split('.');
                var joinedString= tempArray.join('');

                if (!isAllDigits(joinedString)) {
                    bValid = false;
                    if (i == 0) {
                        focusField = field;
                    }
                    fields[i++] = oFloat[x][1];

                } else {
                    var iValue = parseFloat(value);
                    if (isNaN(iValue)) {
                        if (i == 0) {
                            focusField = field;
                        }
                        fields[i++] = oFloat[x][1];
                        bValid = false;
                    }
                }
            }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return bValid;
}

/**
 * 숫자여부 확인
 *
 * @param 숫자여부를 확인해야 하는 값
 * @return 숫자여부
 */
function isAllDigits(argvalue) {
    argvalue = argvalue.toString();
    var validChars = "0123456789";
    var startFrom = 0;
    if (argvalue.substring(0, 2) == "0x") {
       validChars = "0123456789abcdefABCDEF";
       startFrom = 2;
    } else if (argvalue.charAt(0) == "0") {
       validChars = "0123456789";
       startFrom = 1;
    } else if (argvalue.charAt(0) == "-") {
        startFrom = 1;
    }

    for (var n = startFrom; n < argvalue.length; n++) {
        if (validChars.indexOf(argvalue.substring(n, n+1)) == -1) return false;
    }
    return true;
}

/**
 * integer 확인
 *
 * @param 폼
 * @return integer값이 유효한지 여부
 */
function validateInteger(form) {
    var bValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oInteger = new IntegerValidations();
    for (x in oInteger) {
    	var field = form[oInteger[x][0]];

        if (field != null &&
        	(field.type == 'text' ||
            field.type == 'textarea' ||
            field.type == 'select-one' ||
            field.type == 'radio')) {

            var value = '';
			// get field's value
			if (field.type == "select-one") {
				var si = field.selectedIndex;
			    if (si >= 0) {
				    value = field.options[si].value;
			    }
			} else {
				value = field.value;
			}

            if (value.length > 0) {

                if (!isAllDigits(value)) {
                    bValid = false;
                    if (i == 0) {
                        focusField = field;
                    }
			        fields[i++] = oInteger[x][1];

                } else {
                    var iValue = parseInt(value);
                    if (isNaN(iValue) || !(iValue >= -2147483648 && iValue <= 2147483647)) {
                        if (i == 0) {
                            focusField = field;
                        }
                        fields[i++] = oInteger[x][1];
                        bValid = false;
                   }
               }
           }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return bValid;
}

/**
 * float range 확인
 *
 * @param 폼
 * @return float range값이 유효한지 여부
 */
function validateFloatRange(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oRange = new floatRange();
    for (x in oRange) {
        var field = form[oRange[x][0]];

        if (field != null &&
        	 (field.type == 'text' ||
             field.type == 'textarea') &&
            (field.value.length > 0)) {

            var fMin = parseFloat(oRange[x][2]("min"));
            var fMax = parseFloat(oRange[x][2]("max"));
            var fValue = parseFloat(field.value);
            if (!(fValue >= fMin && fValue <= fMax)) {
                if (i == 0) {
                    focusField = field;
                }
                fields[i++] = oRange[x][1];
                isValid = false;
            }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return isValid;
}

/**
 * int range 확인
 *
 * @param 폼
 * @return int range값이 유효한지 여부
 */
function validateIntRange(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oRange = new intRange();
    for (x in oRange) {
        var field = form[oRange[x][0]];

        if (field != null &&
        	(field.type == 'text' ||
             field.type == 'textarea') &&
            (field.value.length > 0)) {

            var iMin = parseInt(oRange[x][2]("min"));
            var iMax = parseInt(oRange[x][2]("max"));
            var iValue = parseInt(field.value);
            if (!(iValue >= iMin && iValue <= iMax)) {
                if (i == 0) {
                    focusField = field;
                }
                fields[i++] = oRange[x][1];
                isValid = false;
            }
        }
    }
    if (fields.length > 0) {
    	//setTimeout(function(){focusField.focus();focusField.select();},10);
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return isValid;
}

/**
 * email 확인
 *
 * @param 스트링
 * @return email값이 유효한지 여부
 */
function checkEmail(emailStr) {
   if (emailStr.length == 0) {
       return true;
   }
   var emailPat=/^(.+)@(.+)$/;
   var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
   var validChars="\[^\\s" + specialChars + "\]";
   var quotedUser="(\"[^\"]*\")";
   var ipDomainPat=/^(\d{1,3})[.](\d{1,3})[.](\d{1,3})[.](\d{1,3})$/;
   var atom=validChars + '+';
   var word="(" + atom + "|" + quotedUser + ")";
   var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
   var domainPat=new RegExp("^" + atom + "(\\." + atom + ")*$");
   var matchArray=emailStr.match(emailPat);
   if (matchArray == null) {
       return false;
   }
   var user=matchArray[1];
   var domain=matchArray[2];
   if (user.match(userPat) == null) {
       return false;
   }
   var IPArray = domain.match(ipDomainPat);
   if (IPArray != null) {
       for (var i = 1; i <= 4; i++) {
          if (IPArray[i] > 255) {
             return false;
          }
       }
       return true;
   }
   var domainArray=domain.match(domainPat);
   if (domainArray == null) {
       return false;
   }
   var atomPat=new RegExp(atom,"g");
   var domArr=domain.match(atomPat);
   var len=domArr.length;
   if ((domArr[domArr.length-1].length < 2) ||
       (domArr[domArr.length-1].length > 3)) {
       return false;
   }
   if (len < 2) {
       return false;
   }
   return true;
}

/**
 * email 확인
 *
 * @param object
 * @return email값이 유효한지 여부
 */
function util_checkEmailObj(obj, maxlength){

	var returnStr = "";

	if(!checkEmail(obj.value)){

		var quoStrs = String(email).split("\"");
		for(var i = 0; i < quoStrs.length; i++){

			if(quoStrs[i] == obj.name){
				returnStr += unescape(replaceAll(quoStrs[i + 2],"\\","%"));

			}

		}

	}

	var checkLengthReturnStr = util_checkLengthStr(obj, maxlength);

	if(checkLengthReturnStr != ""){
		if(returnStr != ""){
			returnStr += "<br>====================<br>" + checkLengthReturnStr;
		}else{
			returnStr += checkLengthReturnStr;
		}
	}

	if(returnStr != ""){

		util_messageAlert(returnStr, obj);

	}


}

/**
 * email 확인
 *
 * @param string
 * @return email값이 유효한지 여부
 */
function checkEmail(emailStr) {
   if (emailStr.length == 0) {
       return true;
   }
   var emailPat=/^(.+)@(.+)$/;
   var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
   var validChars="\[^\\s" + specialChars + "\]";
   var quotedUser="(\"[^\"]*\")";
   var ipDomainPat=/^(\d{1,3})[.](\d{1,3})[.](\d{1,3})[.](\d{1,3})$/;
   var atom=validChars + '+';
   var word="(" + atom + "|" + quotedUser + ")";
   var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
   var domainPat=new RegExp("^" + atom + "(\\." + atom + ")*$");
   var matchArray=emailStr.match(emailPat);
   if (matchArray == null) {
       return false;
   }
   var user=matchArray[1];
   var domain=matchArray[2];
   if (user.match(userPat) == null) {
       return false;
   }
   var IPArray = domain.match(ipDomainPat);
   if (IPArray != null) {
       for (var i = 1; i <= 4; i++) {
          if (IPArray[i] > 255) {
             return false;
          }
       }
       return true;
   }
   var domainArray=domain.match(domainPat);
   if (domainArray == null) {
       return false;
   }
   var atomPat=new RegExp(atom,"g");
   var domArr=domain.match(atomPat);
   var len=domArr.length;
   if ((domArr[domArr.length-1].length < 2) ||
       (domArr[domArr.length-1].length > 3)) {
       return false;
   }
   if (len < 2) {
       return false;
   }
   return true;
}

/**
 * email 확인
 *
 * @param 폼
 * @return email값이 유효한지 여부
 */
function validateEmail(form) {
    var bValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oEmail = new email();
    for (x in oEmail) {

        if (form[oEmail[x][0]] != null &&
        	(form[oEmail[x][0]].type == 'text' ||
             form[oEmail[x][0]].type == 'textarea') &&
            (form[oEmail[x][0]].value.length > 0)) {
            if (!checkEmail(form[oEmail[x][0]].value)) {
                if (i == 0) {
                    focusField = form[oEmail[x][0]];
                }
                fields[i++] = oEmail[x][1];
                bValid = false;
            }
        }
    }
    if (fields.length > 0) {
        //focusField.focus();
        util_messageAlert(fields.join('<br>'), focusField);
    }
    return bValid;
}

/**
 * 마스트 확인
 *
 * @param 폼
 * @return void
 */
function util_checkMaskObj(obj, maskStr){

	var regPat = new RegExp(maskStr);
	var result = matchPattern(obj.value, regPat);

	if(result == null){

		if(document.getElementsByName(obj.name).length == 1){

			var quoStrs = String(mask).split("\"");
			for(var i = 0; i < quoStrs.length; i++){

				if(quoStrs[i] == obj.name){
					var tempMessage = unescape(replaceAll(quoStrs[i + 2],"\\","%"));
					util_messageAlert(extractMaskStrs(maskStr, tempMessage), obj);
				}

			}

			//setTimeout(function(){obj.focus();obj.select();},10);

		}else{

			if(obj.type == "text" ||
			   obj.type == "textarea"){

				util_messageAlert(extractMaskStrs(maskStr, extractMessage(obj, "mask")), obj);
				//setTimeout(function(){obj.focus();obj.select();},10);

			}

		}


	}

}

/**
 * 마스트 확인 후 체크 결과 리턴
 *
 * @param object
 * @param mask 스트링
 * @return 마스크값이 유효한지 여부 스트링
 */
function util_checkMaskObjStr(obj, maskStr){

	var returnStr = "";

	var regPat = new RegExp(maskStr);
	var result = matchPattern(obj.value, regPat);
	if(result == null){
		
		if(document.getElementsByName(obj.name).length == 1){

			var quoStrs = String(mask).split("\"");
			
			for(var i = 0; i < quoStrs.length; i++){
				
				if(quoStrs[i] == obj.name){
					
					var tempMessage = unescape(replaceAll(quoStrs[i + 2],"\\","%"));
					returnStr += extractMaskStrs(maskStr, tempMessage);
					
					//setTimeout(function(){obj.focus();obj.select();},10);
				}

			}

		}else{

			if(obj.type == "text" ||
			   obj.type == "textarea"){

				returnStr += extractMaskStrs(maskStr, extractMessage(obj, "mask"));
				//setTimeout(function(){obj.focus();obj.select();},10);

			}

		}

	}

	return returnStr;

}

/**
 * 마스크 메세지 만들기
 *
 * @param paramMaskStr
 * @param paramMessage
 * @return 마스크값이 유효한지 여부 스트링
 */
function extractMaskStrs(paramMaskStr, paramMessage){

	var returnStr = "";
	var tempMessage = replaceAll(paramMessage, "[nl]", "<br>");
	var tempMaskStr = paramMaskStr.replace("^[", "").replace("]*$", "");

	// 사용 불가, 사용 가능 구분
	if(tempMaskStr.substring(0, 1) != "^"){
		// 사용불가능한 문자는 다음과 같습니다. 삭제
		tempMessage = tempMessage.replace(tempMessage.substring(tempMessage.indexOf("[X]"), tempMessage.indexOf("[/X]") + 4), "");
		//[O], [/O] 삭제
		tempMessage = tempMessage.replace("[O]", "").replace("[/O]", "");
	}else{
		// 사용가능한 문자는 다음과 같습니다. 삭제
		tempMessage = tempMessage.replace(tempMessage.substring(tempMessage.indexOf("[O]"), tempMessage.indexOf("[/O]") + 4), "");
		// ^ 삭제
		tempMaskStr = tempMaskStr.substring(1);
		//[X], [/X] 삭제
		tempMessage = tempMessage.replace("[X]", "").replace("[/X]", "");
	}
	returnStr += tempMessage;

	// 한글처리
	if(tempMaskStr.indexOf("ㄱ-ㅎ") > -1 ||
	   tempMaskStr.indexOf("ㅏ-ㅣ") > -1 ||
	   tempMaskStr.indexOf("가-힝") > -1){
		returnStr += validateTokenKorean + " ";
		tempMaskStr = tempMaskStr.replace("ㄱ-ㅎ", "");
		tempMaskStr = tempMaskStr.replace("ㅏ-ㅣ", "");
		tempMaskStr = tempMaskStr.replace("가-힝", "");
	}

	// 정규식을 사용자 메세지로 바꿔서 붙인다
	var maskStrArray = tempMaskStr.split("|");
	for(var i = 0; i < maskStrArray.length; i++){

		if(maskStrArray[i] == "0-9"){
			returnStr += validateTokenNumber;
		}else if(maskStrArray[i] == "a-z"){
			returnStr += validateTokenLowerEnglish;
		}else if(maskStrArray[i] == "A-Z"){
			returnStr += validateTokenUpperEnglish;
		}else if(maskStrArray[i] == "\r\n"){
			returnStr += validateTokenNewline;
		}else if(maskStrArray[i] == "_"){
			returnStr += "_" + "(" + validateTokenUnderBar + ")";
		}else if(maskStrArray[i] == ","){
			returnStr += "," + "(" + validateTokenComma + ")";
		}else if(maskStrArray[i] == "."){
			returnStr += "." + "(" + validateTokenDot + ")";
		}else if(maskStrArray[i] == "+-"){
			returnStr += "+-" + "(" + validateTokenDash + ")";
		}else if(maskStrArray[i] == " "){
			returnStr += validateTokenSpace;
		}else{
			returnStr += maskStrArray[i];
		}

		if(i < maskStrArray.length - 1 && maskStrArray[i] != ""){
			returnStr += " ";
		}

	}
	return returnStr;

}

/**
 * 마스크 메세지 만들기(spring validator 사용하지 않는 경우)
 *
 * @param object
 * @param maskStr
 * @param 오브젝트 이름
 * @param paramMessage
 * @return void
 */
function checkMaskObjforNonValidator(obj, maskStr, name, paramMessage){

	var regPat = new RegExp(maskStr);
	var result = matchPattern(obj.value, regPat);

	if(result == null){

		var message = paramMessage;

		message = message.replace("{0}", name);
		message = message.replaceAll("[nl]", "<br>");

		// 사용 불가, 사용 가능 구분
		if(maskStr.substring(0, 1) == "^"){
			// 사용불가능한 문자는 다음과 같습니다. 삭제
			message = message.replace(message.substring(message.indexOf("[X]"), message.indexOf("[/X]") + 4), "");
			//[O], [/O] 삭제
			message = message.replace("[O]", "").replace("[/O]", "");
		}else{
			// 사용가능한 문자는 다음과 같습니다. 삭제
			message = message.replace(message.substring(message.indexOf("[O]"), message.indexOf("[/O]") + 4), "");
			// ^ 삭제
			//[X], [/X] 삭제
			message = message.replace("[X]", "").replace("[/X]", "");
		}

		message = message + extractMaskStrsforNonValidator(maskStr);

		util_messageAlert(message, obj);
		//setTimeout(function(){obj.focus();obj.select();},10);

	}

}

/**
 * 마스크 메세지 만들기 (validator 사용 안하는 화면용)
 *
 * @param tempMaskStr
 * @return 마스크 스트링
 */
function extractMaskStrsforNonValidator(tempMaskStr){

	tempMaskStr = tempMaskStr.replace("^[", "").replace("]*$", "");

	if(tempMaskStr.substring(0, 1) == "^"){

		tempMaskStr = tempMaskStr.substring(1);
	}

	var returnStr = "";

	// 한글처리
	if(tempMaskStr.indexOf("ㄱ-ㅎ") > -1 ||
	   tempMaskStr.indexOf("ㅏ-ㅣ") > -1 ||
	   tempMaskStr.indexOf("가-힝") > -1){
		returnStr += validateTokenKorean + ", ";
		tempMaskStr = tempMaskStr.replace("ㄱ-ㅎ", "");
		tempMaskStr = tempMaskStr.replace("ㅏ-ㅣ", "");
		tempMaskStr = tempMaskStr.replace("가-힝", "");
	}

	// 정규식을 사용자 메세지로 바꿔서 붙인다
	var maskStrArray = tempMaskStr.split("|");
	for(var i = 0; i < maskStrArray.length; i++){

		if(maskStrArray[i] == "0-9"){
			returnStr += validateTokenNumber;
		}else if(maskStrArray[i] == "a-z"){
			returnStr += validateTokenLowerEnglish;
		}else if(maskStrArray[i] == "A-Z"){
			returnStr += validateTokenUpperEnglish;
		}else if(maskStrArray[i] == "\r\n"){
			returnStr += validateTokenNewline;
		}else if(maskStrArray[i] == "_"){
			returnStr += "_" + "(" + validateTokenUnderBar + ")";
		}else if(maskStrArray[i] == ","){
			returnStr += "," + "(" + validateTokenComma + ")";
		}else if(maskStrArray[i] == "."){
			returnStr += "." + "(" + validateTokenDot + ")";
		}else if(maskStrArray[i] == "+-"){
			returnStr += "+-" + "(" + validateTokenDash + ")";
		}else if(maskStrArray[i] == " "){
			returnStr += validateTokenSpace;
		}else{
			returnStr += maskStrArray[i];
		}

		if(i < maskStrArray.length - 1 && maskStrArray[i] != ""){
			returnStr += ", ";
		}

	}
	return returnStr;



}


/**
 *  length check
 *
 * @param object
 * @param 길이
 * @return 마스크 스트링
 */
function util_checkLength(obj, length){

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

	// 길이 초과시 메세지 처리후 포커스
	if(valueSize > length){

		if(document.getElementsByName(obj.name).length == 1){

			var quoStrs = String(maxlength).split("\"");

			for(var i = 0; i < quoStrs.length; i++){

				if(quoStrs[i] == obj.name){
					util_messageAlert(unescape(replaceAll(quoStrs[i + 2],"\\","%")), obj);
				}

			}

			//setTimeout(function(){obj.focus();obj.select();},10);

		}else{

			if(obj.type == "text" ||
			   obj.type == "textarea"){

				util_messageAlert(extractMessage(obj, "maxlength"), obj);
				//setTimeout(function(){obj.focus();obj.select();},10);

			}

		}


	}

}

/**
 *  length check
 *
 * @param object
 * @param 길이
 * @return 길이 체크 후 유효성 여부 스트링
 */
function util_checkLengthStr(obj, length){

	var returnStr = "";
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

	// 길이 초과시 메세지 처리후 포커스
	if(valueSize > length){

		if(document.getElementsByName(obj.name).length == 1){

			var quoStrs = String(maxlength).split("\"");

			for(var i = 0; i < quoStrs.length; i++){

				if(quoStrs[i] == obj.name){
					returnStr += unescape(replaceAll(quoStrs[i + 2],"\\","%"));
				}

			}

			//setTimeout(function(){obj.focus();obj.select();},10);

		}else{

			if(obj.type == "text" ||
			   obj.type == "textarea"){

				returnStr = extractMessage(obj, "maxlength");
				//setTimeout(function(){obj.focus();obj.select();},10);

			}

		}

	}

	return returnStr;

}

/**
 *  length check
 *
 * @param object
 * @param 길이
 * @return 길이 체크 후 유효성 여부 스트링
 */
function util_checkMinLengthStr(obj, minLength){

	var resultStr = "";

	if(obj.value != "" && obj.value.length <= minLength){

		oMinlength = new minlength ();
		for (x in oMinlength) {
	    	if(oMinlength[x][0] == obj.name){

	    		resultStr += oMinlength[x][1];
	    		//setTimeout(function(){obj.focus();obj.select();},10);

	    	}
		}

	}

	return resultStr;

}

/**
 * mask check + length
 *
 * @param object
 * @param mask string
 * @param 길이
 * @return 길이 체크 후 유효성 여부 스트링
 */
function util_checkValidation(obj, maskStr, length, minLength){
	var returnStr = "";
	returnStr = returnStr + util_checkMaskObjStr(obj, maskStr);
	
	var checkLengthReturnStr = util_checkLengthStr(obj, length);
	
	if(checkLengthReturnStr != ""){
		if(returnStr != ""){
			returnStr += "<br>====================<br>" + checkLengthReturnStr;
		}else{
			returnStr += checkLengthReturnStr;
		}
	}

	if(minLength != null){

		var checkMinLengthReturnStr = util_checkMinLengthStr(obj, minLength);

		if(checkMinLengthReturnStr != ""){
			if(returnStr != ""){
				returnStr += "<br>====================<br>" + checkMinLengthReturnStr;
			}else{
				returnStr += checkMinLengthReturnStr;
			}
		}

	}

	if(returnStr != ""){
		util_messageAlert(returnStr, obj);
	}

}

/**
 * 유효한 date인지 확인
 *
 * @param date object
 * @param message
 * @return void
 */
function util_checkDateFormat(dateObj, message, dateObjHidden){
	
	if(dateObj.value == ""){

		if(dateObjHidden != null){
			dateObjHidden.value = "";
		}
		return;
	}

	if(!util_isNumber(dateObj.value)){

		util_messageAlert(message, dateObj);
		return;
		//setTimeout(function(){dateObj.focus();dateObj.select();},10);

	}

	var yearIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("yyyy");
	var monthIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("MM");
	var dayIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("dd");

	var year = dateObj.value.substring(yearIndex, yearIndex + 4);
	var month = dateObj.value.substring(monthIndex, monthIndex + 2);
	var day = dateObj.value.substring(dayIndex, dayIndex + 2);

	if(!util_isValidYear(year) ||
       !util_isValidMonth(month) ||
       !util_isValidDay(year, month ,day)){
		util_messageAlert(message, dateObj);
		return;
		//setTimeout(function(){dateObj.focus();dateObj.select();},10);

	}else{

		dateObj.value = dateFormat.replace("yyyy", year).replace("MM", month).replace("dd", day);

	}

	// 키보드로 입력한 경우 hidden에 값 입력
	if(dateObjHidden != null &&
	   dateObjHidden.type == "hidden"){

		dateObjHidden.value = year + month + day;

	}

}

/**
 * 유효한 date인지 확인
 *
 * @param date object
 * @param message
 * @return void
 */
function util_checkDateFormatWithToday(dateObj, message, message2, dateObjHidden, beforeAfterFlag){

	if(dateObj.value == ""){

		if(dateObjHidden != null){
			dateObjHidden.value = "";
		}
		return;
	}

	if(!util_isNumber(dateObj.value)){

		util_messageAlert(message, dateObj);
		return;
		//setTimeout(function(){dateObj.focus();dateObj.select();},10);

	}

	var yearIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("yyyy");
	var monthIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("MM");
	var dayIndex = dateFormat.replaceAll(dateSeparater, "").indexOf("dd");

	var year = dateObj.value.substring(yearIndex, yearIndex + 4);
	var month = dateObj.value.substring(monthIndex, monthIndex + 2);
	var day = dateObj.value.substring(dayIndex, dayIndex + 2);

	if(!util_isValidYear(year) ||
       !util_isValidMonth(month) ||
       !util_isValidDay(year, month ,day)){

		util_messageAlert(message, dateObj);
		return;

		//setTimeout(function(){dateObj.focus();dateObj.select();},10);

	}else{

		dateObj.value = dateFormat.replace("yyyy", year).replace("MM", month).replace("dd", day);

	}

	// 키보드로 입력한 경우 hidden에 값 입력
	if(dateObjHidden != null &&
	   dateObjHidden.type == "hidden"){

		dateObjHidden.value = year + month + day;

	}

	if(beforeAfterFlag == null || beforeAfterFlag == "after"){
		
		if(dateObjHidden.value > today){
			
			dateObj.value = "";
			dateObjHidden.value = "";
			util_messageAlert(message2, dateObj);

			return;
		}
		
	}else if(beforeAfterFlag != null && beforeAfterFlag == "before"){
		
		if(dateObjHidden.value < today){
			
			dateObj.value = "";
			dateObjHidden.value = "";
			util_messageAlert(message2, dateObj);

			return;
		}
		
	}

}

/**
 * from날자와 to날자를 비교
 *
 * @param 소스 오브젝트
 * @param 대상 오브젝트 이름
 * @param type : before는 소스가 더 먼저, after는 소스가 더 나중
 * @returns Boolean
 */
function util_checkObjDayWithHidden(srcObj, srcHiddenObj, trgObj, type, message){

	var yearIndex = dateFormat.indexOf("yyyy");
	var monthIndex = dateFormat.indexOf("MM");
	var dayIndex = dateFormat.indexOf("dd");

	var srcYear = srcObj.value.substring(yearIndex, yearIndex + 4);
	var srcMonth = srcObj.value.substring(monthIndex, monthIndex + 2);
	var srcDay = srcObj.value.substring(dayIndex, dayIndex + 2);

	var trgYear = trgObj.value.substring(yearIndex, yearIndex + 4);
	var trgMonth = trgObj.value.substring(monthIndex, monthIndex + 2);
	var trgDay = trgObj.value.substring(dayIndex, dayIndex + 2);

	// 키보드로 입력한 경우 hidden에 값 입력
	if(isKeyDown){

		srcHiddenObj.value = srcYear + srcMonth + srcDay;

	}

	// 앞뒤 날짜에 값을 입력한 경우만 체크
	if(srcObj.value == "" || trgObj.value  == ""){

		if(srcObj.value == ""){
			srcHiddenObj.value = "";
		}
		return;
	}

	var startDate;
	var endDate;

	if(type == "before"){

		startDate = srcYear + srcMonth + srcDay;
		endDate = trgYear + trgMonth + trgDay;

	}else if(type == "after"){

		startDate = trgYear + trgMonth + trgDay;
		endDate = srcYear + srcMonth + srcDay;

	}

	if(Number(startDate) <= Number(endDate)){

		return true;

	}else{

		/*if(isKeyDown){
			srcObj.value = "";
			srcHiddenObj.value = "";
			//setTimeout(function(){srcObj.focus();srcObj.select();},10);
		}else{
			srcObj.value = "";
			srcHiddenObj.value = "";
			Calendar_D(srcObj, srcHiddenObj);
		}*/
		srcObj.value = "";
		srcHiddenObj.value = "";

		util_messageAlert(message, srcObj);

		return false;
	}

}

/**
 * 시작일자, 종료일자가 모두 있는지 확인
 *
 * @param 시작일자 오브젝트
 * @param 종료일자 오브젝트
 * @returns Boolean
 */
function util_existBothTime(startObj, endObj, message){

	var isExistBothTime = true;

	if(startObj.value == "" || endObj.value == ""){
		isExistBothTime = false;
	}

	if(!isExistBothTime){

		//util_messageAlert(message);

		if(startObj.value == ""){
			util_messageAlert(message, startObj);
			//setTimeout(function(){startObj.focus();startObj.select();},10);
		}else if(endObj.value == ""){
			util_messageAlert(message, endObj);
			//setTimeout(function(){endObj.focus();endObj.select();},10);
		}

	}

	return isExistBothTime;

}

/**
 * float 체크
 *
 * @param object
 * @returns void
 */
function util_checkValidateFloat(field) {

	var bValid = true;
    var i = 0;
    var fields = new Array();
    oFloat = new FloatValidations();
    for (x in oFloat) {

    	if (oFloat[x][0] == field.name &&
    		(field.type == 'text')){

        	var value = field.value;

            if (value.length > 0) {
                // remove '.' before checking digits
                var tempArray = value.split('.');
                var joinedString= tempArray.join('');

                if(tempArray.length > 2){
                	fields[i++] = oFloat[x][1];
                	bValid = false;
                }else if (!isAllDigits(joinedString)) {
                    bValid = false;
                    fields[i++] = oFloat[x][1];

                } else {
                    var iValue = parseFloat(value);
                    if (isNaN(iValue)) {
                        fields[i++] = oFloat[x][1];
                        bValid = false;
                    }
                }
            }
        }
    }

    oRange = new floatRange();
    for (x in oRange) {

        if (oRange[x][0] == field.name &&
           (field.type == 'text')){

        	if (field.value.length > 0) {

	            var fMin = parseFloat(oRange[x][2]("min"));
	            var fMax = parseFloat(oRange[x][2]("max"));
	            var fValue = parseFloat(field.value);
	            if (!(fValue >= fMin && fValue <= fMax)) {
	                fields[i++] = oRange[x][1];
	                bValid = false;

	            }

        	}
        }
    }

    if (fields.length > 0) {
       util_messageAlert(fields.join('<br>'), field);
       //setTimeout(function(){field.focus();field.select();},10);
    }
    return bValid;

}

/**
 * int 체크
 *
 * @param object
 * @returns void
 */
function util_checkValidateInt(field) {

	var bValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oInteger = new IntegerValidations();
    for (x in oInteger) {

    	if (oInteger[x][0] == field.name &&
    		(field.type == 'text')){

        	var value = field.value;

            if (value.length > 0) {

            	if (!isAllDigits(value)) {
                    bValid = false;
			        fields[i++] = oInteger[x][1];

                } else {
                    var iValue = parseInt(value);
                    if (isNaN(iValue) || !(iValue >= -2147483648 && iValue <= 2147483647)) {
                        fields[i++] = oInteger[x][1];
                        bValid = false;
                   }
               }

            }
        }
    }

    oRange = new intRange();
    for (x in oRange) {

        if (oRange[x][0] == field.name &&
           (field.type == 'text')){

        	if (field.value.length > 0) {

	            var iMin  = parseInt(oRange[x][2]("min"));
	            var iMax = parseInt(oRange[x][2]("max"));
	            var iValue = parseInt(field.value);
	            if (!(iValue >= iMin && iValue <= iMax)) {
	                fields[i++] = oRange[x][1];
	                bValid = false;

	            }

        	}
        }
    }

    if (fields.length > 0) {
        util_messageAlert(fields.join('<br>'), field);
        //setTimeout(function(){field.focus();field.select();},10);
    }

    return bValid;

}

/**
 * 화폐 체크
 *
 * @param object
 * @returns void
 */
function util_checkValidateMoney(field) {

	var bValid = true;
    var i = 0;
    var fields = new Array();
    oMoney = new MoneyValidations();

    var tempSeperatorArray = field.value.split(caliberSeparater);
	var value = tempSeperatorArray.join('');

    for (x in oMoney) {

    	if (oMoney[x][0] == field.name &&
    		(field.type == 'text')){

    		for(var j = 0; j < tempSeperatorArray.length; j++){
				if(tempSeperatorArray[j].length > caliberDigits ){
					util_messageAlert(oMoney[x][1], field);
	    	        //setTimeout(function(){field.focus();field.select();},10);
	    	        return false;
			    }
    		}

            if (value.length > 0) {

                var tempArray = value.split(caliberPoint);
                var joinedString= tempArray.join('');

                if(tempArray.length > 2){
                	fields[i++] = oMoney[x][1];
                	bValid = false;
                }else if (!isAllDigits(joinedString)) {
                    bValid = false;
                    fields[i++] = oMoney[x][1];

                } else {
                    var iValue = parseFloat(value);
                    if (isNaN(iValue)) {
                        fields[i++] = oMoney[x][1];
                        bValid = false;
                    }

                }
            }
        }
    }

    oRange = new moneyRange();
    for (x in oRange) {

        if (oRange[x][0] == field.name &&
           (field.type == 'text')){

        	if (value.length > 0) {

	            var fMin = parseFloat(oRange[x][2]("min"));
	            var fMax = parseFloat(oRange[x][2]("max"));
	            var fValue = parseFloat(value);
	            if (!(fValue >= fMin && fValue <= fMax)) {
	                fields[i++] = oRange[x][1];
	                bValid = false;

	            }

        	}
        }
    }

    if (fields.length > 0) {
       util_messageAlert(fields.join('<br>'), field);
       //setTimeout(function(){field.focus();field.select();},10);
    }
    return bValid;

}

/**
 * 숫자,'.',',','/'만 입력 체크
 * (,),+,- 입력 가능하게 수정 - 2017. 04. 05 (Shim jae young)
 *
 * @param object
 * @param event
 * @returns void
 */
var isKeyDown = false;
function util_checkNumberWithSome(dateObj, event){

	if (!(event.shiftKey && event.keyCode == 187) 
			&& !((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)
			   || event.keyCode == 46 || event.keyCode == 8
			   || event.keyCode == 32  || event.keyCode == 188
			   || event.keyCode == 190  || event.keyCode == 191
			   || event.keyCode == 37 || event.keyCode == 39
			   || event.keyCode == 111 || event.keyCode == 110
			   || event.keyCode == 9 || event.keyCode == 189 
			   || event.keyCode == 109) || (event.shiftKey && !(event.keyCode == 187 || event.keyCode == 57 || event.keyCode == 48))) {

				event.returnValue = false;
				if (event && event.preventDefault)
					event.preventDefault(); // DOM style

			}

	isKeyDown = true;

}

/**
 * 숫자,'.'만 입력 체크
 *
 * @param object
 * @param event
 * @returns void
 */
var isKeyDown = false;
function util_checkNumberWithDot(dateObj, event){

	 if(!((event.keyCode >= 48 && event.keyCode <= 57)
			   || (event.keyCode >= 96 && event.keyCode <= 105)
			   || event.keyCode == 46 || event.keyCode == 8
			   || event.keyCode == 32  || event.keyCode == 190
			   || event.keyCode == 37 || event.keyCode == 39
			   || event.keyCode == 110
			   || event.keyCode == 9) ||
			   event.shiftKey){

				event.returnValue = false;
				if (event && event.preventDefault)
					event.preventDefault(); // DOM style

			}

	isKeyDown = true;

}

/**
 * 숫자만 입력 체크
 *
 * @param object
 * @param event
 * @returns void
 */
var isKeyDown = false;
function util_checkNumber(dateObj, event){

	 if(!((event.keyCode >= 48 && event.keyCode <= 57)
			   || (event.keyCode >= 96 && event.keyCode <= 105)
			   || event.keyCode == 46 || event.keyCode == 8
			   || event.keyCode == 37 || event.keyCode == 39
			   || event.keyCode == 9) ||
			   event.shiftKey){

				event.returnValue = false;
				if (event && event.preventDefault)
					event.preventDefault(); // DOM style

			}

	isKeyDown = true;

}

/**
 * 유효한 년인지 확인
 *
 * @param year
 * @returns boolean
 */
function util_isValidYear(value) {
	return value.length == 4 && Number(value) > 0;
}

/**
 * 유효한 월인지 확인
 *
 * @param month
 * @returns boolean
 */
function util_isValidMonth(value) {
	return ( (value.length > 0) && (0 < eval(value)) && (eval(value) < 13) );
}

/**
 * 유효한 일인지 확인
 *
 * @param day
 * @returns boolean
 */
function util_isValidDay1(value) {
	return ( (value.length > 0) && (0 < eval(value)) && (eval(value) < 32) );
}

/**
 * 유효한 날짜인지 확인
 *
 * @param year
 * @param month
 * @param day
 * @returns boolean
 */
function util_isValidDay(yyyy, mm, value){
	var result = false;
	var monthDD = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	var index = eval(mm) - 1;
	if (value.length != 2) { return false; }
	if (((yyyy % 4 == 0) && (yyyy % 100 != 0)) || (yyyy % 400 == 0)) { monthDD[1] = 29; }

	var dd = eval(value);
	if ((0 < dd) && (dd <= monthDD[index])) {	result = true; }

	return result;
}

/**
 * 시간타입인지 확인한다 12:00형태이면 통과시키고 아닐경우 alert을 띄운후 입력값을 지워준다
 *
 * @param document.form.formName
 *
 */
function util_timeCheck(timeObj, msg) {

	var time = timeObj.value;
	var result = true;

	if (time == '') {
		return;
	}

	var hour = time.substring(0, 2);
	var colon = time.substring(2, 3);
	var min = time.substring(3, 5);

	if (util_isNumber(hour) && util_isNumber(min) && colon == timeSeparater
			&& Number(hour) < 24 && Number(hour) >= 0 && Number(min) >= 0
			&& Number(min) < 60 && hour.length == 2 && min.length == 2) {
	} else {
		result = false;
		util_messageAlert(msg, timeObj);
		//setTimeout(function(){timeObj.focus();timeObj.select();},10);
	}

	return result;

}

/**
 * 필수 메시지 리턴 for EXMS
 *
 * @param objName
 * @return 필수메시지
 */

function getRequiredMessage(objName){

	oRequired = new required();

	for(x in oRequired){
		if(objName == oRequired[x][0]){
			return oRequired[x][1];
		}
	}
}

/**
 *  length check
 *
 * @param object
 * @param 길이
 * @return 길이 체크 후 유효성 여부 스트링
 */
function util_checkLengthStrForArray(obj, length){

	var returnStr = "";
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

	// 길이 초과시 메세지 처리후 포커스
	if(valueSize > length){


		var quoStrs = String(maxlength).split("\"");

		for(var i = 0; i < quoStrs.length; i++){

			if(quoStrs[i] == obj.name){
				returnStr += unescape(replaceAll(quoStrs[i + 2],"\\","%"));
			}

		}


	}

	return returnStr;

}

/**
 * 마스트 확인 후 체크 결과 리턴
 *
 * @param object
 * @param mask 스트링
 * @return 마스크값이 유효한지 여부 스트링
 */
function util_checkMaskObjStrForArray(obj, maskStr){

	var returnStr = "";

	var regPat = new RegExp(maskStr);
	var result = matchPattern(obj.value, regPat);

	if(result == null){

		var quoStrs = String(mask).split("\"");
		for(var i = 0; i < quoStrs.length; i++){

			if(quoStrs[i] == obj.name){
				var tempMessage = unescape(replaceAll(quoStrs[i + 2],"\\","%"));
				returnStr += extractMaskStrs(maskStr, tempMessage);

			}

		}

	}

	return returnStr;

}

/**
 * mask check + length
 *
 * @param object
 * @param mask string
 * @param 길이
 * @return 길이 체크 후 유효성 여부 스트링
 */
function util_checkValidationForArray(obj, maskStr, length, minLength){

	var returnStr = "";

	returnStr = returnStr + util_checkMaskObjStrForArray(obj, maskStr);
	var checkLengthReturnStr = util_checkLengthStrForArray(obj, length);

	if(checkLengthReturnStr != ""){
		if(returnStr != ""){
			returnStr += "<br>====================<br>" + checkLengthReturnStr;
		}else{
			returnStr += checkLengthReturnStr;
		}
	}

	if(minLength != null){

		var checkMinLengthReturnStr = util_checkMinLengthStr(obj, minLength);

		if(checkMinLengthReturnStr != ""){
			if(returnStr != ""){
				returnStr += "<br>====================<br>" + checkMinLengthReturnStr;
			}else{
				returnStr += checkMinLengthReturnStr;
			}
		}


	}

	if(returnStr != ""){
		if(document.getElementById("contents") != null){
			util_messageAlert(returnStr, obj);
		}else if(document.getElementById("popup_contents") != null){
			util_messageAlertOnPopup(returnStr, obj);
		}else {
			util_messageAlertOnParent(returnStr, obj);
		}

	}

}

/**
 * 필수 확인
 *
 * @param 폼
 * @return 필수값이 입력되었는지 여부
 */
function validateRequiredForArray(form) {
    var isValid = true;
    var focusField = null;
    var i = 0;
    var fields = new Array();
    oRequired = new required();
    for (x in oRequired) {
    	var field = form[oRequired[x][0]];

    	if (typeof(field) == 'undefined') {
    		continue;
    	}

    		if (field.type == 'text' ||
	    	    field.type == 'textarea' ||
	            field.type == 'file' ||
	            field.type == 'select-one' ||
	            field.type == 'radio' ||
	            field.type == 'password' ||
	            field.type == 'hidden') {

	            var value = '';
				// get field's value
				if (field.type == "select-one") {
					var si = field.selectedIndex;
					if (si >= 0) {
						value = field.options[si].value;
					}
				} else {
					value = field.value;
				}

	            if (trim(value).length == 0) {

	                if (i == 0) {
	                	if (field.type != 'hidden') {
	                    	focusField = field;
	                    }
	                }
	                fields[i++] = oRequired[x][1];
	                isValid = false;
	            }
	      	} else if (form[oRequired[x][0]][0].type == 'radio') {
				var radioChecked = false;
				for (var j=0; j<form[oRequired[x][0]].length; j++) {
					if (form[oRequired[x][0]][j].checked) {
	                    radioChecked = true;
	                    break;
					}
				}
				if (!radioChecked) {
					if (i == 0) {
						focusField = form[oRequired[x][0]][0];
					}
					fields[i++] = oRequired[x][1];
					isValid = false;
				}
	        }

    		if(document.getElementById("contents") != null){
    			util_messageAlert(value, focusField);
    		}else if(document.getElementById("popup_contents") != null){
    			util_messageAlertOnPopup(value, focusField);
    		}else {
    			util_messageAlertOnParent(value, focusField);
    		}

    }
    if (fields.length > 0) {

    	if(document.getElementById("contents") != null){
			util_messageAlert(fields.join('<br>'), focusField);
		}else if(document.getElementById("popup_contents") != null){
			util_messageAlertOnPopup(fields.join('<br>'), focusField);
		}else {
			util_messageAlertOnParent(fields.join('<br>'), focusField);
		}

    }

    return isValid;

}

/*
 * 숫자만 입력 메소드
 * 사용방법 onkeypress 속성에 메소드 설정 
 * parameter : event
 */
function fn_onlyNumValidate(evt) {
	  
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]/;
	
	if( !regex.test(key) ) {
	    
		theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

/*
 * 숫자만 입력 메소드(소수점 포함)
 * 사용방법 onkeypress 속성에 메소드 설정 
 * parameter : event
 */
function fn_numValidate(evt) {
	  
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
	    
		theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	}
}
