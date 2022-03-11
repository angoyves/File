function Jar(name, version)
{
	this.name = name;
	this.version = version;
}

var installFunction = 
{
	getList : function(array)
	{
		var list = { jarlist: '',verlist: ''};
		for(var index in array)
		{
			list.jarlist = list.jarlist + array[index].name + ',';
			list.verlist = list.verlist + array[index].version + ',';
		}
		list.jarlist = list.jarlist.substr(0, list.jarlist.length -1);
		list.verlist = list.verlist.substr(0, list.verlist.length -1);
		return list;
	},
	
	setKeyProtect : function (keyProtect)
	{
		if(keyProtect == 'INCA' || keyProtect == 'INCA_KEYPAD')
		{
			//infovine 요청으로 둘 다 내림
			libs.push(new Jar('inca.jar', '2.0.0.0'));
			libs.push(new Jar('inca_keypad.jar', '2.0.0.0'));
		}
		else if(keyProtect == 'AHN')
		{
			libs.push(new Jar('aos.jar', '2.0.0.0'));
			libs.push(new Jar('jna.jar', '2.0.0.0'));
			libs.push(new Jar('jna-3.2.1.jar', '2.0.0.0'));
		}
		/*
		else if(keyProtect == 'INCA_KEYPAD')
			libs.push(new Jar('inca_keypad.jar', '2.0.0.0'));
		*/
		return keyProtect;
	}
};

function getDocumentCharset()
{
	return document.characterSet ? document.characterSet : document.charset;
}

/*
var libs = 
[
	new Jar('signgateCrypto.jar', 		'2.0.0.0'),
	new Jar('launcher.jar', 			'2.0.0.0'),
	new Jar('ewscommon.jar', 			'2.0.0.0'),
	new Jar('sgapplet.jar', 			'2.0.0.0'),
	new Jar('images.jar', 				'2.0.0.0'),
];
*/
var libs = 
[
	new Jar('ebidclient.jar', 		'1.0.0.0')
];

var dlls = 
[
	"BHSM_JNI2.dll-2.0.0.1",
	"KICAUAC.dll-1.0.0.3",
	"KicaUACJni.dll-1.0.0.2",
	"gpkiapi2.dll-1.5.1.0",
	"gpkiapi.dll-1.2.0.0",
	"nsldap32v11.dll-4224.0.0.8803"
];

var object_id = 'SG_OpenWebKit';
var sessionId = 'localhost';

/*****************************************************/
/*loadKICAApplet(운영모드, 키보드보안모듈이름);					*/
/*키보드 보안 INCA, INCA_KEYPAD, AHN, KINGS						*/
/*ex) loadKICAApplet('KRS', 'INCA'); 								*/
/****************************************************/
//loadKICAApplet('KRS', 'INCA_KEYPAD');
loadKICAApplet('DEFAULT', '');

function loadKICAApplet(mode, keyProtect)
{
	var attributes = {};
	var parameters = {};
	
	//setting attribute
	attributes.codebase = 'http://localhost/Openpki50_Web/applettest/cab/';
	attributes.id = object_id;
	if(navigator.userAgent.indexOf("Linux") != -1)
	{ attributes.width = 280; attributes.height = 250; }
	else { attributes.width = 280; attributes.height = 250; }

	//setting parameters
	parameters.charset = getDocumentCharset();
	parameters.locale = 'ko_KR'; 
	//parameters.locale = 'en_KE';
	parameters.callBack = ''; //콜백 메소드
	parameters.nativeLib = dlls.join(','); //dll 라이브러리
	parameters.keyProtect = installFunction.setKeyProtect(keyProtect); 
	parameters.java_arguments = '-Xmx512m -Djnlp.packEnabled=true';
	parameters.separate_jvm = 'true';
	parameters.MAYSCRIPT = 'true';
	parameters.codebase_lookup = 'false';
	parameters.scriptable = 'true';
	
	//for infovine 요청에 의해서
	parameters.infovineParam = 'CHANNELNAME:PTBANK_BANKTOWN;CERT_COMPANY:SIGNGATE;KEYCRYP_COMPANY:INCA;VIRTUALKEY_COMPANY:INCA;BROWSER_KEYTYPE:IEONLY_KEYCRYP_AND_NONIE_VIRTUALKEY';
	
	switch(mode)
	{
		case 'DEFAULT':
			attributes.code = 'com.kica.ebid.jclient.launcher.LauncherAppletBid';
			break;
		case 'OVERSEA':
			attributes.code = 'com.kica.ebid.jclient.launcher.LauncherAppletBid';
			attributes.archive = 'kica_provider-1.0.jar,launcher.jar,signgateCrypto.jar,libgpkiapi_jni.jar';
			parameters.sgAppletFile = 'sgapplet.jar;ewscommon.jar;images.jar';
			parameters.sgAppletFileVersion = '1.0.50;1.0.51;1.0.43';
			parameters.ProductHome = '/applettest/cab/';
			break; 
		default:
			break;
	}
	
	var list = installFunction.getList(libs);
	parameters.cache_archive = list.jarlist;
	parameters.cache_version = list.verlist;
	//run applet
	deployJava.runApplet(attributes, parameters, '1.6');
}
