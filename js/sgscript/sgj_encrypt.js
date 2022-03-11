/**
 * @fileoverview 세션키 암호화 및 대칭키/비대칭키 암/복호화 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* 암호화된 세션키 반환
* @param {String}strUserID 세션ID
* @param  {String}strKmCert PEM 타입의 인증서
* @return {String}암호화된 세션키(BASE64)
*/
function SGJ_encryptSessionKey(strUserID, strKmCert )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strKmCert)) return '';

	return SGJ_call("encryptSessionKey", strUserID, strKmCert );
}

/**
* 복호화된 세션키 반환
* @param {String}strUserID 세션ID
* @param {String}strEncryptedSessionKey 암호화된 세션키
* @return {String}복호화된 세션키
*/
function SGJ_decryptSessionKey( strUserID, strEncryptedSessionKey )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strEncryptedSessionKey)) return '';

	return SGJ_call("decryptSessionKey", strUserID, strEncryptedSessionKey);
}

/**
* 세션키로 암호화된 String 반환
* @param {String}strUserID 세션ID
* @param {String}strMessage 원본 메세지(암호화 대상)
* @return {String}대칭키로 암호화된 메세지(BASE64)
*/
function SGJ_encryptData( strUserID, strMessage )
{
	return SGJ_encryptDataWithAlgo(strUserID, strMessage, 'SEED/CBC/PKCS5');
}

/**
* 세션키로 암호화된 String 반환
* @param {String}strUserID 세션ID
* @param {String}strMessage 원본 메세지(암호화 대상)
* @param {String}algorithm 대칭키 알고리즘
* @return {String}대칭키로 암호화된 String
*/
function SGJ_encryptDataWithAlgo( strUserID, strMessage, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strMessage, algorithm)) return '';
	
	return SGJ_call("encryptData",  strUserID, strMessage, algorithm );
}

/**
* 세션키로 복호화된 String 반환
* @param {String}strUserID 세션ID
* @param {String}strEncryptedMessage 암호화된 String
* @return {String}세션키로 복호화된 String
*/
function SGJ_decryptData( strUserID, strEncryptedMessage )
{
	return SGJ_decryptDataWithAlgo( strUserID, strEncryptedMessage, 'SEED/CBC/PKCS5' );
}

/**
* 세션키로 복호화된 String 반환
* @param {String}strUserID 세션ID
* @param {String}strEncryptedMessage 암호화된 String
* @return {String}세션키로 복호화된 String
*/
function SGJ_decryptDataWithAlgo( strUserID, strEncryptedMessage, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strEncryptedMessage, algorithm)) return '';
	
	return SGJ_call("decryptData", strUserID, strEncryptedMessage, algorithm);
}

/**
* 세션키로 암호화된 파일 반환
* @param {String}strUserID 세션ID
* @param {String}strInputFilePath 암호화할 파일명
* @param {String}strOutputFilePath 암호화된 파일명
* @return {boolean}true 또는 false
*/
function SGJ_encryptFile(strUserID,  strInputFilePath, strOutputFilePath )
{
	return SGJ_encryptFileWithAlgo(strUserID,  strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5');
}


/**
* 세션키로 암호화된 파일 반환
* @param {String}strUserID 세션ID
* @param {String}strInputFilePath 암호화할 파일명
* @param {String}strOutputFilePath 암호화된 파일명
* @param {String}algorithm 대칭키 알고리즘
* @return {boolean}true 또는 false
*/
function SGJ_encryptFileWithAlgo(strUserID,  strInputFilePath, strOutputFilePath, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strInputFilePath, strOutputFilePath, algorithm)) return false;
	
	return SGJ_call("encryptFile", strUserID, strInputFilePath, strOutputFilePath, algorithm );
}

/**
* 세션키로 복호화된 파일 반환
* @param {String}strUserID 세션ID
* @param {String}strInputFilePath 복호화할 파일명
* @param {String}strOutputFilePath 복호화된 파일명
* @return {boolean} true 또는 false
*/
function SGJ_decryptFile(strUserID,  strInputFilePath, strOutputFilePath )
{
	return SGJ_decryptFileWithAlgo(strUserID,  strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5' );
}

/**
* 세션키로 복호화된 파일 반환
* @param {String}strUserID 세션ID
* @param {String}strInputFilePath 복호화할 파일명
* @param {String}strOutputFilePath 복호화된 파일명
* @param {String}algorithm 대칭키 알고리즘
* @return {boolean} true 또는 false
*/
function SGJ_decryptFileWithAlgo(strUserID,  strInputFilePath, strOutputFilePath, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strInputFilePath, strOutputFilePath, algorithm)) return false;
	
	return SGJ_call("decryptFile",  strUserID, strInputFilePath, strOutputFilePath, algorithm  );
}

/**
* 주어진 인증서로 암호화된 데이터 반환
* @param {String}strUserID 세션ID
* @param {String}kmCertString PEM 타입의 인증서
* @param {String}data 암호화할 String
* @return {String}RSA 암호화된 String(BASE64)
*/
function SGJ_encryptRSA( strUserID, kmCertString, data )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCertString, data)) return '';
	
	return SGJ_call("encryptRSA", strUserID, kmCertString, data );
}


/**
* RSA 복호화된 데이터 반환
* @param {String}strUserID 세션ID
* @param {String}encString 암호화된 String
* @return {String}RSA 복호화된 String
*/
function SGJ_decryptRSA( strUserID, encString )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, encString)) return '';
	
	return SGJ_call("decryptRSA", strUserID, encString);
}
