/**
 * @fileoverview PKCS7 생성 및 검증 스트립트
 *
 * @author hychul
 * @version 0.1
 */
/**
* PKCS#7 Signed 메세지에 서명을 추가하는 메소드
* @param{String} strUserID  세션ID
* @param{String} data 원본 pkcs7 데이터
* @return{String} 서명이 추가된 PKCS#7 Signed 메세지
*/
function SGJ_addSignPKCS7File(strUserID, data)
{
	return SGJ_addSignPKCS7FileWithAlgo(strUserID, data , 'SHA1');
}

/**
* PKCS#7 Signed 메세지에 서명을 추가하는 메소드
* @param{String} strUserID  세션ID
* @param{String} data 원본 pkcs7 데이터
* @param{String} 해쉬 알고리즘
* @return{String} 서명이 추가된 PKCS#7 Signed 메세지
*/
function SGJ_addSignPKCS7FileWithAlgo(strUserID, data, algorithm)
{
	return SG.SGJ_genPKCS7SignedDataWithAlgo(strUserID, data, algorithm);
}

/**
* 파일기반으로 PKCS#7 Signed 메세지에 서명을 추가하는 메소드
* @param{String} strUserID  세션ID
* @param{String} data 원본 pkcs7 데이터
* @return{String} 서명이 추가된 PKCS#7 Signed 메세지
*/

function SGJ_addSignPKCS7Data(strUserID, data)
{
	return SGJ_genPKCS7SignedDataWithAlgo(strUserID, data , 'SHA1');
}


/**
* 파일 기반으로 PKCS#7 Signed 메세지에 서명을 추가하는 메소드
* @param{String} strUserID  세션ID
* @param{String} data 원본 pkcs7 데이터
* @param{String} 해쉬 알고리즘
* @return{String} 서명이 추가된 PKCS#7 Signed 메세지
*/
function SGJ_addSignPKCS7DataWithAlgo(strUserID, data, algorithm)
{
	return SG.SGJ_addSignPKCS7DataWithAlgo(strUserID, data , algorithm);
}

/**
* PKCS#7 Signed 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} strMessage 원본 메세지
* @return{String} PKCS#7 Signed 메세지
*/
function SGJ_genPKCS7SignedData(strUserID, data)
{
	return SGJ_genPKCS7SignedDataWithAlgo(strUserID, data , 'SHA1');
}

/**
* PKCS#7 Signed 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} strMessage 원본 메세지
* @return{String} PKCS#7 Signed 메세지
*/
function SGJ_genPKCS7SignedDataWithAlgo(strUserID, data, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, data, algorithm)) return '';
	
	return SGJ_call("genPKCS7SignedData",  strUserID, data, algorithm );
}

/**
* 파일 기반의 PKCS#7 Signed 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} strInputFilePath 원본 파일 경로
* @param{String} strOutputFilePath PKCS#7 Signed 메세지 파일 경로
* @return{String} PKCS#7 Signed 메세지
*/
function SGJ_genPKCS7SignedFile( strUserID, strInputFilePath, strOutputFilePath, fileType)
{
	return SGJ_genPKCS7SignedFileWithAlgo( strUserID, strInputFilePath, strOutputFilePath, 'SHA1', fileType);
}


/**
* 파일 기반의 PKCS#7 Signed 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} strInputFilePath 원본 파일 경로
* @param{String} strOutputFilePath PKCS#7 Signed 메세지 파일 경로
* @return{String} PKCS#7 Signed 메세지
*/
function SGJ_genPKCS7SignedFileWithAlgo( strUserID, strInputFilePath, strOutputFilePath, algorithm, fileType)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strInputFilePath, strOutputFilePath, algorithm, fileType)) return false;
	
	return SGJ_call("genPKCS7SignedFile", strUserID, strInputFilePath, strOutputFilePath, algorithm, fileType);
}

