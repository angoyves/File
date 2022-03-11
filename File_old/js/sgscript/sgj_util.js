/**
 * @fileoverview 유틸성 함수 스크립트
 *
 * @author hychul
 * @version 0.1
 */
var object_id = "TZAPP";
function SGJ_call(methodName)
{
	var SG = document.getElementById(object_id);
	var args = Array.prototype.slice.call(arguments, 1);
	var returnVal = SG.callApi(methodName, args);
	
	if((typeof returnVal ==  'boolean') &&  !returnVal)
	{
		//alert('실패야!!!');
		setErrorCode( "INVALID_RETURN_VALUE" );
		setErrorMsg(SGJ_getErrorMsg());
		setErrorFunction( "SGJ_" + methodName);
		return false;
	}
	else if((typeof returnVal ==  'string') &&  isNull(returnVal))
	{
		//alert('널이야!!!');
		setErrorCode( "INVALID_RETURN_VALUE" );
		setErrorMsg(SGJ_getErrorMsg());
		setErrorFunction( "SGJ_" + methodName);
		return "";
	}
	return returnVal;
}

function SGJ_getFunctionName(funcStr)
{
	return funcStr.match(/function ([^\(]+)/)[1];
}

function SGJ_checkParams(functionName)
{
	clearError();
	
	for(var i=1;i<arguments.length;i++)
	{
		if(isNull(arguments[i]))
		{
			setErrorCode( "PARAMETER_NULL" );
			setErrorFunction(functionName);
			return false;
		}
	}
	return true;
}

/**
* 해당 객체가 null 인지체크
* @param {String}string 객체
* @return {boolean} true 또는 false
*/
function isNull( string )
{
	if ( string == null || string == "")
		return true;
	return false;
}

/**
 * BIO HSM 목록을 세팅하는 함수
 * @param {String}lsit 바이오 토큰 드라이버 목록
 */
function SGJ_setBioHsmList( list )
{
	if ( isNull(list))
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_setBioHsmList()" );
		return;
	}
	return SGJ_call("setBioHsmList",  list);
}

/**
 * 암호화 키쌍 체크 여부 세팅
 * @param {boolean}암호화키쌍 체크 여부(디폴트는 체크함)
 */
function SGJ_setKmCheck( isKmCheck )
{
	return SGJ_call("setKmCheck",  isKmCheck);
}

/**
 * BIO 토큰 에러 목록 얻기
 * 
 * @return {String} 바이오 토큰 에러스택
 */
function SGJ_getBioErrorCodes()
{
	return SGJ_call("getBioErrorCodes");
}

/**
* Base64 인코딩된 String 반환
* @param {String}strMessage String
* @return {String} 인코딩된 메세지
*/
function SGJ_base64Encode( strMessage )
{
	if ( isNull(strMessage))
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_base64Encode()" );
		return "";
	}
	return SGJ_call("base64Encode", strMessage);
}


/**
* Base64 디코딩된 String 반환
* @param {String}strMessage BASE64 String
* @return {String} 디코딩된 메세지
*/
function SGJ_base64Decode( strMessage )
{
	if ( isNull(strMessage))
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_base64Decode()" );
		return "";
	}

	return SGJ_call("base64Decode", strMessage);
}

/**
* CA IP 및 포트 설정
* @param{String} ip CA IP
* @param{String} port CA PORT
*/
function SGJ_setCaInfo(ip, port)
{
	SGJ_call("setCaInfo", ip, port);
}

/**
* CA  url 설정
* @param{String} url CA 주소 URL
*/
function SGJ_setCaInfo(url)
{
	SGJ_call("setCaInfo", url);
}


/**
* 스마트폰 중계 서버 IP 및 포트 설정
* @param{String} ip 중계서버 IP
* @param{String} port 중계서버 PORT
*/
function SGJ_setMobileRelayInfo(ip, port)
{
	return SGJ_call("setMobileRelayInfo", ip, port);
}

