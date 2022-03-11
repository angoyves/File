/*
 * 노드 , 트리 구성 정보 선언
 */
var treeNodes			= new Array();
var openTreeNodes	    = new Array();
var checkedNodes        = new Array();
var unCheckedNodes        = new Array();
var treeIcons			= new Array(6);
var imgpath         = contextPath + "images/menu/";
var treeYeobu       = false;
var lastLevel       = 4;

/*
 * 노드 , 트리 구성 이미지 정보
 */
function preloadIcons() {
	treeIcons[0] = new Image();
	treeIcons[0].src = imgpath+"menu_plus.gif";
	treeIcons[1] = new Image();
	treeIcons[1].src = imgpath+"menu_plusbottom.gif";
	treeIcons[2] = new Image();
	treeIcons[2].src = imgpath+"menu_minus.gif";
	treeIcons[3] = new Image();
	treeIcons[3].src = imgpath+"menu_minusbottom.gif";
	treeIcons[4] = new Image();
	treeIcons[4].src = imgpath+"menu_folder.gif";
	treeIcons[5] = new Image();
	treeIcons[5].src = imgpath+"menu_folderopen.gif";
}
/*
* 트리생성함수
*/
function createTree(arrName ) {
   var startNode, openNode;
	treeNodes = arrName;
	if (treeNodes.length > 0) {
		preloadIcons();
		if (startNode == null) startNode = 0;
		if (openNode != 0 || openNode != null) setOpenTreeNodes(openNode);
		if (startNode !=0) {
			var startNodeId = getTreeArrayId(startNode);
			if ( startNodeId == null ) {
				startNodeId = 0;
			}
			var nodeValues = treeNodes[startNodeId].split("|");
		} else document.write("<input type='checkbox' name='checkAll' class='check2' value=\"0\" onclick='javascript:fCheckAll();'>root<br>");
		var recursedNodes = new Array();
		//addAllTreeNode();
		addTreeNode(startNode, recursedNodes);
		initOpenNodes(openTreeNodes);
	}
}
/*
* 노드위치 확인
*/
function getTreeArrayId(node) {
	for ( var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[0]==node) return i;
	}
	return null;
}
/*
* 트리 노드 열기
*/
function setOpenTreeNodes(openNode) {
	for ( var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[0]==openNode) {
			openTreeNodes.push(nodeValues[0]);
			setOpenTreeNodes(nodeValues[1]);
		}
	}
}

/*
* 트리노드 오픈 여부 확인
*/
function isTreeNodeOpen(node) {
   if (treeYeobu){ return true; }
   for ( var i=0; i<openTreeNodes.length; i++){
	   if (openTreeNodes[i]==node){ return true; }
   }
   return false;
}

function initOpenNodes(nodes) {

	for (var i = 0; i < nodes.length; i++) {

		if ( nodes[i] != null ) {
			var nodeValues = treeNodes[getTreeArrayId(nodes[i])].split("|");

			var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
			var hasChild = ( nodeValues[12] == 1 ) ? true : false;

			var nodeDiv = document.getElementById("div" + nodeValues[0]);

			if ( hasChild ) {
				if ( lastSibling ) {
					openCloseEx(nodeValues[0], 1);
				} else {
					openCloseEx(nodeValues[0], 0);
				}
			}

		}
	}
}

/*
* 모든 트리 펼치기
*/
function openAll(){

	for (var i = 0; i < treeNodes.length; i++) {

		var nodeValues = treeNodes[i].split("|");
		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChild = ( nodeValues[12] == 1 ) ? true : false;

		if ( hasChild ) {
			if ( lastSibling ) {
				openCloseEx(nodeValues[0], 1);
			} else {
				openCloseEx(nodeValues[0], 0);
			}
		}


	}

}