/**
* PKCS#7 Signed 메세지에 서명자 추가 메소드
* @param{String} strUserID  세션ID
* @param{String} strP7Msg  PKCS#7 Signed 메세지
* @return{String} 서명자가 추가된 PKCS#7 Signed 메세지
*/
function SGJ_addSignPKCS7Data( strUserID, strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strP7Msg)) return '';
	
	return SGJ_call("addSignPKCS7Data", strUserID, strP7Msg );
}
/**
* 파일기반의 PKCS#7 Signed 메세지에 서명자 추가 메소드
* @param{String} strUserID  세션ID
* @param{String} strP7FilePath  PKCS#7 Signed 메세지 파일 경로
* @param{String} strOutputFilePath  생성될 PKCS#7 Signed 메세지 경로
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_addSignPKCS7File( strUserID, strP7FilePath, strOutputFilePath)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strP7FilePath, strOutputFilePath)) return false;
	
	return SGJ_call("addSignPKCS7File", strUserID, strP7FilePath, strOutputFilePath );
}

/**
 * <pre>
* PKCS#7 Enveloped 메세지 생성
* 디폴트 암호화 알고리즘: 'SEED/CBC/PKCS5'
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data  암호화할 데이터
* @return{String} PKCS#7 Enveloped 메시지
*/
function SGJ_genPKCS7EnvelopedData( strUserID, kmCert, data )
{
	return SGJ_genPKCS7EnvelopedDataWithAlgo( strUserID, kmCert, data, 'SEED/CBC/PKCS5' );
}

/**
* PKCS#7 Enveloped 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 암호화할 데이터
* @param{String} algorithm 암호화 알고리즘
* @return {String}PKCS#7 Enveloped 메세지
*/
function SGJ_genPKCS7EnvelopedDataWithAlgo( strUserID, kmCert, data, algorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, data, algorithm)) return '';
	
	return SGJ_call("genPKCS7EnvelopedData",  strUserID, kmCert, data, algorithm );
}

/**
 * <pre>
* PKCS#7 Enveloped 메세지 생성
* 기본 암호화 알고리즘: 'SEED/CBC/PKCS5'
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일명
* @param{String} strOutputFilePath 출력파일명
* @param{String} fileType 생성할 파일 타입("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genPKCS7EnvelopedFile( strUserID, kmCert, strInputFilePath, strOutputFilePath, fileType )
{
	return SGJ_genPKCS7EnvelopedFileWithAlgo( strUserID, kmCert, strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5', fileType );
}


/**
* 파일 기반의 PKCS#7 Enveloped 생성
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 원본 메세지 파일 경로
* @param{String} strOutputFilePath 상대방의 인증서
* @param{String} algorithm 암호화 알고리즘
* @param{String} fileType 파일타입("DER", "PEM")
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genPKCS7EnvelopedFileWithAlgo( strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType)) return false;
	
	return SGJ_call("genPKCS7EnvelopedFile",  strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType );
}

/**
 * <pre>
* 다중 PKCS#7 Enveloped 메세지 생성
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* 기본 암호화 알고리즘: 'SEED/CBC/PKCS5'
* </pre>
* 
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 암호화할 데이터
* @return {String}PKCS#7 Enveloped 메세지
*/
function SGJ_genMultiPKCS7EnvelopedData(strUserID, kmCert, data)
{
	return SGJ_genMultiPKCS7EnvelopedDataWithAlgo(strUserID, kmCert, data, 'SEED/CBC/PKCS5');
}

/**
 * <pre>
* 다중 PKCS#7 Enveloped 메시지 생성
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* </pre>
* 
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 암호화할 데이터
* @param{String} algorithm 암호화 알고리즘
* @return {String}PKCS#7 Enveloped 메세지
*/
function SGJ_genMultiPKCS7EnvelopedDataWithAlgo(strUserID, kmCert, data, algorithm)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, data, algorithm)) return '';
	
	return SGJ_call("genMultiPKCS7EnvelopedData",strUserID, kmCert, data, algorithm);
}


/**
 * <pre>
* 파일 기반의 다중 PKCS#7 Enveloped 메세지 생성
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* 기본 암호화 알고리즘: 'SEED/CBC/PKCS5'
* </pre>
* 
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일
* @param{String} strOutputFilePath 출력파일
* @param{String} fileType 파일타입("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genMultiPKCS7EnvelopedFile(strUserID, kmCert, strInputFilePath, strOutputFilePath, fileType)
{
	return SGJ_genMultiPKCS7EnvelopedFileWithAlgo(strUserID, kmCert, strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5', fileType);
}

/**
 * <pre>
* 파일 기반의 다중 PKCS#7 Enveloped 메세지 생성
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* </pre>
* 
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일
* @param{String} strOutputFilePath 출력파일
* @param{String} algorithm 암호화 알고리즘
* @param{String} fileType 파일타입("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genMultiPKCS7EnvelopedFileWithAlgo(strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType)) return false;
	
	return SGJ_call("genMultiPKCS7EnvelopedFile", strUserID, kmCert, strInputFilePath, strOutputFilePath, algorithm, fileType );
}


/**
 * <pre>
* PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* 기본 암호화 알고리즘: SEED/CBC/PKCS5
* 기본 서명 알고리즘: SHA1
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 서명 및 암호화할 데이터
* @return{String} PKCS#7 SignedAndEnveloped 메세지
*/
function SGJ_genPKCS7SignEnvData( strUserID, kmCert, data)
{
	return SGJ_genPKCS7SignEnvDataWithAlgo( strUserID, kmCert, data, 'SEED/CBC/PKCS5', 'SHA1' );
}

