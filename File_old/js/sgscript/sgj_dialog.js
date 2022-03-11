/**
 * @fileoverview 인증서 선택창 관련 설정 스크립트
 *
 * @author hychul
 * @version 0.1
 */

/**
* 인증서 선택창 띄우는 메소드
* 세션에 이미 인증서 정보가 존재하면 true 반환
* 창을 띄우다 오류가 발생하면 false 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @return {boolean} true 또는 false
*/
function SGJ_selectCertificate( strUserId )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId)) return false;
	
	//조달청시 이 부분 주석처리
	strUserId = getMac(strUserId) + strUserId;
	return SGJ_call("selectCertificate", strUserId);
}


/**
* 인증서 선택창 배너이미지 설정
* @param {String}imagePath 이미지 Url 경로
* @return {void}
*/
function SGJ_setBannerImage( imagePath )
{
	return SGJ_call("setBannerImage", imagePath);
}

/**
* 인증서 선택창에 보여질 인증서 정책 설정
* @param {String}policyList 보여질 정책 리스트
* @return {void}
*/
function SGJ_setCertPolicy( policyList )
{
	return SGJ_call("setCertPolicy", policyList);
}


/**
* 인증서 레이아웃 설정
* @param {String}layout 레이아웃 형태("NORMAL" | "EXT");
* @return {void}
*/
function SGJ_setLayout( layout )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, layout)) return;
	
	return SGJ_call("setLayout", layout);
}

/**
* <pre>
* 활성화 미디어 설정
* mediaType 에 허용 가능한 값
* "" -> 모든 매체 비활성화
* location_hdd -> 하드디스크
* location_removable -> 이동식디스크
* location_token -> 저장토큰
* location_hsm -> 보안토큰
* location_bhsm -> 바이오 보안토큰
* location_mp -> 휴대폰
* 복수로 쓰려면 구분자 "|"를 사용
* ex) location_hdd|location_token
* </pre>
* @param {String}mediaType 활성화 시킬 미디어 타입
* @return {void}
*/
function SGJ_setEnableMedia( mediaType )
{
	return SGJ_call("setEnableMedia", mediaType);
}

/**
 * 저장매체란에 휴대폰을 나오게 할지 결정한다.
 * @param {boolean}isEnable 활성화 여부
 * @return {void}
 */
function SGJ_setMPEnable( isEnable )
{
	return SGJ_call("setMPEnable", isEnable);
}

/**
 * 저장매체란에 바이오토큰을 나오게 할지 결정한다.
 * @param {boolean} isEnable 활성화 여부
 * @return {void}
 */
function SGJ_setBIOEnable( isEnable )
{
	return SGJ_call("setBIOEnable", isEnable);
}

/**
* 서로 다른 세션 연계
* @param {String}strUserId 연계시킬 세션 ID<br>
* @return {void}
*/
function SGJ_setPreSessionId( strUserId )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId)) return;
	
	return SGJ_call("setPreSessionId", strUserId);
}

/**
* 이전 세션에 선택했던 인증서만 보이도록 세팅
* @param {String}strUserId 기존 세션 ID<br>
* @return {void}
*/
function SGJ_setLimitDn( strUserId )
{
	return SGJ_call("setLimitDn", strUserId);
}

/**
* 이전 세션에 선택했던 인증서만 보이도록 세팅
* @param {String}strUserId 기존 세션 ID<br>
* @return {void}
*/
function SGJ_setPreSetting( strUserId )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserId)) return;
	
	return SGJ_call("setPreSetting", strUserId);
}


/**
* 이전 세션에 선택했던 인증서만 보이도록 하는 세팅을 초기화
* @return {void}
*/
function SGJ_resetPreSetting()
{
	return SGJ_call("resetPreSetting");
}


/**
* 만료된 인증서를 선택창에 보여줄것인지 세팅
* @param {boolean}viewExpiredCert 만료된 인증서를<br>
* 선택창에 보여줄것인지 세팅<br>
* 디폴트값 true<br>
* 
* @return {void}
*/
function SGJ_setViewExpiredCert(viewExpiredCert)
{
	
	return SGJ_call("setViewExpiredCert", viewExpiredCert);
}


/**
* 인증서 선택창에서 갱신 경고창을 여부 세팅
* @param {boolean}setting 갱신 경고창 설정 여부<br>
* @return {void}
*/
function SGJ_setUpdateWran ( setting )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, setting)) return;
	
	return SGJ_call("setUpdateWran", setting);
}


/**
 * 인증서 선택창 설정정보 세팅
 * @return {void}
 */
function SGJ_getConfigMap()
{
	
	return SGJ_call("getConfigMap");
}