/*
* 모든 트리 닫기
*/
function closeAll(node, bottom){

	for (var i = 0; i < treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		var treeDiv = document.getElementById("div" + nodeValues[0]);

		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);

		var hasChild = nodeValues[12];

		// 하위노드는 열수가 없으니 제외
		if(hasChild != 0){

			if (treeDiv.style.display != 'none') {

				// 열 때
				if (lastSibling) {
					openCloseEx ( nodeValues[0], 1 );
				} else {
					openCloseEx ( nodeValues[0], 0 );
				}

			}
		}
	}
}

/*
* 하위 트리노드 존재여부 확인
*/
function hasChildTreeNode(hasChild) {
	if (hasChild == "1") {
		return true;
	} else {
		return false;
	}
}
/*
* 트리노드 최하위 여부 확인
*/
function lastTreeSibling (node, parentNode) {
	var lastChild = 0;
	for ( var i=0; i< treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[1] == parentNode) lastChild = nodeValues[0];
	}
	if (lastChild==node) return true;
	return false;
}

function selectNode(Node){

	var nodeValues = Node.split("|");
	parent.document.getElementById("menuId_show").innerHTML = nodeValues[0];


	var menuNm = nodeValues[2];
	var menuNmEn = nodeValues[3];

	while(menuNm.indexOf("[space]") > -1){
		menuNm = menuNm.replace("[space]", " ");
	}

	while(menuNmEn.indexOf("[space]") > -1){
		menuNmEn = menuNmEn.replace("[space]", " ");
	}

	var menuNmKo = nodeValues[11];

	parent.document.getElementById("menuNm").innerHTML = menuNm;

	if(nodeValues[4] == 'F'){
		parent.document.frm_auth_list.menuType[0].checked = true;
	}else if(nodeValues[4] == 'P'){
		parent.document.frm_auth_list.menuType[1].checked = true;
	}

	if(nodeValues[5] == 'Y'){
		parent.document.frm_auth_list.caYn.checked = true;
	}else{
		parent.document.frm_auth_list.caYn.checked = false;
	}
	parent.document.getElementById("rscUrl").innerHTML = nodeValues[6];

	if(nodeValues[7] == 'Y'){
		parent.document.frm_auth_list.useYn.checked = true;
	}else{
		parent.document.frm_auth_list.useYn.checked = false;
	}
	if(nodeValues[8] == 'Y'){
		parent.document.frm_auth_list.menuDefault.checked = true;
	}else{
		parent.document.frm_auth_list.menuDefault.checked = false;
	}
}

