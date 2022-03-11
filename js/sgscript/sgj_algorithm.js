/**
 * @fileoverview SG Secukit Clinet 에서 사용할수 있는 알고리즘 목록
 *
 * @author hychul
 * @version 0.1
 * *
* <pre>
* 대칭키 암호화 알고리즘
* DES_CBC_PKCS5 = 'DES/CBC/PKCS5';
* DESede_CBC_PKCS5 = 'DESede/CBC/PKCS5';
* ARIA_CBC_PKCS5 = 'ARIA/CBC/PKCS5';
* SEED_CBC_PKCS5 = 'SEED/CBC/PKCS5';
* RC5_CBC_PKCS5 = 'RC5/CBC/PKCS5';
* RC4_CBC_PKCS5 = 'RC4/CBC/PKCS5';
* 
* 공개키키 암호화 알고리즘
* RSA = 'RSA';
* RSA_OAEPv2_1 = 'RSA-OAEPv2_1';
*
* 해쉬 알고리즘
* SHA1 = 'SHA1';
* SHA256 = 'SHA-256';
* SHA384 = 'SHA-384';
* SHA512 = 'SHA-512';
* MD5 = 'MD5';
* HAS160 = 'HAS-160';
*
* 전자서명 알고리즘
* MD5withRSA = 'MD5withRSA';
* SHA1withRSA = 'SHA1withRSA';
* SHA2withRSA = 'SHA2withRSA';
* HAS160withRSA = 'HAS160withRSA';
* HAS160withKCDSA = 'HAS160withKCDSA';
* SHA1withKCDSA = 'SHA1withKCDSA';
* RSASSAwithSHA1 = 'SHA1withRSASSAv2_1-PSS';
*
* HMAC 알고리즘
* HMACwithSHA1 = 'HMACwithSHA1';
* HMACwithSHA256 = 'HMACwithSHA256';
* HMACwithSHA384 = 'HMACwithSHA384';
* HMACwithSHA512 = 'HMACwithSHA512';
* HMACwithMD5 = 'HMACwithMD5';
* HMACwithHAS160 = 'HMACwithHAS160';
*
* 의사 난수 생성 알고리즘
* var SHA1PRNG = 'SHA1PRNG';
* </pre>
**/

var algorithm = {
	DES_CBC_PKCS5 : 'DES/CBC/PKCS5',
	DESede_CBC_PKCS5 : 'DESede/CBC/PKCS5',
	ARIA_CBC_PKCS5 : 'ARIA/CBC/PKCS5',
	SEED_CBC_PKCS5 : 'SEED/CBC/PKCS5',
	RC5_CBC_PKCS5 : 'RC5/CBC/PKCS5',
	RC4_CBC_PKCS5 : 'RC4/CBC/PKCS5',
	
	RSA : 'RSA',
	RSA_OAEPv2_1 : 'RSA-OAEPv2_1',
	
	SHA1 : 'SHA1',
	SHA256 : 'SHA-256',
	SHA384 : 'SHA-384',
	SHA512 : 'SHA-512',
	MD5 : 'MD5',
	HAS160 : 'HAS-160',
	
	MD5withRSA : 'MD5withRSA',
	SHA1withRSA : 'SHA1withRSA',
	SHA2withRSA : 'SHA2withRSA',
	HAS160withRSA : 'HAS160withRSA',
	HAS160withKCDSA : 'HAS160withKCDSA',
	SHA1withKCDSA : 'SHA1withKCDSA',
	RSASSAwithSHA1 : 'SHA1withRSASSAv2_1-PSS',
	
	HMACwithSHA1 : 'HMACwithSHA1',
	HMACwithSHA256 : 'HMACwithSHA256',
	HMACwithSHA384 : 'HMACwithSHA384',
	HMACwithSHA512 : 'HMACwithSHA512',
	HMACwithMD5 : 'HMACwithMD5',
	HMACwithHAS160 : 'HMACwithHAS160',
	
	SHA1PRNG : 'SHA1PRNG'
};