/**
* <pre>
* 사용자가 선택한 인증서가 담긴 미디어 타입 반환
* location_hdd -> 하드디스크
* location_removable -> 이동식디스크
* location_token -> 저장토큰
* location_hsm -> 보안토큰
* location_bhsm -> 바이오 보안토큰
* location_mp -> 휴대폰
* </pre>
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @return {String}사용자가 선택한 인증서가 담긴 미디어 타입
*/
function SGJ_getSelectedMedia( strUserID )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID)) return '';
	return SGJ_call("getSelectedMedia", strUserID);
}

//토큰관련 스크립트
/**
* <pre>
* 토큰 윈도우 선택창을  띄우는 함수
* </pre>
*/
function SGJ_startTokenWindow ()
{
	return SGJ_call("startTokenWindow", getMac(''));
}

/**
* <pre>
* 토큰 driver 설치 URL 세팅 함수
* </pre>
* @param {String}토큰 driver 설치 URL 
*/
function SGJ_setTokenInstallUrl(url)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, url)) return 0;
	return SGJ_call("setTokenInstallUrl", url);
}

/**
* <pre>
* 토큰에서 키가 나누어진 개수
* </pre>
* @param {String}totalTokenCnt 토큰이 나누어진 개수
*/
function SGJ_setTokenCnt( totalTokenCnt )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, totalTokenCnt)) return 0;
	return SGJ_call("setTokenCnt", totalTokenCnt);
}

/**
* <pre>
* 토큰모드 설정
* 0 : READ_TOKEN_MOD
* 1 : WRITE_TO_TOKEN_MOD
* 2 : EACH_READ_TOKEN_MOD
* </pre>
* @param {String}tokenMode 토큰 동작 모드
*/
function SGJ_setTokenMode( tokenMode )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, tokenMode)) return 0;
	return SGJ_call("setTokenMode", tokenMode);
}

/**
* <pre>
* 토큰 로고 설정
* 0 : READ_TOKEN_MOD
* 1 : WRITE_TO_TOKEN_MOD
* 2 : EACH_READ_TOKEN_MOD
* </pre>
* @param {String}file 로고 URL
*/
function SGJ_setTokenLogo( file )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, file)) return;
	return SGJ_call("setTokenLogo", file);
}

/**
* <pre>
* 토큰 동작중 에러 발생시 에러메시지 반환
* </pre>
*/
function SGJ_getTokenErrMsg()
{
	return SGJ_call("getTokenErrMsg");
}

/**
* <pre>
* 개인키 암호화시 사용할 암호화 알고리즘 입력
* </pre>
* @param {String}cipherAlgorithm 암호화 알고리즘
*/
function SGJ_setTokenEncAlgorithm(cipherAlgorithm)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, cipherAlgorithm)) return '';
	return SGJ_call("setTokenEncAlgorithm", cipherAlgorithm);
}

/**
* <pre>
* 토큰에 저장된 공개키의 BASE64 인코딩 문자열
* </pre>
*/
function SGJ_getTokenPubKeyDataToBase64()
{
	return SGJ_call("getTokenPubKeyDataToBase64");
}

/**
* <pre>
* 토큰에 저장된 개인키의 BASE64 인코딩 문자열
* </pre>
*/
function SGJ_getTokenPriKeyDataToBase64()
{
	return SGJ_call("getTokenPriKeyDataToBase64");
}

/**
* <pre>
* 토큰에 저장된 공개키와 개인키로 만든 CMS 데이터반환
* </pre>
*/
function SGJ_genTokenCMSSignedDataToBase64( orgData )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, orgData)) return '';
	return SGJ_call("genTokenCMSSignedDataToBase64", orgData);
}

/**
* <pre>
* 키 분리 개수 반환
* </pre>
* @return {String}키분리 개수
*/
function SGJ_getTotalTokenCnt()
{
	return SGJ_call("getTotalTokenCnt");
}

/**
* <pre>
* 현재사용중인 토큰 모델명
* </pre>
* @return {String}토큰 모델명
*/
function SGJ_getTokenModel()
{
	return SGJ_call("getTokenModel");
}

/**
* <pre>
* 현재 사용중인 토큰의 제조사명
* </pre>
* @return {String}토큰의 제조사명
*/
function SGJ_getTokenManufacturer()
{
	return SGJ_call("getTokenManufacturer");
}

/**
* <pre>
* 현재 사용중인 토큰의 시리얼
* </pre>
* @return {String}토큰의 시리얼
*/
function SGJ_getTokenSerialNumber()
{
	return SGJ_call("getTokenSerialNumber");
}

/**
* <pre>
* 현재 사용중인 토큰의 키타입
* </pre>
* @return {String} 토큰 키타입
*/
function SGJ_getTokenKeyType()
{
	return SGJ_call("getTokenKeyType");
}
