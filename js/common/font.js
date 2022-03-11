/**
 * 글씨 확대
 *
 * @param void
 * @returns void
 */
function util_expandFont(){
	
	var childs = document.childNodes;
	
	for(var i = 0; i < childs.length; i++){
		
		if(childs[i].hasChildNodes()){
			
			
			util_expandFontByRecursive(childs[i]);
			
		}
		
	}
	
	// iframe 있는 경우
	var iframes = document.getElementsByTagName("iframe");
	if(iframes.length > 0){
		
		for(var i = 0; i < iframes.length; i++){
			
			util_expandFontByRecursive(iframes[i].contentDocument);
			
		}
		
	}
	
}

/**
 * 글씨 확대 재귀호출
 *
 * @param void
 * @returns void
 */
function util_expandFontByRecursive(obj){
	
	var childs = obj.childNodes;
	
	for(var i = 0; i < childs.length; i++){
		
		/*if(childs[i].hasAttributes() &&
		   childs[i].getAttribute("sizeVariable") == "Y"){
			
			if(childs[i].style.fontSize == ""){
				childs[i].style.fontSize = "13px";
			}else{
				
				var prevSize = Number(childs[i].style.fontSize.replace("px", ""));
				childs[i].style.fontSize = prevSize + 1 + "px";
				
			}
						
		}*/
		if(childs[i].style != null){
			
			if(childs[i].style.fontSize == ""){
				childs[i].style.fontSize = "13px";
			}else{
				
				var prevSize = Number(childs[i].style.fontSize.replace("px", ""));
				childs[i].style.fontSize = prevSize + 1 + "px";
				
			}
			
		}
		
		if(childs[i].hasChildNodes()){
			
			util_expandFontByRecursive(childs[i]);
			
		}
		
	}
	
}

/**
 * 글씨 축소
 *
 * @param void
 * @returns void
 */
function util_reductFont(){
	
	var childs = document.childNodes;
	
	for(var i = 0; i < childs.length; i++){
		
		if(childs[i].hasChildNodes()){
			
			util_reductFontRecursive(childs[i]);
			
		}
		
	}
	
	// iframe 있는 경우
	var iframes = document.getElementsByTagName("iframe");
	if(iframes.length > 0){
		
		for(var i = 0; i < iframes.length; i++){
			
			util_reductFontRecursive(iframes[i].contentDocument);
			
		}
		
	}
	
}

/**
 * 글씨 축소 재귀호출
 *
 * @param void
 * @returns void
 */
function util_reductFontRecursive(obj){
	
	var childs = obj.childNodes;
	
	for(var i = 0; i < childs.length; i++){
		
		/*if(childs[i].hasAttributes() &&
		   childs[i].getAttribute("sizeVariable") == "Y"){
			
			if(childs[i].style.fontSize == ""){
				childs[i].style.fontSize = "11px";
			}else{
				
				var prevSize = Number(childs[i].style.fontSize.replace("px", ""));
				
				if(prevSize > 10){
					childs[i].style.fontSize = prevSize - 1 + "px";
				}
				
			}
						
		}*/
		
		if(childs[i].style != null){
			
			if(childs[i].style.fontSize == ""){
				childs[i].style.fontSize = "11px";
			}else{
				
				var prevSize = Number(childs[i].style.fontSize.replace("px", ""));
				
				if(prevSize > 10){
					childs[i].style.fontSize = prevSize - 1 + "px";
				}
				
			}
			
		}
		
		
		if(childs[i].hasChildNodes()){
			
			util_reductFontRecursive(childs[i]);
			
		}
		
	}
	
}