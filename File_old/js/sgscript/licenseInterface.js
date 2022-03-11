
var _decoder;
var SGXML;

var param1;
var param2;
var param3;

function checkScript()
{
	var agent = navigator.userAgent;
	//log.debug("UserAgent: " + agent);
	if(agent.indexOf("Macintosh") != -1 && agent.indexOf("Chrome"))
		return false;
	if(agent.indexOf("Macintosh") != -1 && agent.indexOf("Safari"))
		return false;
	return true;
}

function setKey(random, object_id) 
{
	object_id = 'TZAPP';
	var useScript = checkScript();
	
	try 
	{
		if(!useScript)
			SGXML = document.getElementById(object_id);
	} catch (e) {alert("Exception getting applet object:\n" + e);}
	
    //SGXML = s3TWL(object_id); 
    //var SGXML = document.getElementById(object_id);
    _decoder = new ReplacementFor_kica.ReplacementFor_license.ReplacementFor_licenseDecoder(random);

    try     {
        _decoder.ReplacementFor_init();
    }  catch(e)    {  alert(e);  }
	
    try 
    {
        //SGXML.setR(_decoder.J2lhn(), _decoder.eSWFD, _decoder.k5mAn());
        param1 = _decoder.ReplacementFor_getSHA_D();
        param2 = _decoder.ReplacementFor_licensecode;
        param3 = _decoder.ReplacementFor_getScrRkey();
    } 
    catch(e)   {  alert(e);  }
    
    try 
    {
        if(!useScript)
    		SGXML.setR(param1, param2, param3);
    } catch(e) { alert("Exception executing applet method setR()\n" + e); }
}

function setRandom(R) 
{
    _decoder.ReplacementFor_setAppDecode(R);
}

function getMac(value) 
{
    return _decoder.ReplacementFor_getMac(value);
}
