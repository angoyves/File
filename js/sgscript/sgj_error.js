/**
 * @fileoverview 오류 메시지 관련 스크립트
 *
 * @author hychul
 * @version 0.1
 */

var strErrCode = "";
var strErrMsg = "";
var strErrFuncName = "";

/**
* 오류 관련 변수 초기화
* @return {void}
*/
function clearError()
{
	strErrCode = "";
	strErrMsg = "";
	strErrFuncName = "";
}

/**
* 오류에 대한 코드 지정
*	오류 코드
*<pre>
*	PARAMETER_NULL	: 함수의 인자 값중 하나가 null이거나 ""일 경우
*	INVALID_RETURN_VALUE: 함수수행중 오류가 발생한경우
*</pre>
*
* @param strCode 오류 코드
* @return {void}
*/
function setErrorCode( strCode )
{
	if(strCode == 'PARAMETER_NULL')
		alert("One of parametes is null!!, check parameters!!");
	strErrCode = strCode;
	return;
}

/**
* 오류 메시지 지정
* @param strCode 오류메세지
* @return {void}
*/
function setErrorMsg( strMsg )
{
	strErrMsg = strMsg;
	return;
}

/**
* 오류가 발생 함수 지정
* @param strFunctionName 함수 이름
* @return {void}
*/
function setErrorFunction( strFunctionName )
{
	strErrFuncName = strFunctionName;
	return;
}

/**
* 마지막으로 발생한 오류 반환
* 에러가 없는 경우 null 반환
* 
* @return {String}에러 메시지
*/
function SGJ_getErrorMsg() 
{
	return SGJ_call("getErrorMsg");
}

/**
* 에러 스택 반환
* 에러 스택이 없는 경우 null 반환
* 
* @return {String}에러 스택
*/
function SGJ_getStackTrace()
{
	return SGJ_call("getStackTrace");
}

/**
* 마지막으로 발생한 오류에 대한 코드 반환
* 
* @return {String} 에러 코드
*/
function getErrorCode()
{
	return strErrCode;
}

/**
* 마지막으로 발생한 오류에 메시지 반환
* 
* @return {String} 오류메시지
*/
function getErrorMsg()
{
	return strErrCode;
}

/**
* 마지막으로 오류가 발생한 함수 이름 반환
* 
* @return {String} 함수 이름
*/
function getErrorFunction()
{
	return strErrFuncName;
}
