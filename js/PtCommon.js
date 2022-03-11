// Trim whitespace from left and right sides of s.



/* ********************************************************
 * 이미지 확장자 체크 (jpg, gif, png)
 ******************************************************** */
function fn_checkFileExt(imageObj) {

    var fileName = imageObj.value;
		var indexOfDot = fileName.lastIndexOf(".");
		var fileExt = fileName.substring(indexOfDot + 1, fileName.length).toLowerCase();
		if ( fileName != "" && fileExt != "jpg" && fileExt != "gif" && fileExt != "png") {
			return false;
		}

 	return true;
}
 
 /* ********************************************************
 * 카테고리 색처리
 ******************************************************** */
function fn_paintCategory(clCd){
	
	var aObj = document.getElementsByName("categoryObj");
	
	for(var i = 0; i < aObj.length; i++){
		if(clCd == aObj[i].getAttribute("id")){
			 aObj[i].style.color = "#c80000";
		}else{
			 aObj[i].style.color = "";
		}
		
	}
	
	if(clCd == null || clCd == ""){
		aObj[0].style.color = "#c80000";
	}
	
}