/**
* 인증서 발급시 키 길이 설정
* @param{Integr} keyLength 인증서 발급시 키 길이 선택
*
*/
function SGJ_setKeyLength(keyLength)
{
	SGJ_call("setKeyLength", keyLength);
}

/**
* 선택한 인증서의 파일 경로 반환
* 
* @return {String} 선택한 파일의 경로
*/
function SGJ_getFilePath()
{
	return SGJ_call("getFilePath");
}


/**
* 선택창 로케일 설정
* @param{String} locale 로케일 스트링<br>
* ex) es_EC: 에콰도르, ko_KR: 한국, en_US: 미국
*/
function SGJ_setLocale(locale)
{
	return SGJ_call("setLocale", locale);
}

/**
* 애플릿 로드 완료후에 호출되는 callback
* @param{String} 완료후 메시지를 출력한다.<br>
*/
function SGJ_CheckLoaded(flag)
{
	if(flag == "DOWNLOAD")
		alert("프로그램 설치가 되어 있지 않거나 구버전의 프로그램이 설치되어 있습니다.");
		//location.href="http://ww.naver.com";
	else if(flag == "DONE")
		alert("애플릿 로딩 성공");
}


/**
* 사용자가 서명한 personInfoReq 메시지 반환
* @param {String}strUserID 세션식별이 가능한 세션 ID
* @param {String}userAgree 사용자 개인정보 제공 동의문자열
* @param {String}agreeInfo 요청할 서명정보
* @return {String} Pem 형태의 P#7 Signed personInfoReq 
*/
function SGJ_genPersonInfoReq(strUserID, userAgree, agreeInfo)
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, userAgree, agreeInfo)) '';
	return SGJ_call("genPersonInfoReq", strUserID, userAgree, agreeInfo);
}

