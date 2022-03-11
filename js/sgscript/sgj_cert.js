/**
 * @fileoverview 인증서 관련 정보 획득 및 신원확인 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* 인증서의 유효성을 검증<br>
* 기본 CRL 저장디렉토리는 USER_HOME<br>
* strCert 값이 null 인경우 세션에 저장된 인증서의 유효성을 검증<br>
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {boolean} true 또는 false
*/
function SGJ_checkCertValidity(strUserID, strCert)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return false; 
	
	return SGJ_call("checkCertValidity", strUserID, strCert );
}

/**
* 인증서의 유효성을 검증
* strCert 값이 null 인경우 세션에 저장된 인증서의 유효성을 검증
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @param {String}crlPath CRL 저장 경로
* @return {boolean} true 또는 false
*/
function SGJ_checkCertValidityWithPath( strUserID, strCert, crlPath )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return false;
	
	return SGJ_call("checkCertValidity", strUserID, strCert, crlPath);
}


/**
* 인증서 사용자의 신원확인
* @param {String}strUserID 세션ID
* @param {String}idn 사용자의 주민번호 또는 사업자 번호
* @param {String}encRandom 암호화된 랜덤값(BASE64 인코딩)
* @return {boolean} true 또는 false
*/
function SGJ_checkCertUserIdentity( strUserID, idn, encRandom )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, idn, encRandom)) return false;
	
	return SGJ_call("checkCertUserIdentity", strUserID, idn, encRandom );
}

/**
* 신원확인번호 입력창이 뜨는
* 인증서 사용자의 신원확인
* @return {void}
*/
function SGJ_checkCertUserIdentityWithDialog()
{
	return SGJ_call("checkCertUserIdentity");
}

/**
* 세션에 저장된 인증서 반환
* @param {String}strUserID 세션ID
* @param {String}certType 얻고자 하는 인증서 타입("SIGN" 또는 "KM");
* @return {String}PEM 타입의 인증서
*/
function SGJ_getCert( strUserID, certType )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, certType)) return '';

	return SGJ_call("getCert", strUserID, certType);
}

/**
* 세션에 저장된 인증서 바디만 반환
* @param {String}strUserID 세션ID
* @param {String}certType 얻고자 하는 인증서 타입("SIGN" 또는 "KM");
* @return {String}header , footer를 제외한 인증서
*/
function SGJ_getCertOnlyBody( strUserID, certType )
{
	var strCert = SGJ_getCert(strUserID ,certType );

	var strCertBody = strCert.replace(/(\-----BEGIN CERTIFICATE-----)+/g,'');
	strCertBody = strCertBody.replace(/(\-----END CERTIFICATE-----)+/g,'');
	strCertBody = strCertBody.replace(/\n/g,'');
	strCertBody = strCertBody.replace(/\r/g,'');

	return strCertBody;
}


//보안토큰 관련 추가 메소드========================================

/**
* 보안토큰에 저장된 개인 사용자 인증서 반환
* @param {String}strUserID 세션ID
* @param {String}certType 얻고자 하는 인증서 타입("SIGN" 또는 "KM");
* @return {String}PEM 타입의 인증서
*/
function SGJ_getBioUserCert( strUserID, certType )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, certType)) return '';

	return SGJ_call("getBioUserCert", strUserID, certType);
}


/**
* 보안토큰 사용자 인증값 반환
* @param {String}strUserID 세션ID
* @param {String}svrCert 암호화를 위한 서버 인증서;
* @param {String}gonggoNum 공고번호;
* @return {String}사용자 인증값
*/
function SGJ_getAuthValue( strUserID, svrCert, gonggoNum )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, svrCert, gonggoNum)) return '';
	
	return SGJ_call("getAuthValue", strUserID, svrCert, gonggoNum);
}


/**
* 보안토큰 기기 인증값 반환
* @param {String}strUserID 세션ID
* @param {String}keyId 기관 번호(조달청은 01);
* @param {String}gonggoNum 공고번호;
* @return {String}보안토큰 기기 인증값
*/
function SGJ_getBioGenDevAuth( strUserID, keyId, gonggoNum )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, keyId, gonggoNum)) return '';
	
	return SGJ_call("getBioGenDevAuth", strUserID, keyId, gonggoNum );
}

/**
* 보안토큰 개인 사용자 랜덤값 반환
* @param {String}strUserID 세션ID
* @return {String}보안토큰 개인 사용자랜덤값
*/
function SGJ_getBioUserRandom( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getBioUserRandom", strUserID);
}

/**
* 보안토큰 개인 주민번호 또는 사업자 번호 반환
* @param {String}strUserID 세션ID
* @return {String}보안토큰 개인 주민번호 또는 사업자번호
*/
function SGJ_getBioUserIDN( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';

	return SGJ_call("getBioUserIDN", strUserID);
}