/**
* PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 서명 및 암호화할 데이터
* @param{String} encAlgorithm 암호화 알고리즘
* @param{String} signAlgorithm 서명 알고리즘
* @return{String} PKCS#7 SignedAndEnveloped 메세지
*/
function SGJ_genPKCS7SignEnvDataWithAlgo( strUserID, kmCert, data, encAlgorithm, signAlgorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, data, encAlgorithm)) return '';
	
	return SGJ_call("genPKCS7SignEnvData",  strUserID, kmCert, data, encAlgorithm, signAlgorithm );
}

/**
* 파일 기반의 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* 기본 암호화 알고리즘: SEED/CBC/PKCS5 
* 기본 서명 알고리즘: SHA1
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 원본 파일 경로
* @param{String} strOutputFilePath 출력파일 경로
* @param{String} fileTyep 생성할 파일 타입 ("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genPKCS7SignEnvFile( strUserID, kmCert, strInputFilePath, strOutputFilePath, fileType )
{
	return SGJ_genPKCS7SignEnvFileWithAlgo( strUserID, kmCert, strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5', 'SHA1', fileType );
}

/**
* 파일 기반의 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일 경로
* @param{String} strOutputFilePath 출력파일 경로
* @param{String} encAlgorithm 암호화 알고리즘
* @param{String} signAlgorithm 서명알고리즘
* @param{String} fileTyep 생성할 파일 타입 ("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genPKCS7SignEnvFileWithAlgo( strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, signAlgorithm, fileType )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, fileType)) return false;
	
	return SGJ_call("genPKCS7SignEnvFile", strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, signAlgorithm, fileType );
}

/**
 * <pre>
* 다중 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* 기본 암호화 알고리즘: SEED/CBC/PKCS5
* 기본 서명 알고리즘: SHA1
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 암호화 및 전자서명 데이터
* @return {String} PKCS#7 SignedAndEnveloped 메세지
*/
function SGJ_genMultiPKCS7SignEnvData ( strUserID, kmCert, data)
{
	return SGJ_genMultiPKCS7SignEnvDataWithAlgo ( strUserID, kmCert, data, 'SEED/CBC/PKCS5', 'SHA1' );
}

/**
 * <pre>
* 다중 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* 자신의 인증서와 매개변수로 주어진 인증서로 이중 암호화
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} data 암호화 및 전자서명 데이터
* @param{String} encAlgorithm 암호화 알고리즘
* @param{String} signAlgorithm 전자서명 알고리즘
* @return {String} PKCS#7 SignedAndEnveloped 메세지
*/
function SGJ_genMultiPKCS7SignEnvDataWithAlgo ( strUserID, kmCert, data, encAlgorithm, signAlgorithm )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, data, encAlgorithm)) return '';
	
	return SGJ_call("genMultiPKCS7SignEnvData", strUserID, kmCert, data, encAlgorithm, signAlgorithm );
}

/**
 * <pre>
* 파일 기반의 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* 기본 암호화 알고리즘: SEED/CBC/PKCS5
* 기본 서명 알고리즘: SHA1
* </pre>
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일 경로
* @param{String} strOutputFilePath 출력파일 경로
* @param{String} fileTyep 생성할 파일 타입 ("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genMultiPKCS7SignEnvFile(strUserID, kmCert, strInputFilePath, strOutputFilePath, fileType)
{
	return SGJ_genMultiPKCS7SignEnvFileWithAlgo(strUserID, kmCert, strInputFilePath, strOutputFilePath, 'SEED/CBC/PKCS5', 'SHA1', fileType);
}

/**
* 파일 기반의 PKCS#7 SignedAndEnveloped 메세지 생성 메소드
* @param{String} strUserID  세션ID
* @param{String} kmCert 암호화에 사용할 인증서
* @param{String} strInputFilePath 입력파일 경로
* @param{String} strOutputFilePath 출력파일 경로
* @param{String} encAlgorithm 암호화 알고리즘
* @param{String} signAlgorithm 서명알고리즘
* @param{String} fileTyep 생성할 파일 타입 ("DER", "PEM");
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_genMultiPKCS7SignEnvFileWithAlgo( strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, signAlgorithm, fileType)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, fileType)) return false;
	
	return SGJ_call("genMultiPKCS7SignEnvFile",  strUserID, kmCert, strInputFilePath, strOutputFilePath, encAlgorithm, signAlgorithm, fileType );
}

/**
* PKCS#7 메세지 검증 메소드
* @param{String} strUserID  세션ID
* @param{String} strP7Msg PKCS#7 메시지
* @return {String} 원본 메시지
*/
function SGJ_verifyPKCS7Data( strUserID, strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strP7Msg)) return '';

	return SGJ_call("verifyPKCS7Data",  strUserID, strP7Msg );
}