function SGJ_getKmCert()
{
	//테스트 개인(A) --> 2012년 7월 11일 만료
	return
	 "-----BEGIN CERTIFICATE-----\r\n" + 
		"MIIE1zCCA7+gAwIBAgIEAZ9y+TANBgkqhkiG9w0BAQUFADBKMQswCQYDVQQGEwJL\r\n" + 
		"UjENMAsGA1UECgwES0lDQTEVMBMGA1UECwwMQWNjcmVkaXRlZENBMRUwEwYDVQQD\r\n" + 
		"DAxzaWduR0FURSBDQTIwHhcNMTEwNzExMDcxNjAwWhcNMTIwNzExMDcxNjAwWjCB\r\n" + 
		"kjELMAkGA1UEBhMCS1IxDTALBgNVBAoMBEtJQ0ExEzARBgNVBAsMCmxpY2Vuc2Vk\r\n" + 
		"Q0ExFjAUBgNVBAsMDVRFU1TrsJzquInsmqkxFjAUBgNVBAsMDVRFU1Tsnbjspp3s\r\n" + 
		"hJwxETAPBgNVBAsMCFJB7IS87YSwMRwwGgYDVQQDDBPthYzsiqTtirgo6rCc7J24\r\n" + 
		"LUEpMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDAcqHji6rEjENdvMetil84\r\n" + 
		"835BMVd0+6xa+fyOqnPUVmduvEEQhNMQc7wON4TqOqKgNjXQwSV6jraB745DVWjX\r\n" + 
		"ie3SYyylk3ybdXxbwlw3Bc+bm+ZVxOuNavHJS769v3UEbmsccX12ssBiVd23tm4V\r\n" + 
		"YDp2PywXxd2L9Q6u8HxtfwIDAQABo4IB/jCCAfowgY8GA1UdIwSBhzCBhIAUuQny\r\n" + 
		"tiFImiq6AlmAhieTFmp39VmhaKRmMGQxCzAJBgNVBAYTAktSMQ0wCwYDVQQKDARL\r\n" + 
		"SVNBMS4wLAYDVQQLDCVLb3JlYSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eSBDZW50\r\n" + 
		"cmFsMRYwFAYDVQQDDA1LSVNBIFJvb3RDQSAxggInYTAdBgNVHQ4EFgQUyiXskfgC\r\n" + 
		"vg15QPN93gRfRKw3SmEwDgYDVR0PAQH/BAQDAgUgMBcGA1UdIAQQMA4wDAYKKoMa\r\n" + 
		"jJpEBQIBAjB3BgNVHREEcDBugRNoeWNodWxAc2lnbmdhdGUuY29toFcGCSqDGoya\r\n" + 
		"RAoBAaBKMEgME+2FjOyKpO2KuCjqsJzsnbgtQSkwMTAvBgoqgxqMmkQKAQEBMCEw\r\n" + 
		"BwYFKw4DAhqgFgQUYxhU2is6NMLqiS+jHFCLpNOmESEwXwYDVR0fBFgwVjBUoFKg\r\n" + 
		"UIZObGRhcDovL2xkYXAuc2lnbmdhdGUuY29tOjM4OS9vdT1kcDVwMjA2MzEsb3U9\r\n" + 
		"Y3JsZHAsb3U9QWNjcmVkaXRlZENBLG89S0lDQSxjPUtSMEQGCCsGAQUFBwEBBDgw\r\n" + 
		"NjA0BggrBgEFBQcwAYYoaHR0cDovL29jc3Auc2lnbmdhdGUuY29tOjkwMjAvT0NT\r\n" + 
		"UFNlcnZlcjANBgkqhkiG9w0BAQUFAAOCAQEACkBMcqxmpBWDio0FsQkDUob1Jc6j\r\n" + 
		"R9tuKL/OFjoUHOx9jFzkcafq6wI57r9c77oGUSFOXkgBRdNAxkeiIGxdD3iEJa+1\r\n" + 
		"5Ko8DaNRXmmh+3U50FRN9ZXYoA3+K/ivlk77pifGlNTtJS7/V8qoEarkpwyhhEOz\r\n" + 
		"ShwNYRbdfcQ/bCAu2yy2jJYVJUL9CmLfRaFiyTWdgtjwiad56Fi6K2IQ+qW7P3bu\r\n" + 
		"6M/nqiTz+tGDkzjaP0dPq0/1WPLJka+TQQ2UDAoEfsIxdeizU3AJpEx7Gbv9Vqfy\r\n" + 
		"xw8McAxE3oPU5CJYFp9bVwX/KGfhAbR/9g95jO90RwZ5rbS0/QU0zbCjPQ==\r\n" + 
		"-----END CERTIFICATE-----";
}


/**
* 로컬 파일 시스템에 저장된 HTML파일에서
* 다른 파일의 상대 경로를 절대 경로로 바꾸어 준다
* @param {String}strFileName 파일의 절대 경로
* @return {String}성공 - 'SUCCESS', 실패 - ""
*/
function getLocalPath( strFileName )
{
	clearError();
	
	var strLocalPath = "";
	var pos = 0;
	var i = 0;

	if ( isNull(strFileName))
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "getLocalPath()" );
		return "";
	}

	var buf = location.href.substring( 0, 8 );
	if ( buf != "file:///" )
	{
		setErrorCode( "NOT_LOCAL_FILE" );
		return "";
	}

	buf = location.href.substring( 8, location.href.length );

	for ( i = 0; i < buf.length; i++ )
	{
		if ( buf.charAt(i) == "/" )
		{
			strLocalPath += "\\";
			pos = strLocalPath.length;
		} else if ( buf.charAt(i) == "%"
				&& buf.charAt(i+1) == "2"
				&& buf.charAt(i+2) == "0" )
		{
			strLocalPath += " ";
			i += 2;
		} else {
			strLocalPath += buf.charAt(i);
		}
	}

	strLocalPath = strLocalPath.substring( 0, pos ) + strFileName;

	return strLocalPath;
}

