/**
 * @fileoverview 전자조달 전용 함수 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* 개찰을 위한 주어진 인증서로 암호화된 공고건 개인키 정보 반환
* @param {String}strUserId 세션아이디
* @param {String}strKmCert 암호화 인증서
* @return {String} 암호화된 공고건 개인키 정보
*/
function SGJ_getEncKey( strUserId, strKmCert )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId, strKmCert)) return '';

	return SGJ_call("getEncKey", strUserId, strKmCert );
}

/**
* 인증서 기반의 로그인 정보 반환
* @param {String}strUserId 세션 아이디
* @return {String} 로그인 정보
*/
/*function SGJ_getLoginInfo( strUserId )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId)) return '';
	strUserId = getMac(strUserId) + strUserId;
	return SGJ_call("getLoginInfo", strUserId );
}*/

/**
* 인증서 기반의 로그인 정보 반환
* @param {String}strUserId 세션 아이디
* @param {String}strKmCert 암호화용 인증서
* @return {String} 로그인 정보
*/
function SGJ_getLoginInfo( strUserId, strKmCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId, strKmCert)) return '';

	strUserId = getMac(strUserId) + strUserId;
	return SGJ_call("getLoginInfo", strUserId, strKmCert);
}


/**
* 인증서 기반의 로그인 정보 반환
* @param {String}strUserId 세션 아이디
* @param {String}strKmCert 암호화용 인증서
* @return {String} 로그인 정보
*/
function SGJ_getCertRegInfo( strUserId )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId)) return '';

	strUserId = getMac(strUserId) + strUserId;
	return SGJ_call("getCertRegInfo", strUserId);
}


/**
* 아이디/패스워드 기반의 로그인 정보 반환
* @param {String}strUserId 세션 아이디
* @param {String}userId 사용자가 입력한 아이디
* @param {String}userPassword 사용자가 입력한 패스워드
* @return {String} 로그인 정보
*/
/*function SGJ_getLoginInfoUsePasswd( strUserId, userId, userPassword )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId, userId, userPassword)) return '';

	strUserId = getMac(strUserId) + strUserId;
	return SGJ_call("getLoginInfoUsePasswd", strUserId, userId, userPassword);
}*/


/**
* 집행관 인증을 위한 정보 반환
* @param {String}strUserId 세션 아이디
* @param {String}bidNumber 공고번호
* @return {String} 집행관 인증 정보
*/
function SGJ_getAuthValueForOpening( strUserId, bidNumber )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId, bidNumber)) return '';

	return SGJ_call("getAuthValueForOpening", strUserId, bidNumber);
}

/**
* 공고건 인증서 발급
* 
* @param {String}cmpUrl 인증서 발급을 위한 URL 정보
* 
*/
function SGJ_setCmpUrl( cmpUrl )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, cmpUrl)) return '';
	return SGJ_call("setCmpUrl", cmpUrl);
}

/**
* 공고건 인증서 발급
* 
* @param {String}strUserId 세션 아이디
* @param {String}bidNumber 공고번호
* @param {String}refNumber 참조번호
* @param {String}authCode 인가코드
* @return {String} 성공여부(true or flase)
*/
function SGJ_issueBidCert( strUserId, bidNumber, refNumber, authCode )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId, bidNumber)) return '';

	return SGJ_call("issueBidCert", strUserId, bidNumber, refNumber, authCode);
}