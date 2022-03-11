/**
 * @fileoverview 서명 생성 및 검증 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* String에 대한 서명값 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @param {String}strMessage 서명 대상 String
* @return {String} 서명값
*/
function SGJ_getSignature(strUserID, strMessage )
{
	return SGJ_getSignatureWithAlgo(strUserID, strMessage, '');
}

/**
* String에 대한 서명값 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @param {String}strMessage 서명 대상 String
* @param {String}algorithm 서명시 해쉬 알고리즘
* @return {String} 서명값
*/
function SGJ_getSignatureWithAlgo(strUserID, strMessage, algorithm)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strMessage)) return '';
	
	return SGJ_call("getSignature", strUserID, strMessage, algorithm );
}


/**
* String에 대한 서명검증 결과 반환
* @param {String}strMessage 원본 메세지
* @param {String}strSignValue 서명값
* @param {String}strCert 서명 검증시 사용될 PEM 타입 인증서
* @return {boolean} true 또는 false
*/
function SGJ_verifySignature( strMessage, strSignValue, strCert )
{
	return SGJ_verifySignatureWithAlgo( strMessage, strSignValue, strCert, '');
}

/**
* String에 대한 서명검증 결과 반환
* @param {String}strMessage 원본 메세지
* @param {String}strSignValue 서명값
* @param {String}strCert 서명 검증시 사용될 PEM 타입 인증서
* @param {String}algorithm 검증시 사용할 해쉬 알고리즘
* @return {boolean} true 또는 false
*/
function SGJ_verifySignatureWithAlgo( strMessage, strSignValue, strCert, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strMessage, strSignValue, strCert)) return false;

	return SGJ_call("verifySignature", strMessage, strSignValue, strCert, algorithm );
}

/**
* 파일에 대한 서명값 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @param {String}strFilePath 서명 대상 파일 경로
* @return {String} 파일에 대한 서명값
*/
function SGJ_getSignatureFromFile( strUserID, strFilePath )
{
	return SGJ_getSignatureFromFileWithAlgo( strUserID, strFilePath, '' );
}

/**
* 파일에 대한 서명값 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @param {String}strFilePath 서명 대상 파일 경로
* @param {String}algorithm 서명시 사용할 해쉬 알고리즘
* @return {String} 파일에 대한 서명값
*/
function SGJ_getSignatureFromFileWithAlgo( strUserID, strFilePath, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strFilePath)) return '';
	
	return SGJ_call("getSignatureFromFile", strUserID, strFilePath, algorithm);
}


/**
* 파일에 대한 서명값 검증 결과 반환
* @param {String}strFilePath 원본 파일 경로
* @param {String}strSignValue 서명값
* @param {String}strCert 서명 검증시 사용될 PEM 타입 인증서
* @return {boolean} 서명검증 결과
*/
function SGJ_verifySignatureFromFile( strFilePath, strSignValue, strCert )
{
	return SGJ_verifySignatureFromFileWithAlgo( strFilePath, strSignValue, strCert, '' );
}

/**
* 파일에 대한 서명값 검증 결과 반환
* @param {String}strFilePath 원본 파일 경로
* @param {String}strSignValue 서명값
* @param {String}strCert 서명 검증시 사용될 PEM 타입 인증서
* @param {String}algorithm 서명 검증시 사용할 해쉬 알고리즘
* @return {boolean} 서명검증 결과
*/
function SGJ_verifySignatureFromFileWithAlgo( strFilePath, strSignValue, strCert, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strFilePath, strSignValue, strCert)) return false;

	return SGJ_call("verifySignatureFromFile",  strFilePath, strSignValue, strCert, algorithm);
}