/*
* 신규 트리노드 추가 (전체 메뉴를 한번에 모두 불러오는 방식)
*/
function addAllTreeNode() {

	for (var i = 0; i < treeNodes.length; i++) {

		var nodeValues = treeNodes[i].split("|");

		var parentDiv;
		if ( nodeValues[10] == 1 ) {
			parentDiv = document.getElementById("menuTree");
		} else {
			parentDiv = document.getElementById("div" + nodeValues[1]);
		}

		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChildNode	= hasChildTreeNode(nodeValues[12]);
		var isNodeOpen = isTreeNodeOpen(nodeValues[0]);

		// checkbox 처리 부분
		var childDivHtml = "";
		for(var j = 0; j < nodeValues[10]; j++){
			childDivHtml += "&nbsp;&nbsp;&nbsp;";
		}

		childDivHtml += "<input type='checkbox' id='check"+nodeValues[0]+"' name='checkField' class='check2' ";

		if ( fn_isCheckedMenu(nodeValues[1]) ) {
			childDivHtml += " checked ";
			fn_insertCheckedMenu(nodeValues[0]);
		} else if ( fn_isUnCheckedMenu(nodeValues[1]) ) {
			fn_insertUnCheckedMenu(nodeValues[0]);
		} else {
			if(nodeValues[9] == 1){ childDivHtml += " checked "; }
		}

		childDivHtml += "onclick='javascript:fCheckDir(this.name, this.value,"+i+");' value=" + nodeValues[0] + ">";

		if (hasChildNode) {
			if (lastSibling) {
				childDivHtml += "<a href='javascript:openCloseEx(\"" + nodeValues[0] + "\", 1);'><img id='join" + nodeValues[0] + "' src='"+imgpath;
				if (isNodeOpen) childDivHtml += "menu_minus";
				else childDivHtml += "menu_plus";
				childDivHtml += "bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>";
			} else {
				childDivHtml += "<a href='javascript: openCloseEx(\"" + nodeValues[0] + "\", 0);'><img id='join" + nodeValues[0] + "' src='"+imgpath;
				if (isNodeOpen) childDivHtml += "menu_minus";
				else childDivHtml += "menu_plus";
				childDivHtml += ".gif' border='0' align='absbottom' alt='Open/Close node' /></a>";
			}
		} else {
			if (lastSibling) childDivHtml += "<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >";
			else childDivHtml += "<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >";
		}

		if (hasChildNode) {
			childDivHtml += "<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_folder";
			if (isNodeOpen) childDivHtml += "open";
			childDivHtml += ".gif' border='0' alt='Folder' >";
		} else childDivHtml += "<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_page.gif' border='0' align='absbottom' alt='Page'>";

		var paramStr = treeNodes[i];
		for(var k = 0 ; k < paramStr.length;k++){
			if(paramStr.substring(k, k+1) == " "){
				paramStr = paramStr.substring(0, k) + "[space]" + paramStr.substring(k + 1);
			}
		}

		childDivHtml += "<a href=javascript:selectNode('" + paramStr + "');>";

		if (nodeValues[2].length > 12) {
			childDivHtml += nodeValues[2].substring(0,12) + "...";
		} else {
			childDivHtml += nodeValues[2];
		}
		childDivHtml += "</a><br>";

		if (hasChildNode) {
			childDivHtml += "<div id='div" + nodeValues[0] + "'";
			if (!isNodeOpen) childDivHtml += " style='display: none;'";
			childDivHtml += ">";

			childDivHtml += "</div>";
		}

		parentDiv.innerHTML = parentDiv.innerHTML + childDivHtml;

	}
}

/*
* 신규 트리노드 추가
*/
function addTreeNode(parentNode, recursedNodes) {

	for (var i = 0; i < treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");

		if (nodeValues[1] == parentNode) {

			var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
			var hasChildNode	= hasChildTreeNode(nodeValues[12]);
			var isNodeOpen = isTreeNodeOpen(nodeValues[0]);
			for (g=0; g<recursedNodes.length; g++) {
				document.write("&nbsp;&nbsp;&nbsp;");
			}

			if (lastSibling) recursedNodes.push(0);
			else recursedNodes.push(1);

			// checkbox 처리 부분
			document.write("&nbsp;&nbsp;&nbsp;");
			document.write("<input type='checkbox' id='check"+nodeValues[0]+"' name='checkField' class='check2' ");
			if(nodeValues[9] == 1){ document.write(" checked "); }
			document.write("onclick='javascript:fCheckDir(this.name, this.value,"+i+");' value=" + nodeValues[0] + ">");

			if (hasChildNode) {
				if (lastSibling) {
					document.write("<a href='javascript:openCloseEx(\"" + nodeValues[0] + "\", 1);'><img id='join" + nodeValues[0] + "' src='"+imgpath);
					 	if (isNodeOpen) document.write("menu_minus");
						else document.write("menu_plus");
					document.write("bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>");
				} else {
					document.write("<a href='javascript: openCloseEx(\"" + nodeValues[0] + "\", 0);'><img id='join" + nodeValues[0] + "' src='"+imgpath);
						if (isNodeOpen) document.write("menu_minus");
						else document.write("menu_plus");
					document.write(".gif' border='0' align='absbottom' alt='Open/Close node' /></a>");
				}
			} else {
				if (lastSibling) document.write("<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >");
				else document.write("<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >");
			}

			if (hasChildNode) {
				document.write("<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_folder");
					if (isNodeOpen) document.write("open");
				document.write(".gif' border='0' alt='Folder' >");
			} else document.write("<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_page.gif' border='0' align='absbottom' alt='Page'>");

			var paramStr = treeNodes[i];
			for(var j = 0 ; j < paramStr.length;j++){
				if(paramStr.substring(j, j+1) == " "){
					paramStr = paramStr.substring(0, j) + "[space]" + paramStr.substring(j + 1);
				}
			}

			document.write("<a href=javascript:selectNode('" + paramStr + "');>");
			if (nodeValues[2].length > 20) {
				document.write(nodeValues[2].substring(0,19) + "...");
			} else {
				document.write(nodeValues[2]);
			}
			document.write("</a><br>");

			if (hasChildNode) {
				document.write("<div id='div" + nodeValues[0] + "'");
					if (!isNodeOpen) document.write(" style='display: none;'");
				document.write(">");
				addTreeNode(nodeValues[0], recursedNodes);
				document.write("</div>");
			}
			recursedNodes.pop();
		}
	}
}

