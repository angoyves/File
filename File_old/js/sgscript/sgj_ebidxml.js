/**
 * @fileoverview 전자조달 전용 함수 스크립트
 *
 * @author hychul
 * @version 0.1
 */
var xmlconfig = 
[
	"Encoding=UTF-8",
	"Signature=http://www.w3.org/2001/04/xmldsig-more#rsa-sha256",
	"Digest=http://www.w3.org/2001/04/xmlenc#sha256",
	"BlockCipher=http://www.w3.org/2001/04/xmlenc#SEED",
	"KeyEncipher=http://www.w3.org/2001/04/xmlenc#rsa-1_5",
	"Canonical=http://www.w3.org/TR/2001/REC-xml-c14n-20010315",
	"Enctype=http://www.w3.org/2001/04/xmlenc#Element",
	"Transform=http://www.w3.org/TR/1999/REC-xpath-19991116",
	"UseChain=false"
].join("\n");


/**
* 개찰을 위한 주어진 인증서로 암호화된 공고건 개인키 정보 반환
* @param {String}strUserId 세션아이디
* @param {String}strKmCert 암호화 인증서
* @return {String} 암호화된 공고건 개인키 정보
*/
function SGJ_initXmlProps( strConfig )
{
	var funcName = SGJ_getFunctionName(arguments.callee.toString());
	if(!SGJ_checkParams(funcName, strConfig)) return '';

	return SGJ_call("initXmlProps", strConfig );
}