/**
* 세션키로 암호화된 보안토큰 개인 주민번호 또는 사업자 번호 반환
* @param {String}strUserID 세션ID
* @return {String}세션키로 암호화된 보안토큰 개인 주민번호 또는 사업자번호
*/

function SGJ_getEncryptedBioUserIDN( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getEncryptedBioUserIDN", strUserID);
}

/**
* 보안토큰 시리얼 번호 반환
* @param {String}strUserID 세션ID
* @return {String}보안토큰 시리얼 번호
*/
function SGJ_getBioCSN( strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getBioCSN", strUserID);
}
//보안토큰 관련 추가 메소드 끝========================================

/**
* 실제 인증서가 저장된 경로 반환
* @param {String}strUserID 세션ID
* @return {String}인증서 저장경로
*/
function SGJ_getCertPath( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getCertPath", strUserID);
}

/**
* 인증서 시리얼넘버 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입 인증서
* @return {String}인증서 시리얼 넘버
*/
function SGJ_getSerialNumber( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getSerialNumber",  strUserID, strCert );
}

/**
* 인증서의 subjectDN 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 subjectDN
*/
function SGJ_getSubjectDN( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getSubjectDN",  strUserID, strCert );
}

/**
* 인증서의 IssuerDN 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 subjectDN
*/
function SGJ_getIssuerDN( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getIssuerDN", strUserID, strCert);
}

/**
* 인증서의 서명알고리즘 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 subjectDN
*/
function SGJ_getSigAlgName( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getSigAlgName", strUserID, strCert);
}

/**
* 인증서의 유효시작시점 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 유효 시작시점
*/

function SGJ_getNotBefore( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getNotBefore", strUserID, strCert);
}

/**
* 인증서의 유효종료시점 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 유효 종료시점
*/
function SGJ_getNotAfter( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getNotAfter", strUserID, strCert);
}


/**
* 인증서의 공개키 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 공개키(Hex)
*/
function SGJ_getPublicKey( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getPublicKey", strUserID, strCert);
}

/**
* 인증서의 키용도키 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서의 키용도
*/
function SGJ_getKeyUsage( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';

	return SGJ_call("getKeyUsage", strUserID, strCert);
}

/**
* 인증서의 정책 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서 정책
*/
function SGJ_getPolicy( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getPolicy", strUserID, strCert);
}

/**
* 인증서 정보 요약
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입의 인증서
* @return {String}인증서 정보 요약
*/
function SGJ_getCertInfo( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getCertInfo", strUserID, strCert);
}

/**
* 인증서 종류 반환
* @param {String}strUserID 세션ID
* @param {String}cert 인증서 스트링;
* @return {String} 인증서 종류("NPKI", "GPKI", "EPKI")
*/
function SGJ_getCertClass ( strUserID, strCert )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getCertClass", strUserID, strCert);
}

/**
* 주어진 인증서를 암호화된 랜덤값 반환
* @param {String}strUserID 세션ID
* @param {String}strCert PEM 타입 인증서
* @return {String}인증서로 암호화된 랜덤값(BASE64)
*/
function SGJ_getEncryptedRandomWithCert(strUserID, strCert)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strCert)) return '';

	return SGJ_call("getEncryptedRandom", strUserID, strCert);
}

/**
* 세션키로 암호화된 랜덤값 반환
* @param {String}strUserID 세션ID
* @return {String}세션키로 암호화된 랜덤값(BASE64)
*/
function SGJ_getEncryptedRandom(strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getEncryptedRandom", strUserID);
}

/**
* 랜덤값 반환
* @param {String}strUserID 세션ID
* @return {String}랜덤값(BASE64)
*/
function SGJ_getRandom(strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	
	return SGJ_call("getRandom", strUserID);
}


/**
* 해당 oid가 개인 범용인지 체크
* @param {String}policyId 정책OID
* @return {boolean} true 또는 false
*/
function SGJ_isGeneralPerson( strUserID, strCert )
{
	return SGJ_call("isGeneralPerson", strUserID, strCert );
}

/**
* 해당 oid가 사업자 범용인지 체크
* @param {String}policyId 정책OID
* @return {boolean} true 또는 false
*/
function SGJ_isGeneralBiz( strUserID, strCert )
{
	return SGJ_call("isGeneralBiz", strUserID, strCert );
}

/**
* 인증서의 비밀번호 체크
* @param {String}strUserID 세션ID
* @return {boolean} true 또는 false
*/
function SGJ_isCorrectPasswd( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return false;
	
	return SGJ_call("isCorrectPasswd", strUserID);
}

/**
* 인증서 복사
* 
*/
function SGJ_certCopy()
{
	return SGJ_call("certCopy");
}


