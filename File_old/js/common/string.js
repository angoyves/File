function $RF(el, radioGroup) {
	if($(el).type == 'radio') {
		var el = $(el).form;
		var radioGroup = $(el).name;
	} else if ($(el).tagName.toLowerCase() != 'form') {
		return false;
	}
	return $F($(el).getInputs('radio', radioGroup).find(
		function(re) {return re.checked;}
	));
}

var Pattern = {
      PARTICULAR : /[$\\@\\\#%\^\&\*\(\)\[\]\+\_\{\}\`\~\=\'\"\|]/
    , ENGLISH : /^([a-zA-Z]+)$/ /* /^(\w[^0-9_]+)$/ */
    , NUMBER : /^(\d+)$/
    , ENGNUM : /^(\w+)$/
    , SPACE : /(^\s*)|(\s*$)/gi
    , EMAIL : /^((\w|[\-\.])+)@((\w|[\-\.])+)\.([A-Za-z]+)$/
    , PHONE : /^(0(\d{1,2}))-(\d{3,4})-(\d{4})$/
    , IDPWD : /^(\w{4,12})$/
    , SSN : /^(\d{13})$/
    , POST : /^((\d{3}))-(\d{3})$/
}

/**
 * Remove spaces
 *
 */
String.prototype.trim = function() {
    return this.replace(Pattern.SPACE, "");
}

String.prototype.lastIndexOf = function(sep) {

	var index = 0;
	for(var i =0; i < this.length; i++){

		if(this.substring(i, i +1) == sep){
			index = i;
		}

	}

    return index;
}

/**
 * Replace all the characters
 *
 */
String.prototype.replaceAll = function(replace, string) {
    var tmpStr = this.trim();
    if (tmpStr != "" && replace != string)
        while ( tmpStr.indexOf(replace) > -1 ) { tmpStr = tmpStr.replace(replace, string); }
    return tmpStr;
}

/**
 * Check the length of the string (Byte units)
 *
 */
String.prototype.Length = function() {
    var bytLen = 0, strSlice = "";
    for (var i=0; i<this.length; i++) {
        strSlice = this.substring(i, i+1);
        bytLen += Math.sqrt(Math.abs(escape(strSlice).length - 2));
    }
    return bytLen;
}

/**
 * Length of the string as the crop
 *
 */
String.prototype.Slice = function(len) {
    var bytLen = 0, strSlice = "", strRtn = "";
    for (var i=0; i<this.length; i++) {
        strSlice = this.substring(i, i+1);
        bytLen += Math.sqrt(Math.abs(escape(strSlice).length - 2));
        strRtn += strSlice;
        if (bytLen >= len) { return strRtn; break; }
    }
    return strRtn;
}

/**
 * Conversion to uppercase
 *
 */
function util_UpperCode(inputForm) {
	eval( "document." + inputForm).value = eval( "document." + inputForm).value.toUpperCase();
}

/**
 * Conversion to lowercase
 *
 */
function util_LowerCode(inputForm) {
	eval( "document." + inputForm).value = eval( "document." + inputForm).value.toLowerCase();
}

/**
 * Insert the number of digits
 *
 */
function util_insertComma(value) {
	if (value == '') return value;

	value = parseFloat(value, 10).toString()
	while (true) {

		if (value.indexOf(',') != -1)
			idx = value.search(/[^,\.\-]([0-9]{3})+\,/);
		else
			idx = value.search(/[^,\.\-]([0-9]{3})+$/);
		if (idx == -1) break;
			value = value.substring(0, idx+1) + '.' + value.substring(idx+1, value.length);
	}
	return value;
}

/**
 * Delete the number of digits
 *
 */
function util_delComma(num) {
	if(num.toString().indexOf('.') != -1){
		var split = num.split('.');
		var newNum="";

		for(var i=0; i<split.length; i++){
			newNum = newNum + split[i];
		}
		return newNum;
	}else{
		return num;
	}
}

/**
 * If the serial number on the left to automatically fill 0
 *
 */
function util_fillZero(obj, max) {
    var str = "";
    var len = obj.value.length;

    if (len != 0) {
        for( iCnt = 0; iCnt < (max - len); iCnt++)
            str = str + "0";
        obj.value = str+obj.value;
   }
}

/**
 * String The string is replaced by another string.
 *
 */
function util_replace(target, replacee, replacer){
	var ret = "";
	retStr = "" + target;

	while (retStr.indexOf(replacee)>-1) {
		pos= retStr.indexOf(replacee);
		retStr = "" + (retStr.substring(0, pos) + replacer + retStr.substring((pos + replacee.length), retStr.length));
	}
	return retStr;
}

/**
 * String The string is replaced by a blank string.
 *
 */
function util_replace2(target, replacee){
	return util_replace(target, replacee, "");
}

/**
 * String of strings to remove spaces
 *
 */
function util_trim(objValue) {
	return objValue.toString().replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * String, followed by a fill
 *
 */
function util_rpad(newValue, len, ch){
	var strlen = util_trim(newValue).length;
	var ret = "";
	var alen = len - strlen;
	var astr = "";

	for (i=0; i<alen; ++i){
		astr = astr + ch;
	}
	ret = util_trim(newValue) + astr;
	return ret;
}

/**
 * Population before the character string
 *
 */
function util_lpad(newValue, len, ch){
	var strlen = util_trim(newValue).length;
	var ret = "";
	var alen = len - strlen;
	var astr = "";

	for (i=0; i<alen; ++i){
		astr = astr + ch;
	}

	ret = astr + util_trim(newValue);
	return ret;
}

/**
 * is null, the value of alternative
 *
 */
function util_nvl(value, replacer){
	if ( value == null){
		return replacer;
	}else{
		return value;
	}
}

/**
 * Strings removed
 *
 */
function util_delChar(newValue, ch){
	var len = newValue.length;
	var ret = "";

	for (i=0; i<len; ++i){
		if (newValue.substring(i,i+1) != ch)
		ret = ret + newValue.substring(i,i+1);
	}
	return ret;
}

/**
 * ', " change to &apos;, &quot
 *
 */
function util_replaceText(value){
	var len = value.length;
	var sub = "";

	if(len > 0){
		for(var i=0; i<value.length; i++){
			sub = value.substr(i,1);
			if(sub == "'"){
				value = value.substring(0, i) + "&apos;" + value.substring(i+1);
				i=i+8;
			}else if(sub == "\""){
				value = value.substring(0, i) + "&quot" + value.substring(i+1);
				i=i+5;
			}
		}
	}
	return value;
}

/**
 * Numeric characters, except for String and then delete the return
 *
 */
function util_delNotNumber(strDate){
    var rtnStr = "";
    for(var i=0; i<strDate.length; i++){
        if('0' <= strDate.charAt(i) && strDate.charAt(i) <= '9'){
            rtnStr += strDate.charAt(i);
        }
    }
    return rtnStr;
}

/**
 * Add date and menute time
 *
 */
function util_makeDateMinuteTime(dateObj, timeObj, dateTimeObj){

	if(dateObj.value.length == 10 &&
			timeObj.value.length == 5){

		var dateStr = dateObj.value;
		var secondTimeStr = timeObj.value;

		dateTimeObj.value = dateStr.substring(0, 4) + dateStr.substring(5, 7) + dateStr.substring(8, 10) +
		                    secondTimeStr.substring(0, 2) + secondTimeStr.substring(3, 5);

	}else{

		dateTimeObj.value = "";

	}

}

/**
 * extract date and minute from time
 *
 */
function util_extractDateMinuteFromTime(dateObj, timeObj, dateTimeObj){

	var dateTimeStr = dateTimeObj.value;

	if(dateTimeStr.length == 12){

		dateObj.value = dateTimeStr.substring(0, 4) + "/" +
		                dateTimeStr.substring(4, 6) + "/" +
		                dateTimeStr.substring(6, 8);

		timeObj.value = dateTimeStr.substring(8, 10) + ":" +
                        dateTimeStr.substring(10, 12);

	}else{

		dateObj.value = "";
		timeObj.value = "";
	}

}

/**
 * replace quotation
 *
 */
function util_encodeQuote(targetStr){
	targetStr = "" + targetStr;

	return targetStr.replaceAll("'", "[[sq]]").replaceAll("\"", "[[dq]]");

}

/**
 * replace quotation
 *
 */
function util_decodeQuot(targetStr){
	targetStr = "" + targetStr;

	var returnStr = targetStr.replaceAll("[[sq]]", "'");
    returnStr = returnStr.replaceAll("[[dq]]", '"');

    return returnStr;

}