/*
* 신규 트리노드 추가
*/
function addSubTreeNode(parentNode) {

	var nodeValues = parentNode.split("|");
	var parentDiv = document.getElementById("div" + nodeValues[1]);

	var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
	var hasChildNode	= hasChildTreeNode(nodeValues[12]);
	var isNodeOpen = isTreeNodeOpen(nodeValues[0]);

	// checkbox 처리 부분
	var childDivHtml = "";
	for(var i = 0; i < nodeValues[10]; i++){
		childDivHtml += "&nbsp;&nbsp;&nbsp;";
	}

	childDivHtml += "<input type='checkbox' id='check"+nodeValues[0]+"' name='checkField' class='check2' ";

	if ( fn_isCheckedMenu(nodeValues[1]) ) {
		childDivHtml += " checked ";
		fn_insertCheckedMenu(nodeValues[0]);
	} else if ( fn_isUnCheckedMenu(nodeValues[1]) ) {
		fn_insertUnCheckedMenu(nodeValues[0]);
	} else {
		if(nodeValues[9] == 1){ childDivHtml += " checked "; }
	}

	childDivHtml += "onclick='javascript:fCheckDir(this.name, this.value,"+i+");' value=" + nodeValues[0] + ">";

	if (hasChildNode) {
		if (lastSibling) {
			childDivHtml += "<a href='javascript:openCloseEx(\"" + nodeValues[0] + "\", 1);'><img id='join" + nodeValues[0] + "' src='"+imgpath;
			if (isNodeOpen) childDivHtml += "menu_minus";
			else childDivHtml += "menu_plus";
			childDivHtml += "bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>";
		} else {
			childDivHtml += "<a href='javascript: openCloseEx(\"" + nodeValues[0] + "\", 0);'><img id='join" + nodeValues[0] + "' src='"+imgpath;
			if (isNodeOpen) childDivHtml += "menu_minus";
			else childDivHtml += "menu_plus";
			childDivHtml += ".gif' border='0' align='absbottom' alt='Open/Close node' /></a>";
		}
	} else {
		if (lastSibling) childDivHtml += "<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >";
		else childDivHtml += "<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >";
	}

	if (hasChildNode) {
		childDivHtml += "<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_folder";
		if (isNodeOpen) childDivHtml += "open";
		childDivHtml += ".gif' border='0' alt='Folder' >";
	} else childDivHtml += "<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_page.gif' border='0' align='absbottom' alt='Page'>";

	var paramStr = parentNode;
	for(var j = 0 ; j < paramStr.length;j++){
		if(paramStr.substring(j, j+1) == " "){
			paramStr = paramStr.substring(0, j) + "[space]" + paramStr.substring(j + 1);
		}
	}

	childDivHtml += "<a href=javascript:selectNode('" + paramStr + "');>";

	if (nodeValues[2].length > 12) {
		childDivHtml += nodeValues[2].substring(0,12) + "...";
	} else {
		childDivHtml += nodeValues[2];
	}
	childDivHtml += "</a><br>";

	if (hasChildNode) {
		childDivHtml += "<div id='div" + nodeValues[0] + "'";
		if (!isNodeOpen) childDivHtml += " style='display: none;'";
		childDivHtml += ">";

		childDivHtml += "</div>";
	}

	parentDiv.innerHTML = parentDiv.innerHTML + childDivHtml;

}