/**
* LF를 제거한 PEM 형식 인증서에 LF를 다시 추가하는 메소드
* @param {String}strCert LF 문자를 제거한 PEM 형식 인증서
* @param {String}outFilePath 목표 파일 절대 경로
* @return {String}성공	- LF가 포함된 PEM 형식 인증서, 실패	- ""
*/
function insertLF( strCert )
{
	clearError();
	
	if (isNull(strCert))
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "insertLF()" );
		return "";
	}

	var pemHeader	= "-----BEGIN CERTIFICATE-----";
	var pemTrailer	= "-----END CERTIFICATE-----";
	var buf = removeCRLF( strCert );

	var i = 0;
	var nCount = 0;
	for ( i = 0; i < pemHeader.length; i++ )
	{
		if ( pemHeader.charAt( i ) == buf.charAt( i ) )
		{
			nCount = nCount + 1;
		}
	}
	if  ( nCount != pemHeader.length )
	{
		setErrorCode("NOT_PEM_CERT");
		setErrorFunction( "insertLFtoPEMCert()" );
		return "";
	}

	nCount = 0;
	for ( i = 0; i < pemTrailer.length; i++ )
	{
		if ( pemTrailer.charAt( i ) == buf.charAt( buf.length - pemTrailer.length + i ) )
		{
			nCount = nCount + 1;
		}
	}
	if  ( nCount != pemTrailer.length )
	{
		setErrorCode("NOT_PEM_CERT");
		setErrorFunction( "insertLFtoPEMCert()" );
		return "";
	}

	var strPEMCert = "";
	nCount = 0;
	for ( i = 0; i < buf.length - pemHeader.length - pemTrailer.length; i++ )
	{
		strPEMCert += buf.charAt( i + pemHeader.length );
		nCount = nCount + 1;
		if ( nCount == 64 )
		{
			strPEMCert += '\n';
			nCount = 0;
		}
	}

	strPEMCert = pemHeader + "\n" + strPEMCert + "\n" + pemTrailer;

	return strPEMCert;
}

/**
 * 에러 처리를 합니다.
 * 
 * @param {String} msg 출력할 메시지
 * @param {String} value 값
 * @return {boolean} 값이 있는지 체크
 */
function errHandler(msg, value )
{
	if ( value == 0 | value == null | value == "" )
	{
		alert('Failed to get ' + msg);
		return false;
	}
	else
		return true;
}

/**
 * 폼의 값이 널인지 체크합니다.
 * @param {String} 폼의 이름
 * @param {String} value 폼값
 * @return {boolean} 폼 값의 null 여부
 */
function formCheck (msg, formValue)
{
	if (isNull(formValue))
	{
		alert('Cannot find ' + msg + '!!');
		return false;
	} else return true;
}
/**
 * 문자열의 앞뒤 공백을 없앱니다.
* @param {String}value 임의의 String
* @return {String} 앞뒤공백이 제거된 스트링 
 */
function trim(value) {
	value = value.replace(/^\s+/, "");  // remove leading white spaces
	value = value.replace(/\s+$/g, ""); // remove trailing while spaces
	return value;
}

/**
 * 문자열의 캐리지리턴을 없앱니다.
* @param {String} value 임의의 String
* @return {String} \r 이 제거된 문자열 
 */
function removeCR(value)
{
	return value.replace(/\r/,"");
}

/**
 * 문자열의 라인피드를 없앱니다.
* @param {String} value 임의의 String
* @return {String} \n 이 제거된 문자열 
 */
function removeLF(value)
{
	return value.replace(/\n/,"");
}

/** 입력으로 들어온 스트링의 CRLF를 삭제하는 메소드
* @param {String}str 임의의 String
* @return {String} CRLF가 제거된 스트링
*/
function removeCRLF( str )
{
	var i = 0;
	var buf = "";
	for( i = 0; i < str.length; i++ )
	{
		if ( str.charAt(i) != '\n' && str.charAt(i) != '\r' )
			buf += str.charAt(i);
	}
	return buf;
}

/**
 * 애플릿 파일 브라우저로 파일 선택후 파라미터변수에 값으로 넣어줌
 * @param {Object}inputform Form 객체
 */
function getFilePath(inputform)
{
	inputform.value = SGJ_getFilePath();
}
