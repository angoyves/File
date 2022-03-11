var browser = navigator.appName;
var win = navigator.userAgent;
var TZApplet = '';
var appletDocument = '';

var appletID = '';
var CODEBASE = '';
var ARCHIVE = '';
var CODE = '';

var mimeURL = '';
var bidMimeURL = '';
var templateURL = '';
var xpathURL = '';
var cookDomain = 'http://www.marchespublics.cm';
var cookName = 'cookieLangCode';
//var cookDomain = 'http://www.marchespublics.cm';
//var cookName = 'secu';
var allScript = '';

function fn_embededKicaScript()
{
 var kicaScriptArray = 
 [
	 "licenseInterface.js",
	 "kica_min.js",
	 "licensecode.js",
	 "license.js",
	 "LicenseDecoder.js",
	 "LicenseValidator.js",
	 "sgj_session.js",
	 "sgj_error.js",
	 "sgj_cert.js",
	 "sgj_sign.js",
	 "sgj_dialog.js",
	 "sgj_util.js",
	 "sgj_encrypt.js",
	 "sgj_hash.js",
	 "sgj_pkcs7.js",
	 "sgj_ebidxml.js",
	 "sgj_ebid.js"
 ];
 
    var scriptDir = "http://www.marchespublics.cm:8084/js/sgscript/";
	 
	for(index in kicaScriptArray)
	{
	 allScript = allScript + '<script type=\"text/javascript\" src=\"'+ scriptDir + kicaScriptArray[index] + '\"><\/script>'; 
	}
}
var dlls = 
	[
	 "BHSM_JNI2.dll-2.0.0.1",
	 "KICAUAC.dll-1.0.0.3",
	 "KicaUACJni.dll-1.0.0.2",
	 "gpkiapi2.dll-1.5.1.0",
	 "gpkiapi.dll-1.2.0.0",
	 "nsldap32v11.dll-4224.0.0.8803"
	];
	
function getCookie( name )
{ 
	 var nameOfCookie = name + '='; 
	 var x = 0; 
	 while ( x <= document.cookie.length ) { 
		 var y = (x+nameOfCookie.length); 
		 if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
		 if ( (endOfCookie=document.cookie.indexOf( ';', y )) == -1 ) 
		 endOfCookie = document.cookie.length; 
		 
		 return unescape( document.cookie.substring( y, endOfCookie ) ); 
	 } 
	 x = document.cookie.indexOf( ' ', x ) + 1; 
	 if ( x == 0 ) 
	 break; 
	 } 
	 return ''; 
}
	 
function getKicaLocale()
	 {
	 var lang = getCookie('cookieLangCode');
	 var kicaLang = '';
	 switch (lang)
	 {
		 case 'fr':
			 kicaLang = 'fr_CM';
			 break;
		 case 'en':
			 kicaLang = 'en_US';
			 break;
		 case 'ko_KR':
			 kicaLang = 'ko_KR';
			 break;
		 default:
			 kicaLang = 'ko_KR';
			 break;
	 }
	 return kicaLang;
}
	 
function fn_setInit(type, ID){
//	CODEBASE = exmsUrl + '/applet/';
	CODEBASE =   'http://www.marchespublics.cm:8084/applet/';

	ARCHIVE = 'xmlparserv2.jar,activation.jar,commons-io-1.4.jar,mail.jar,msg.jar,ppsApplet.jar,commons-codec-1.3.jar,commons-httpclient-3.1.jar,commons-logging-1.1.1.jar,ebidclient.jar';
	CODE = "eppd.app.EPPSApp";

	mimeURL = "http://www.marchespublics.cm:8084/servlet/EdEdocsRcvServlet";
	bidMimeURL = "http://www.marchespublics.cm:8081/servlet/soapServlet";
	templateURL = "http://www.marchespublics.cm:8084/servlet/EdEdocsTemplateServlet?DocCode=";
	xpathURL =  "http://www.marchespublics.cm:8084/servlet/EdEdocsXpathServlet?DocCode=";

	// 화면에서 선언해 주는 애플릿 객체 명 지정
	if(ID == null || ID == "") {
		appletID = "TZAPP";
	}else{
		appletID = ID;
	}

	// 애플릿이 설치될 상단의 HTML 프레임 지정
	var frame = type.toLowerCase();
	switch(frame){
	case 'bid':
		appletDocument = parent.BidAppletFrame.document;
		break;
	case 'usemn':
		appletDocument = parent.UsemnAppletFrame.document;
		break;
	case 'static':
		appletDocument = parent.StaticAppletFrame.document;
		break;
	}
}