/**
* PKCS#7 메세지 검증 메소드
* @param{String} strP7Msg PKCS#7 메시지
* @return {String} 원본 메시지
*/
function SGJ_verifyPKCS7SignedData( strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strP7Msg)) return '';
	
	return SGJ_call("verifyPKCS7SignedData", strP7Msg );
}

/**
* PKCS#7 Enveloped 메세지 검증 메소드
* @param{String} strUserID 세션식별이 가능한 ID
* @param{String} strP7Msg PKCS#7 Enveloped 메시지
* @return {String} 원본 메시지
*/
function SGJ_verifyPKCS7EnvelopedData( strUserID, strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strP7Msg)) return '';

	return SGJ_call("verifyPKCS7EnvelopedData", strP7Msg );
}

/**
* PKCS#7 SignedAndEnveloped 메세지 검증 메소드
* @param{String} strUserID 세션식별이 가능한 ID
* @param{String} strP7Msg PKCS#7 SignedAndEnveloped 메시지
* @return {String} 원본 메시지
*/
function SGJ_verifyPKCS7SignEnvData( strUserID, strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, strP7Msg)) return '';
	
	return SGJ_call("verifyPKCS7SignEnvData", strP7Msg );
}

/**
* PKCS#7 파일 검증 메소드
* @param{String} strUserID  세션ID
* @param{String} p7File PKCS#7 파일
* @param{String} orgFIle 원본 파일
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_verifyPKCS7File(strUserID, p7File, orgFile)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, p7File, orgFile)) return false;
	
	return SGJ_call("verifyPKCS7File",  strUserID, p7File, orgFile );
}

/**
* PKCS#7 Signed 파일 검증 메소드
* @param{String} p7File PKCS #7 Signed 파일
* @param{String} orgFile 생성될 원본 파일
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_verifyPKCS7SignedFile( p7File, orgFile )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, p7File, orgFile)) return false;
	
	return SGJ_call("verifyPKCS7SignedFile",   strUserID, p7File, orgFile );
}


/**
* PKCS#7 Enveloped 파일 검증 메소드
* @param{String} strUserID  세션ID
* @param{String} p7File PKCS#7 Enveloped 파일
* @param{String} orgFile 원본 파일
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_verifyPKCS7EnvelopedFile( strUserID, p7File, orgFile )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, p7File, orgFile)) return false;
	
	return SGJ_call("verifyPKCS7EnvelopedFile", strUserID, p7File, orgFile );
}

/**
* PKCS#7 SignAndEnveloped 파일 검증 메소드
* @param{String} strUserID  세션ID
* @param{String} p7File PKCS#7 SignAndEnveloped 파일
* @param{String} orgFile 원본 파일
* @return {boolean} 성공 여부(true|false)
*/
function SGJ_verifyPKCS7SignEnvFile(strUserID, p7File, orgFile)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strUserID, p7File, orgFile)) return false;
	
	return SGJ_call("verifyPKCS7SignEnvFile", strUserID, p7File, orgFile );
}

/**
* PKCS #7 메세지의 타입을 반환
* @param{String} strP7Msg PKCS #7 메세지
* @return{String} 성공 : (PKCS7SignedMessage|PKCS7EnvelopedMessage|PKCS7SignedAndEnvelopedMessage)
*		  실패 : ""
*/
function SGJ_getPKCS7Type( strP7Msg )
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strP7Msg)) return false;

	return SGJ_call("getPKCS7Type",  strP7Msg );
}

/**
* PKCS #7 메세지의 타입을 반환
* @param{String} strP7FilePath PKCS#7 파일
* @return{String} 성공 : (PKCS7SignedMessage|PKCS7EnvelopedMessage|PKCS7SignedAndEnvelopedMessage)
*		  실패 : ""
*/
function SGJ_getPKCS7TypeFile( strP7FilePath)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strP7FilePath)) return '';

	return SGJ_call("getPKCS7TypeFile",  strP7FilePath );
}