/*
* 트리노드 액션(열기,닫기)
*/
function openCloseEx(node, bottom) {

	var treeDiv = document.getElementById("div" + node);
	var treeJoin = document.getElementById("join" + node);
	var treeIcon = document.getElementById("icon" + node);

	var childs = treeDiv.childNodes;

	if (childs.length != 0 ) {

		if (treeDiv.style.display == 'none') {

			if (bottom==1) {
				treeJoin.src = treeIcons[3].src;
			} else {
				treeJoin.src = treeIcons[2].src;
			}
			treeIcon.src = treeIcons[5].src;
			treeDiv.style.display = "";

		} else {

			if (bottom==1) {
				treeJoin.src = treeIcons[1].src;
			} else {
				treeJoin.src = treeIcons[0].src;
			}
			treeIcon.src = treeIcons[4].src;
			treeDiv.style.display = "none";

		}

	} else {

		if (bottom==1) {
			treeJoin.src = treeIcons[3].src;
		} else {
			treeJoin.src = treeIcons[2].src;
		}
		treeIcon.src = treeIcons[5].src;

		var url = contextPath + "pt/menu/selectListAuthMenu.do?upperMenuId=" + node
			+ "&roleId=" + document.getElementById("roleId").value
			+ "&cmd=Search";
		AutoComplete.ContentLoader(url, addChild);
	}
}

function addChild(){

	if(AutoComplete.getState()){ // 데이터의 전부를 받은 상태

        var objs = xmlHttp.responseText.parseJSON();
        var results = objs.results;

        for(var i = 0; i < results.length; i++){

        	var node = results[i].str;
        	treeNodes[treeNodes.length] = node;
        	addSubTreeNode(node);
        }

        var nodeValues = node.split("|");
        var parentDiv = document.getElementById("div" + nodeValues[1]);
        parentDiv.style.display = "";

    }
}


if(!Array.prototype.push) {
	function fnArrayPush() {
		for(var i=0;i<arguments.length;i++)
			this[this.length]=arguments[i];
		return this.length;
	}
	Array.prototype.push = fnArrayPush;
}
if(!Array.prototype.pop) {
	function fnArrayPop(){
		lastElement = this[this.length-1];
		this.length = Math.max(this.length-1,0);
		return lastElement;
	}
	Array.prototype.pop = fnArrayPop;
}

/* ********************************************************
 * 모두선택 처리 함수
 ******************************************************** */
function fCheckAll() {
	if(document.frm_menu_list_frame.checkAll.checked) {
		for ( var i=0; i<treeNodes.length; i++) {
			var nodeValues = treeNodes[i].split("|");
			var nodeCheckBox = document.getElementById("check"+nodeValues[0]);

			fn_checkMenu(nodeValues[0], 2);
		}
	} else {
		for ( var i=0; i<treeNodes.length; i++) {
			var nodeValues = treeNodes[i].split("|");
			var nodeCheckBox = document.getElementById("check"+nodeValues[0]);

			if (nodeCheckBox.checked == true) {
				fn_unCheckMenu(nodeValues[0]);
			}
		}
	}

}


/* ********************************************************
 * 모두선택 처리 함수
 ******************************************************** */
