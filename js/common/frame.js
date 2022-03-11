/**
 * 프레임 사이즈 변경(고정)
 * 
 * @param 프레임 이름
 * @return void
 */
function util_resizeFrame(frameName){
	
	var parentFrame = parent.document.getElementsByName(frameName)[0]; // le frame parent
	var frameDiv = document.getElementById("frameDiv");
	
	parentFrame.height = frameDiv.scrollHeight;
	
}

/**
 * 프레임 사이즈 변경(가변)
 * 
 * @param 프레임 이름
 * @return void
 */
function util_resizeFrameBySize(frameName, addSize){
	
	var parentFrame = parent.document.getElementsByName(frameName)[0];
	var frameDiv = document.getElementById("frameDiv");
	
	parentFrame.height = frameDiv.scrollHeight + addSize;
	
}