/**
* 인증서 암호변경
*/
function SGJ_changePass()
{
	return SGJ_call("changePass");
}

/**
* 선택한 인증서 삭제
*/
function SGJ_deleteCert()
{	
	SGJ_setLayout( "EXT" );
	return SGJ_call("deleteCert");
}

/**
 * 인증서 내보내기
 */
function SGJ_exportCert()
{		
	return SGJ_call("exportCert");
}

/**
* 인증서 발급
* 
* @return {boolean} true 또는 false
*/
function SGJ_issueCert()
{
	return SGJ_call("issueCert");
}

/**
* RA 인증서 발급
* 
* @return {boolean} true 또는 false
*/
function SGJ_raIssueCert()
{
	return SGJ_call("raIssueCert");
}


/**
* 인증서 발급
* @param {String}authCode 참조번호
* @param {String}refNumber 인가코드
* @return {boolean} true 또는 false
*/
function SGJ_issueCertWithCode(authCode, refNumber)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, authCode, refNumber)) return false;
	
	return SGJ_call("issueCert", authCode, refNumber);
}

function SGJ_issueCertWithEncCode(type, encauthCode, refNumber, password, nid)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, type, encauthCode, refNumber, password, nid)) return false;
	
	return SGJ_call("issueCertEncAuthCode", type, encauthCode, refNumber, password, nid);
}

/**
* RA 인증서 발급
* @param {String}authCode 참조번호
* @param {String}refNumber 인가코드
* @return {boolean} true 또는 false
*/
function SGJ_raIssueCertWithCode(authCode, refNumber)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, authCode, refNumber)) return false;
	
	return SGJ_call("raIssueCert", authCode, refNumber);
}

function SGJ_raIssueCertWithEncCode(type, encauthCode, refNumber, password, nid)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, type, encauthCode, refNumber, password, nid)) return false;
	
	return SGJ_call("raIssueCertEncAuthCode", type, encauthCode, refNumber, password, nid);
}


/**
* 인증서 갱신
* 
* @return {boolean} true 또는 false
*/
function SGJ_updateCert()
{
	
	return SGJ_call("updateCert");
}

/**
* 인증서 재발급
* 
* @return {boolean} true 또는 false
*/
function SGJ_reIssueCert()
{
	
	return SGJ_call("reIssueCert");
}


/**
* 인증서 재발급
* @param {String}authCode 참조번호
* @param {String}refNumber 인가코드
* @return {boolean} true 또는 false
*/
function SGJ_reIssueCertWithCode(authCode, refNumber)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, authCode, refNumber)) return false;
	
	return SGJ_call("reIssueCert", authCode, refNumber);
}

function SGJ_reIssueCertWithEncCode(type, encauthCode, refNumber, password, nid)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, type, encauthCode, refNumber, password, nid)) return false;
	
	return SGJ_call("reIssueCertEncAuthCode", type, encauthCode, refNumber, password, nid);
}

/**
* 인증서 폐지
* 
* @return {boolean} true 또는 false
*/
function SGJ_revokeCert()
{
	
	return SGJ_call("revokeCert");
}

/**
* 인증서 효력정지
* 
* @return {boolean} true 또는 false
*/
function SGJ_stopCert()
{
	
	return SGJ_call("stopCert");
}


/**
* PC에서 모바일 기기로 인증서 내보내기
* @return {void}
*/
function SGJ_pcToMobile()
{
	return SGJ_call("pcToMobile");
}

/**
* 모바일 기기에서 PC로 인증서 내보내기
* @return {void}
*/
function SGJ_mobileToPc()
{
	return SGJ_call("mobileToPc");
}


/**
* 신원정보가 없는 인증서를 신원확인이 있는 인증서로 변환
* @param {String}host 요청을 보낼 CA IP
* @param {int}port 요청을 보낼 CA PORT
*/
function SGJ_addVidToCert(host, port)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, host, port)) return;
	
	return SGJ_call("addVidToCert", host, port);
}


/**
* 토큰의 비보안영역에 담긴 암호화된 키
* @param {String}strUserID 세션을 식별할 수 있는 ID
* @return {String}암호화된 키
*/
function SGJ_getTokenEncryptedKey(strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return;
	
	return SGJ_call("getTokenEncryptedKey", strUserID);
}

/**
* 토큰의 serial 번호
* @param {String}strUserID 세션을 식별할 수 있는 ID
* @return {String} 토큰 serial
*/
function SGJ_getTokenSerial(strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return;
	
	return SGJ_call("getTokenSerial", strUserID);
}

/**
* 암호화된 토큰의 serial 번호
* @param {String}strUserID 세션을 식별할 수 있는 ID
* @return {String}암호화된 토큰 serial
*/
function SGJ_getTokenEncSerial(strUserID)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return;
	
	return SGJ_call("getTokenEncSerial", strUserID);
}