/**
 * @fileoverview 세션 관리 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* 주어진 세션 ID 의 정보 삭제
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @return {boolean}true 또는 false
*/
function SGJ_removeSession( strUserID )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return false;
	
	return SGJ_call("removeSession", strUserID);
}

/**
* 모든 세션 정보 삭제
* @return {boolean}true 또는 false
*/
function SGJ_removeAllSession()
{
	
	return SGJ_call("removeAllSession");	
}