function fCheckDir(fcheckYB, fValue, fPath) {

	var myCheck = document.getElementById("check"+fValue);

	if ( myCheck.checked ) {
		fn_checkMenu(fValue, 2);
	} else {
		fn_unCheckMenu(fValue);
	}

}

/* ********************************************************
 * 메뉴 체크선택
 * dir => 재귀호출 방향 (0 = 상위항목, 1 = 하위항목, 2 = 양방향)
 ******************************************************** */
function fn_checkMenu(menuId, dir) {

	checkMenu = document.getElementById("check"+menuId);
	checkMenu.checked = true;

	fn_deleteUnCheckedMenu(menuId);
	fn_insertCheckedMenu(menuId);

	for ( var i=0; i<treeNodes.length; i++) {
		var childNode = treeNodes[i].split("|");

		// 상위 메뉴에 대해서 체크
		if ( (childNode[1] != "") && ( childNode[0] == menuId ) && ( dir == 0 || dir == 2 )) {
			fn_checkMenu(childNode[1], 0);
		}

		// 하위 메뉴에 대해서 체크
		if ( ( childNode[1] == menuId ) && ( dir == 1 || dir == 2 ) ) {
			fn_checkMenu(childNode[0], 1);
		}
	}
}



/* ********************************************************
 * 메뉴 체크해제
 ******************************************************** */
function fn_unCheckMenu(menuId) {

	checkMenu = document.getElementById("check"+menuId);
	checkMenu.checked = false;

	fn_deleteCheckedMenu(menuId);
	fn_insertUnCheckedMenu(menuId);

	//하위 메뉴에 대해서 체크 해제
	for ( var i=0; i<treeNodes.length; i++) {
		var childNode = treeNodes[i].split("|");
		if ( childNode[1] == menuId ) {
			fn_unCheckMenu(childNode[0]);
		}

	}

	//상위 메뉴에 대해서 체크 해제
	fn_unCheckSelfMenu (menuId);
}


/* ********************************************************
 * 메뉴가 권한해제 리스트에 있는지 확인
 ******************************************************** */
function fn_isUnCheckedMenu(checkMenuId) {

	for ( var i = 0; i < unCheckedNodes.length ; i++) {
		if ( unCheckedNodes[i] == checkMenuId ) {
			return true;
		}
	}
	return false;
}

/* ********************************************************
 * 메뉴가 권한등록 리스트에 있는지 확인
 ******************************************************** */
function fn_isCheckedMenu(checkMenuId) {

	for ( var i = 0; i < checkedNodes.length ; i++) {
		if ( checkedNodes[i] == checkMenuId ) {
			return true;
		}
	}
	return false;
}

/* ********************************************************
 * 메뉴를 권한등록 리스트에 등록
 ******************************************************** */
function fn_insertCheckedMenu(menuId) {
	var lengthOfChecked = checkedNodes.length;
	for ( var i = 0; i < lengthOfChecked ; i++) {
		if ( checkedNodes[i] == menuId ) {
			return;
		}
	}
	checkedNodes[lengthOfChecked] = menuId;
}


/* ********************************************************
 * 메뉴를 권한해제 리스트에 등록
 ******************************************************** */
function fn_insertUnCheckedMenu(menuId) {
	var lengthOfUnChecked = unCheckedNodes.length;
	for ( var i = 0; i < lengthOfUnChecked ; i++) {
		if ( unCheckedNodes[i] == menuId ) {
			return;
		}
	}
	unCheckedNodes[lengthOfUnChecked] = menuId;
}

/* ********************************************************
 * 메뉴를 권한등록 리스트에서 제거
 ******************************************************** */
function fn_deleteCheckedMenu(menuId) {

	var lengthOfChecked = checkedNodes.length;
	if ( lengthOfChecked > 0) {
		var indexOfChecked = lengthOfChecked;

		for ( var i = 0; i < lengthOfChecked; i++) {
			if (checkedNodes[i] == menuId) {
				indexOfChecked = i;
			}
		}

		// 권한등록 리스트에 menuId가 있는 경우
		if ( indexOfChecked != lengthOfChecked ) {
			for ( var i = indexOfChecked; i < lengthOfChecked - 1; i++ ) {
				checkedNodes[i] = checkedNodes[i+1];
			}
			checkedNodes.length--;
		}
	}
}


