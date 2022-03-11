var SG;
var frameName = "TOP";
var sgObj;

if(window.opener == null)
{
	sgObj = [
		this,
		parent.frames[frameName],
		parent.parent.frames[frameName],
		parent.parent.parent.frames[frameName],
		parent.parent.parent.parent.frames[frameName]
	];
}
else
{
	sgObj = [
		this,
		parent.frames[frameName],
		parent.parent.frames[frameName],
		parent.parent.parent.frames[frameName],
		parent.parent.parent.parent.frames[frameName],
		//팝업에서 띄우는 경우, 프레임이 없다면 그냥 opener 를 넣음
		//ex) var SG = opener;
		opener.frames[frameName],
		opener.parent.frames[frameName],
		opener.parent.parent.frames[frameName],
		opener.parent.parent.parent.frames[frameName]
	];
}

function searchSGObject()
{
	for(var i=0;i<sgObj.length;i++)
	{
		if(sgObj[i] == "" || typeof sgObj[i] == 'undefined' || sgObj[i] == null)
			continue;
		else
		{
			//SG객체를 구했다면 메소드를 하나 호출해본다.
			try { sgObj[i].SGJ_getErrorMsg(); }
			catch (ex) { continue; }
			//바이오 토큰 목록 세팅
			sgObj[i].SGJ_setBioHsmList(sgObj[i].bioList);
			SG = sgObj[i];
			//sgObj = null;
			break;
		}
	}
}

searchSGObject();