/**
* PKCS #7 Signed 메시지에서 주어진 색인번호의 인증서를 반환
* @param{String} p7Data PKCS #7 메세지
* @param{Integer} index 색인 번호
* @return{String} 인증서 스트링
*/
function SGJ_getSignerCert(p7Data, index)
{
	
	if( isNull(p7Data) || index < 0)
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_getSignerCert()" );
		return "" ;
	}
	return SGJ_call("getSignerCert",p7Data, index);
}

/**
* PKCS #7 Signed 메시지에서 주어진 색인번호의 서명시간을 반환
* @param{String} p7Data PKCS #7 메세지
* @param{Integer} index 색인번호
* @return{String} 인증서 서명시간
*/
function SGJ_getSigningTime(p7Data, index)
{
	
	
	if( isNull(p7Data) || index < 0)
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_getSigningTime()" );
		return "" ;
	}
	return SGJ_call("getSigningTime",p7Data, index);
}

/**
* PKCS #7 Signed 메시지에서 주어진 DN을 가진 인증서를 반환
* @param{String} p7Data PKCS #7 메세지
* @param{String} subjectDN 인증서DN
* @return{String} 인증서 스트링
*/
function SGJ_getSignerCertwithDN(p7Data, subjectDN)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7Data, subjectDN)) return '';

	return SGJ_call("getSignerCert",p7Data, subjectDN);
}

/**
* PKCS #7 Signed 메시지에서 주어진 DN을 가진 서명시간 반환
* @param{String} p7Data PKCS #7 메세지
* @param{String} subjectDN 인증서DN
* @return{String} 서명시간
*/
function SGJ_getSigningTimeWithDN(p7Data, subjectDN)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7Data, subjectDN)) return '';
	
	return SGJ_call("getSigningTime",p7Data, subjectDN);
}

/**
* PKCS #7 Signed 메시지에서 서명자의 수 반환
* @param{String} p7Data PKCS #7 메세지
* @return{Integer} 서명자수
*/
function SGJ_getSignerCount(p7Data)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7Data)) return 0;
	
	return SGJ_call("getSignerCount",p7Data);
}

/**
* PKCS #7 Signed 파일에서 주어진 색인번호의 인증서를 반환
* @param{String} p7File PKCS #7 파일
* @param{Integer} index 색인번호
* @return{String} 인증서 스트링
*/
function SGJ_getSignerCertFile(p7File, index)
{
	
	
	if( isNull(p7File) || index < 0)
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_getSignerCertFile()" );
		return "" ;
	}
	return SGJ_call("getSignerCertFile", p7File, index);
}

/**
* PKCS #7 Signed 파일에서 주어진 색인번호의 서명시간 반환
* @param{String} p7File PKCS #7 파일
* @param{Integer} index 색인번호
* @return{String} 서명시간
*/
function SGJ_getSigningTimeFile(p7File, index)
{
	
	
	if( isNull(p7File) || index < 0)
	{
		setErrorCode( "PARAMETER_NULL" );
		setErrorFunction( "SGJ_getSigningTimeFile()" );
		return "" ;
	}
	return SGJ_call("getSigningTimeFile", p7File, index);
}


/**
* PKCS #7 Signed 파일에서 주어진 DN을 가진 인증서를 반환
* @param{String} p7File PKCS #7 파일
* @param{String} subjectDN 인증서DN
* @return{String} 인증서 스트링
*/
function SGJ_getSignerCertFileWithDN(p7File, subjectDN)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7File, subjectDN)) return '';
	
	return SGJ_call("getSignerCertFile",p7File, subjectDN);
}

/**
* PKCS #7 Signed 파일에서 주어진 DN을 가진 셔멍시간 반환
* @param{String} p7File PKCS #7 파일
* @param{String} subjectDN 인증서DN
* @return{String} 서명시간
*/
function SGJ_getSigningTimeFileWithDN(p7File, subjectDN)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7File, subjectDN)) return '';
	
	return SGJ_call("getSigningTimeFile",p7File, subjectDN);
}

/**
* PKCS #7 Signed 파일에서 서명자의 수 반환
* @param{String} p7File PKCS #7 파일
* @return{Integer} 서명자수
*/
function SGJ_getSignerCountFile(p7File)
{
	
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, p7File)) return 0;
	
	return SGJ_call("getSignerCountFile",p7File);
}