/* ********************************************************
 * 메뉴를 권한제거 리스트에서 제거
 ******************************************************** */
function fn_deleteUnCheckedMenu(menuId) {

	var lengthOfUnChecked = unCheckedNodes.length;
	if ( lengthOfUnChecked > 0) {
		var indexOfUnChecked = lengthOfUnChecked;

		for ( var i = 0; i < lengthOfUnChecked; i++) {
			if (unCheckedNodes[i] == menuId) {
				indexOfUnChecked = i;
			}
		}

		// 권한제거 리스트에 menuId가 있는 경우
		if ( indexOfUnChecked != lengthOfUnChecked ) {
			for ( var i = indexOfUnChecked; i < lengthOfUnChecked - 1; i++ ) {
				unCheckedNodes[i] = unCheckedNodes[i+1];
			}
			unCheckedNodes.length--;
		}
	}
}


/* ********************************************************
 * 자신의 상위 메뉴의 treeNodes Id를 구한다.
 ******************************************************** */
function getUpperMenuId(menuId) {
	var myTreeArrayId = getTreeArrayId(menuId);
	if ( myTreeArrayId == null ) {
		return null;
	}

	var myNodeValues = treeNodes[myTreeArrayId].split("|");
	return myNodeValues[1];
}

/* ********************************************************
 * 자신의 하위 한 단계 메뉴의 treeNodes Id Array를 구한다.
 ******************************************************** */
function getSubMenuIdArray (menuId) {
	var subMenu = new Array();

	for (var i=0; i<treeNodes.length; i++ ) {
		var nodeValues = treeNodes[i].split("|");

		if ( nodeValues[1] == menuId ) {
			subMenu[subMenu.length] = i;
		}

	}

	return subMenu;

}

/* ********************************************************
 * 하위 메뉴가 모두 체크해제된 경우 자신도 체크 해제
 * 상위 메뉴에 대해서도 재귀적으로 수행
 ******************************************************** */
function fn_unCheckSelfMenu (menuId) {

	var subMenuIdArray = getSubMenuIdArray(menuId);
	var upperMenuId = getUpperMenuId(menuId);

	if ( upperMenuId != null ) {
		for ( var i=0; i<subMenuIdArray.length; i++ ) {
			var subMenuNodeValues = treeNodes[subMenuIdArray[i]].split("|");
			var subMenuCheckBox = document.getElementById("check"+subMenuNodeValues[0]);

			if ( subMenuCheckBox.checked == true) {
				return;
			}
		}

		var myMenuCheckBox = document.getElementById("check"+menuId);
		myMenuCheckBox.checked = false;

		fn_deleteCheckedMenu(menuId);
		fn_insertUnCheckedMenu(menuId);

		fn_unCheckSelfMenu(upperMenuId);
	}
}

/* ********************************************************
 * 새로고침
 ******************************************************** */
function auth_refresh(){

	var openArray = "";

	for ( var i=0; i<treeNodes.length; i++){
		var nodeValues = treeNodes[i].split("|");

		var treeDiv = childFrame.contentDocument.getElementById("div" + nodeValues[0]);
		var menuLvl = nodeValues[10];

		if(menuLvl == '1' || menuLvl == '2' || menuLvl == '3'){

				if(treeDiv.style.display == ''){
					if ( openArray != "" ) {
						openArray += ':';
					}
					openArray += nodeValues[0];
				}
			}
	}

	var form = document.frm_auth_list;
	
	form.openNodes.value = openArray;
	form.target = "PtMenuFrame";
	form.isRequestFromMenuList.value = "Y";

	form.submit();

}