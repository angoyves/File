/**
 * @fileoverview 데이터 및 파일 해쉬 생성 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* String에 대한 해쉬값 반환
* @param {String}strMessage 데이터
* @return {String}String에 대한 해쉬값
*/
function SGJ_getMessageDigest( strMessage )
{
	return SGJ_getMessageDigestWithAlgo( strMessage, 'SHA1');
}

/**
* String에 대한 해쉬값 반환
* @param {String}strMessage 데이터
* @param {String}algorithm 해쉬 알고리즘
* @return {String}String에 대한 해쉬값
*/
function SGJ_getMessageDigestWithAlgo( strMessage, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strMessage, algorithm)) return '';

	return SGJ_call("getMessageDigest", strMessage, algorithm );
}
/**
* 파일에 대한 해쉬값 반환
* @param {String}strFilePath 해쉬 대상 파일
* @return {String}파일에 대한 해쉬값
*/
function SGJ_getMessageDigestFromFile( strFilePath )
{
	return SGJ_getMessageDigestFromFileWithAlgo( strFilePath, 'SHA1');
}

/**
* 파일에 대한 해쉬값 반환
* @param {String}strFilePath 해쉬 대상 파일
* @param {String}algorithm 해쉬 대상 파일
* @return {String}파일에 대한 해쉬값
*/
function SGJ_getMessageDigestFromFileWithAlgo( strFilePath, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strFilePath, algorithm)) return '';

	return SGJ_call("getMessageDigestFromFile", strFilePath, algorithm);
}