function fn_getApplet(type, ID){
alert("dd");
	//value Set
	fn_setInit(type, ID);
	fn_embededKicaScript();
	
	if(appletDocument.getElementById(appletID) != null){
		return;
	}
	if( browser == 'Netscape' )
	{
		 if(win.indexOf("Firefox") > -1 )
		 {
			 
			appletDocument.write( allScript);
			appletDocument.write( '<object id="' + appletID + '" type="application/x-java-applet"'
					 + ' WIDTH = "0" HEIGHT = "0"'
					 + ' codebase="' + CODEBASE
					 + ' " pluginspage="http://java.sun.com/javase/downloads"tabindex="-1">' );
			 appletDocument.write( '<PARAM NAME="CODE" VALUE = "' + CODE + '" />' );
			 appletDocument.write( '<PARAM NAME="java_arguments" value=" -Xmx512M "/>' );
			 appletDocument.write( '<PARAM NAME="type" VALUE="application/x-java-applet;version=1.8" />' );
			 appletDocument.write( '<PARAM NAME="codebase_lookup" value="false"/>' );
			 appletDocument.write( '<PARAM NAME="archive" value="' + ARCHIVE + '" />' );
			 appletDocument.write( '<PARAM NAME="separate_jvm" value="true" />' );
			 appletDocument.write( '<PARAM NAME="mimeRcvUrl" value="' + mimeURL + '" />' );
			 appletDocument.write( '<PARAM NAME="bidMimeUrl" value="' + bidMimeURL + '" />' );
			 appletDocument.write( '<PARAM NAME="templateUrl" value="' + templateURL + '" />' );
			 appletDocument.write( '<PARAM NAME="xPathUrl" value="' + xpathURL + '" />' );
			 appletDocument.write( '<PARAM NAME="cookDomain" value="' + cookDomain + '" />' );
			 appletDocument.write( '<PARAM NAME="cookName" value="' + cookName + '" />' );
			 appletDocument.write( '<PARAM NAME="cache_option" value="Plugin" />' );
			 appletDocument.write( '<PARAM NAME="charset" value="UTF-8" />' );
			 appletDocument.write( '<PARAM NAME="locale" value="'+getKicaLocale()+'" />' );
			 appletDocument.write( '<PARAM NAME="nativeLib" value="'+dlls.join(',')+'" />' );
			 appletDocument.write( '<PARAM NAME="MAYSCRIPT" value="true" />' );
			 appletDocument.write( '<PARAM NAME="scriptable" value="true" />' );
			 appletDocument.write( '</object>');
			 
			 
		 }
		 else
		 {
			 TZApplet = '<APPLET id="' + appletID + '"'
					+ '  WIDTH = "0" HEIGHT = "0"'
				    + '  codebase="' + CODEBASE + '"'
					+ '  pluginspage="http://java.sun.com/javase/downloads"'
					+ '  tabindex="-1" code="' + CODE+ '"'
					+ '  archive="' + ARCHIVE + '">'
					+ ' <PARAM NAME="java_arguments" value=" -Xmx512M "/>'
					+ ' <PARAM NAME="type" VALUE="application/x-java-applet;version=1.8" />'
					+ ' <PARAM NAME="codebase_lookup" value="false"/>'
					+ ' <PARAM NAME="separate_jvm" value="true" />'
					+ ' <PARAM NAME="mimeRcvUrl" value="' + mimeURL + '" />'
					+ ' <PARAM NAME="bidMimeUrl" value="' + bidMimeURL + '" />'
					+ ' <PARAM NAME="templateUrl" value="' + templateURL + '" />'
					+ ' <PARAM NAME="xPathUrl" value="' + xpathURL + '" />'
					+ ' <PARAM NAME="cookDomain" value="' + cookDomain + '" />'
					+ ' <PARAM NAME="cookName" value="' + cookName + '" />'
					+ ' <PARAM NAME="cache_option" value="Plugin" />'
					+ ' <PARAM NAME="MAYSCRIPT" value="true" />'
					+ ' <PARAM NAME="charset" value="UTF-8" />' 
					+ ' <PARAM NAME="locale" value="'+getKicaLocale()+'" />' 
					+ ' <PARAM NAME="nativeLib" value="'+dlls.join(',')+'" />'
					
					+ ' <PARAM NAME="scriptable" value="true" />' + ' </APPLET>';

			 appletDocument.write(allScript + TZApplet);
		 }
	}	
	else if( browser == 'Microsoft Internet Explorer' || browser == 'Trident')
	{
		TZApplet = '<APPLET id="' + appletID + '"'
			+ '  WIDTH = "0" HEIGHT = "0"'
		    + '  codebase="' + CODEBASE + '"'
			+ '  pluginspage="http://java.sun.com/javase/downloads"'
			+ '  tabindex="-1">'
			+ ' <PARAM NAME="CODE" VALUE = "' + CODE + '" />'
			+ ' <PARAM NAME="java_arguments" value=" -Xmx512M "/>'
			+ ' <PARAM NAME="type" VALUE="application/x-java-applet;version=1.8" />'
			+ ' <PARAM NAME="codebase_lookup" value="false"/>'
			+ ' <PARAM NAME="archive" value="' + ARCHIVE + '" />'
			+ ' <PARAM NAME="separate_jvm" value="true" />'
			+ ' <PARAM NAME="mimeRcvUrl" value="' + mimeURL + '" />'
			+ ' <PARAM NAME="bidMimeUrl" value="' + bidMimeURL + '" />'
			+ ' <PARAM NAME="templateUrl" value="' + templateURL + '" />'
			+ ' <PARAM NAME="xPathUrl" value="' + xpathURL + '" />'
			+ ' <PARAM NAME="cookDomain" value="' + cookDomain + '" />'
			+ ' <PARAM NAME="cookName" value="' + cookName + '" />'
			+ ' <PARAM NAME="cache_option" value="Plugin" />'
			
			+ ' <PARAM NAME="charset" value="UTF-8" />'
			+ ' <PARAM NAME="locale" value="'+getKicaLocale()+'" />' 
			+ ' <PARAM NAME="nativeLib" value="'+dlls.join(',')+'" />'
			
			+ ' <PARAM NAME="MAYSCRIPT" value="true" />'
			+ ' <PARAM NAME="scriptable" value="true" />' + ' </APPLET>';
		
		appletDocument.write( allScript + TZApplet);

	}else
	{
		TZApplet = '<h1>so Sorry! unsupported browser.</h1>';
		appletDocument.write(TZApplet);
	}
}

