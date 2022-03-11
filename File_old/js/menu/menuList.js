/*
 * 노드 , 트리 구성 정보 선언
 */
var treeNodes			= new Array();
var openTreeNodes	    = new Array();
var treeIcons			= new Array(6);
var imgpath         = contextPath + "images/menu/";
var treeYeobu       = false;

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
function createTree(arrName, openNodes, langCode) {
   var startNode , openNode;
	treeNodes = arrName;
	// treeYeobu = vYeobu;
	if (treeNodes.length > 0) {
		preloadIcons();
		if (startNode == null) startNode = 0;
		// if (openNode != 0 || openNode != null) setOpenTreeNodes(openNode);
		setOpenTreeNodesCheck(openNodes);
		/*if (startNode !=0) {
			var nodeValues = treeNodes[getTreeArrayId(startNode)].split("|");
			document.write("<a href='" + nodeValues[3] + "' onmouseover='window.status='" + nodeValues[3] + "';return true;' onmouseout='window.status=' ';return true;'><img src='"+imgpath+"menu_folderopen.gif' border='0' align='absbottom' alt=''>" + nodeValues[2] + "</a><br>");
		} else document.write("<img src='"+imgpath+"menu_base.gif' border='0' align='absbottom' alt='' >root<br>");*/
		document.write("<img src='"+imgpath+"menu_base.gif' border='0' align='absbottom' alt='' >root<br>");
		//addAllTreeNode();
		addFirstTreeNode(langCode);
		initOpenNodes(openTreeNodes);
	}
}

/*
 * 노드값
 */
function getNodeMenuId(nodeValues) { return nodeValues[0]; }
function getNodeUpperMenuId(nodeValues) { return nodeValues[1]; }
function getNodeMenuNmKo(nodeValues) { return nodeValues[2]; }
function getNodeMenuLvl(nodeValues) { return nodeValues[3]; }
function getNodeMenuOrd(nodeValues) { return nodeValues[4]; }
function getNodeMenuType(nodeValues) { return nodeValues[5]; }
function getNodeRscUrl(nodeValues) { return nodeValues[6]; }
function getNodeUseYn(nodeValues) { return nodeValues[7]; }
function getNodeMenuDefault(nodeValues) { return nodeValues[8]; }
function getNodeDispCd(nodeValues) { return nodeValues[9]; }
function getNodeUpperMenuNm(nodeValues) { return nodeValues[10]; }
function getNodeCaYn(nodeValues) { return nodeValues[12]; }
function getNodeMenuClCd(nodeValues) { return nodeValues[13]; }
function getNodeMenuNmEn(nodeValues) { return nodeValues[14]; }
function getNodeHasChild(nodeValues) { return (nodeValues[3] < 3) ? nodeValues[15] : 0; }
function getNodeMenuNm(nodeValues) { return nodeValues[16]; }

/*
* 노드위치 확인
*/
function getTreeArrayId(node) {
	for (var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[0]==node) return i;
	}
	return null;
}
/*
* 트리 노드 열기
*/
function setOpenTreeNodes(openNode) {
	for (var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[0]==openNode) {
			openTreeNodes.push(nodeValues[0]);
			setOpenTreeNodes(nodeValues[1]);
		}
	}
}


/*
* 트리 노드 열기  체크
*/
function setOpenTreeNodesCheck(openNodes) {


	if ( openNodes.length > 0 ) {
		var c_nodeValues = openNodes.split(":");

		for(var j=0;j<c_nodeValues.length;j++){
			openTreeNodes.push(c_nodeValues[j]);
		}
	}
}


/*
* 트리노드 오픈 여부 확인
*/
function isTreeNodeOpen(node) {
   if (treeYeobu){ return true; }
   for (var i=0; i<openTreeNodes.length; i++){
	   if (openTreeNodes[i]==node){ return true; }
   }
   return false;
}



/*
 * 모든 트리 오픈  여부 확인
 */
function isTreeNodeOpenAll() {

	var openArray = "";

	for (var i=0; i<PtMenuFrame.treeNodes.length; i++){
		var nodeValues = PtMenuFrame.treeNodes[i].split("|");

		var treeDiv = PtMenuFrame.document.getElementById("div" + nodeValues[0]);

		if ( treeDiv != null) {
			var menuLvl = nodeValues[3];
			if(menuLvl == '1' || menuLvl == '2'){

				if(treeDiv.style.display == ''){
					if ( openArray != "" ) {
						openArray += ':';
					}
					openArray += nodeValues[0];
				}
			}

		}

	}

	// 맨 마지막에 삽입된 : 제거
	if ( openArray.length > 0 ) {
		openArray.length--;
	}

	return openArray;
}


/*
 * 현재 노드가 가장
 * 마지막 순서인지 확인
 */


function isLastOrderNode(num){


	if(Number(num)+1 == PtMenuFrame.treeNodes.length){

		return true;
	}

	var currentNode = PtMenuFrame.treeNodes[Number(num)].split("|");

	var parentId = currentNode[1];

	// 자신의 부모의 가장 마지막 순서 노드 찾기

	var last = 0;


	// 가장 마지막 order 얻기
	for (var i=0; i<PtMenuFrame.treeNodes.length; i++) {
		var nodeValues = PtMenuFrame.treeNodes[i].split("|");
		if (nodeValues[1]==parentId) {

			if(nodeValues[4] > last){

				last = nodeValues[4];
			}
		}
	}

	if(last == currentNode[4]){

		return true;

	}else{

		return false;

	}

}
/*
* 각 노드의 최하위 메뉴 순서 리턴
* parent = 상위메뉴ID
*/
function getMaxOrderOfNode(parent) {

	var last = new Object();

	// 초기값으로 0 셋팅
	last.order = 0;


	// 가장 마지막 order 얻기
	for (var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[1]==parent) {

			if(Number(nodeValues[4]) > last.order){

				last.order = Number(nodeValues[4]);
				
			}
		}
	}

	// 초기값으로 부모값 셋팅
	last.menuId = parent;

	// 가장 마지막 menuId 얻기
	for (var i=0; i<treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[1]==parent) {

			var trsCur = nodeValues[0].substring(2);
			var trsLast = last.menuId.substring(2);

			if(trsCur > trsLast){

				 last.menuId = nodeValues[0];
			}
		}
	}


	return last;
}

/*
* 하위 트리노드 존재여부 확인
*/
function hasChildTreeNode(parentNode) {
	for (var i=0; i< treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[1] == parentNode) return true;
	}
	return false;
}
/*
* 트리노드 최하위 여부 확인
*/
function lastTreeSibling (node, parentNode) {
	var lastChild = 0;
	for (var i=0; i< treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");
		if (nodeValues[1] == parentNode)
			lastChild = nodeValues[0];
	}
	if (lastChild==node) return true;
	return false;
}

/*
* 신규 트리노드 추가 (전체 메뉴를 한번에 불러오는 방식)
*/
function addAllTreeNode() {

	for (var i = 0; i < treeNodes.length; i++) {
		var nodeValues = treeNodes[i].split("|");

		// 폴더 , 페이지 구분하는 로직 (Level이 1,2 단계는 폴더, 3단계는 Page로 한다.)
		var menuId = nodeValues[0];
		var upperMenuId = nodeValues[1];
		var menuNmKo = nodeValues[2];
		var menuLvl = nodeValues[3];
		var menuNmEn = nodeValues[14];
		var hasChild = getNodeHasChild(nodeValues);
		var menuNm = nodeValues[16];
		var menuNm1 = nodeValues[17];
		var menuNm2 = nodeValues[18];

		var parentDiv;
		if ( menuLvl == '1' ) {
			parentDiv = document.getElementById("menuTree");
		} else {
			parentDiv = document.getElementById("div" + upperMenuId);
		}


		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChildNode = ( getNodeHasChild(nodeValues) == 1 ) ? true : false;
		var isNodeOpen = isTreeNodeOpen(nodeValues[0]);

		var isFolder;
		if (menuLvl == 1 || menuLvl == 2) {
			isFolder =  true;
		}else{
			isFolder = false;
		}

		var childDivHtml = "";
		for(var j = 0; j < menuLvl; j++){
			childDivHtml += "&nbsp;&nbsp;&nbsp;";
		}

		if (hasChildNode) {
			if (lastSibling) {
				childDivHtml += "<a href='javascript:openCloseEx(\"" + menuId + "\", 1);'><img id='join" + menuId + "' src='"+imgpath;
				if (isNodeOpen) childDivHtml += "menu_minus";
				else childDivHtml += "menu_plus";
				childDivHtml += "bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>";
			} else {
				childDivHtml += "<a href='javascript: openCloseEx(\"" + menuId + "\", 0);'><img id='join" + menuId + "' src='"+imgpath;
				if (isNodeOpen) childDivHtml += "menu_minus";
				else childDivHtml += "menu_plus";
				childDivHtml += ".gif' border='0' align='absbottom' alt='Open/Close node' /></a>";
			}
		} else {
			if (lastSibling) childDivHtml += "<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >";
			else childDivHtml += "<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >";
		}

		if (hasChildNode) {
			childDivHtml += "<img id='icon" + menuId + "' src='"+imgpath+"menu_folder";
			if (isNodeOpen) childDivHtml += "open";
			childDivHtml += ".gif' border='0' alt='Folder' >";
		} else childDivHtml += "<img id='icon" + menuId + "' src='"+imgpath+"menu_page.gif' border='0' align='absbottom' alt='Page'>";

		childDivHtml += "<a href='javascript:choiceNodes(" + getTreeArrayId(menuId) + ");'>";

		if (menuNm.length > 12) {
			childDivHtml += menuNm.substring(0,12) + "...";
		} else {
			childDivHtml += menuNm;
		}
		childDivHtml += "</a><br>";

		if (hasChildNode) {
			childDivHtml += "<div id='div" + menuId + "'";
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
function addFirstTreeNode(langCode) {

	for (var i = 0; i < treeNodes.length; i++) {

		var nodeValues = treeNodes[i].split("|");

		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChildNode = ( getNodeHasChild(nodeValues) == 1 ) ? true : false;
		var isNodeOpen = isTreeNodeOpen(nodeValues[0]);

		// 폴더 , 페이지 구분하는 로직 (Level이 1,2 단계는 폴더, 3단계는 Page로 한다.)
		var menuLvl = nodeValues[3];

		var menuNmKo = nodeValues[2];
		var menuNmEn = nodeValues[14];
		var menuNm1 = nodeValues[17];
		var menuNm2 = nodeValues[18];

	    // 위치가 맨 마지막인 경우
		if (lastSibling) {

			if(hasChildNode){
				document.write("<a href='javascript:openCloseEx(\"" + nodeValues[0] + "\", 1);'><img id='join" + nodeValues[0] + "' src='"+imgpath);
				 	if (isNodeOpen) document.write("menu_minus");
					else document.write("menu_plus");
				document.write("bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>");
			}else{
				// 폴더인데 비어 있는 경우는 join id를 가지고 있지 않음
				document.write("<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >");
			}

		} else {

			if(hasChildNode){

					document.write("<a href='javascript: openCloseEx(\"" + nodeValues[0] + "\", 0);'><img id='join" + nodeValues[0] + "' src='"+imgpath);
						if (isNodeOpen) document.write("menu_minus");
						else document.write("menu_plus");
					document.write(".gif' border='0' align='absbottom' alt='Open/Close node' /></a>");
			}else{

				document.write("<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >");

			}
		}

		document.write("<a href='javascript:choiceNodes(" + i + ");'>");

		document.write("<img id='icon" + nodeValues[0] + "' src='"+imgpath+"menu_folder");
		if (isNodeOpen) {
			document.write("open");
		}
		document.write(".gif' border='0' alt='Folder' >");

		document.write("<span id='menuSpan" + nodeValues[0] + "'>");
		// 언어코드에 따라서 메뉴 언어를 분리
		if(langCode == 'ko'){

			document.write(util_replace(menuNmKo, " ", "&nbsp;"));

		}else if(langCode == 'en'){

			document.write(util_replace(menuNmEn, " ", "&nbsp;"));

		}else if(langCode == 'fr'){

			document.write(util_replace(menuNm1, " ", "&nbsp;"));

		}else if(langCode == 'ar'){

			document.write(util_replace(menuNm2, " ", "&nbsp;"));

		}
		document.write("</span>");
		document.write("</a><br>");
		document.write("<div id='div" + nodeValues[0] + "'");
		if (!isNodeOpen) {
			document.write(" style='display: none;'");
		}
		document.write(">");
		document.write("</div>");
	}
}


/*
* 신규 트리노드 추가
*/
function addSubTreeNode(parentNode) {

	var nodeValues = parentNode.split("|");

	var menuId = nodeValues[0];
	var upperMenuId = nodeValues[1];
	var menuNmKo = nodeValues[2];
	var menuLvl = nodeValues[3];
	var menuNmEn = nodeValues[14];
	var hasChild = getNodeHasChild(nodeValues);
	var menuNm = nodeValues[16];
	var menuNm1 = nodeValues[17];
	var menuNm2 = nodeValues[18];

	var parentDiv = document.getElementById("div" + upperMenuId);

	var lastSibling	= lastTreeSibling(menuId, upperMenuId);
	var hasChildNode = ( hasChild == 1 ) ? true : false;
	var isNodeOpen = isTreeNodeOpen(menuId);

	// 폴더 , 페이지 구분하는 로직 (Level이 1,2 단계는 폴더, 3단계는 Page로 한다.)

	var isFolder;
	if (menuLvl == 1 || menuLvl == 2) {
		isFolder =  true;
	}else{
		isFolder = false;
	}

	var childDivHtml = "";
	for(var i = 0; i < menuLvl; i++){
		childDivHtml += "&nbsp;&nbsp;&nbsp;";
	}

	if (hasChildNode) {
		if (lastSibling) {
			childDivHtml += "<a href='javascript:openCloseEx(\"" + menuId + "\", 1);'><img id='join" + menuId + "' src='"+imgpath;
			if (isNodeOpen) childDivHtml += "menu_minus";
			else childDivHtml += "menu_plus";
			childDivHtml += "bottom.gif' border='0' align='absbottom' alt='Open/Close node' ></a>";
		} else {
			childDivHtml += "<a href='javascript: openCloseEx(\"" + menuId + "\", 0);'><img id='join" + menuId + "' src='"+imgpath;
			if (isNodeOpen) childDivHtml += "menu_minus";
			else childDivHtml += "menu_plus";
			childDivHtml += ".gif' border='0' align='absbottom' alt='Open/Close node' /></a>";
		}
	} else {
		if (lastSibling) childDivHtml += "<img src='"+imgpath+"menu_joinbottom.gif' border='0' align='absbottom' alt='' >";
		else childDivHtml += "<img src='"+imgpath+"menu_join.gif' border='0' align='absbottom' alt='' >";
	}

	if (hasChildNode) {
		childDivHtml += "<img id='icon" + menuId + "' src='"+imgpath+"menu_folder";
		if (isNodeOpen) childDivHtml += "open";
		childDivHtml += ".gif' border='0' alt='Folder' >";
	} else childDivHtml += "<img id='icon" + menuId + "' src='"+imgpath+"menu_page.gif' border='0' align='absbottom' alt='Page'>";

	childDivHtml += "<a href='javascript:choiceNodes(" + getTreeArrayId(menuId) + ");'>";

	if (menuNm.length > 12) {
		childDivHtml += menuNm.substring(0,12) + "...";
	} else {
		childDivHtml += menuNm;
	}
	childDivHtml += "</a><br>";

	if (hasChildNode) {
		childDivHtml += "<div id='div" + menuId + "'";
		if (!isNodeOpen) childDivHtml += " style='display: none;'";
		childDivHtml += ">";

		childDivHtml += "</div>";
	}

	parentDiv.innerHTML = parentDiv.innerHTML + childDivHtml;

}

/* ********************************************************
 * 상세내역조회 함수
 ******************************************************** */
function choiceNodes(nodeNum) {

	var updateMenuDiv = parent.document.getElementById("updateMenuDiv");
	var addMenuDiv = parent.document.getElementById("addMenuDiv");

	if(updateMenuDiv.style.display == "none" ){

		// 프레임이 변경되어 있었을 경우에 변경함
		if ( addMenuDiv.style.display == "" ) {
			addMenuDiv.style.display = "none";
		}

		updateMenuDiv.style.display = "";

	}
	var nodeValues = treeNodes[nodeNum].split("|");

	// 삭제 시 자식이 있는 메뉴의 경우에는 삭제 불가 하기 위한 로직
	var hasChild = (nodeValues[15] == 1) ? true : false;
	parent.document.getElementById("hasChild").value = hasChild;

	parent.document.getElementById("menuId_show").innerHTML = nodeValues[0];
	parent.document.getElementById("menuId").value = nodeValues[0];
	parent.document.getElementById("upperMenuId_show").innerHTML = nodeValues[1];
	parent.document.getElementById("upperMenuId").value = nodeValues[1];

	parent.document.frm_menu_list.menuNmKo.value = nodeValues[2];
	parent.document.frm_menu_list.menuNmEn.value = nodeValues[14];
	parent.document.frm_menu_list.menuNm1.value = nodeValues[17];
	parent.document.frm_menu_list.menuNm2.value = nodeValues[18];

	parent.document.getElementById("menuLvl").innerHTML = nodeValues[3];
	parent.document.getElementById("menuOrd_show").innerHTML = nodeValues[4];
	parent.document.getElementById("menuOrd").value = nodeValues[4];
	parent.document.getElementById("rscUrl").value = nodeValues[6];
	parent.document.getElementById("upperMenuNmKo").innerHTML = nodeValues[10];

	if(nodeValues[11] == 'F'){
		parent.document.getElementById("menuType1").checked = true;
	}else if(nodeValues[11] == 'P'){
		parent.document.getElementById("menuType2").checked = true;
	}

	if(nodeValues[12] == 'Y'){
		parent.document.getElementById("caYn1").checked = true;
	}else{
		parent.document.getElementById("caYn1").checked = false;
	}

	// 시스템 구분 관련 셋팅
	var menuClCd = nodeValues[13];
	parent.document.getElementById("menuClCdAuth").value = menuClCd;

	if(menuClCd == 'p'){
		parent.document.getElementById("menuClCd1").checked = true;
	}else if(menuClCd == 'u'){
		parent.document.getElementById("menuClCd2").checked = true;
	}else if(menuClCd == 'b'){
		parent.document.getElementById("menuClCd3").checked = true;

	}else if(menuClCd == 'ct'){
		parent.document.getElementById("menuClCd4").checked = true;

	}else if(menuClCd == 's'){
		parent.document.getElementById("menuClCd5").checked = true;

	}else if(menuClCd == 'ca'){
		parent.document.getElementById("menuClCd6").checked = true;

	}else if(menuClCd == 'ex'){
		parent.document.getElementById("menuClCd7").checked = true;

	}

	// 위로, 아래로 버튼 클릭 시 노드 번호로 마지막 order 인지 확인
	parent.document.getElementById("nodeNum").value = nodeNum;

	if(nodeValues[7] == 'Y'){
		parent.document.getElementById("useYn1").checked = true;
	}else{
		parent.document.getElementById("useYn1").checked = false;
	}

	if(nodeValues[8] == 'Y'){
		parent.document.getElementById("menuDefault1").checked = true;
	}else{
		parent.document.getElementById("menuDefault1").checked = false;
	}


	// 추가 버튼 활성화 여부 확인
	var menuLvl = nodeValues[3];
	var dispCd = nodeValues[9];

	var trtButtonWithAdd = parent.document.getElementById("trtButtonWithAdd");
	var trtButton = parent.document.getElementById("trtButton");

	if(menuLvl == '1' || menuLvl == '2'){

		trtButtonWithAdd.style.display = "block";
		trtButton.style.display = "none";

		parent.document.getElementById("menuDefault1").disabled = "true";

		// 각 노드의 자식의 MaxOrder, MaxMenuId 를 리턴


				var maxChildNode = getMaxOrderOfNode(nodeValues[0]);

				parent.document.getElementById("maxOrder").value = maxChildNode.order;

				// 메뉴ID 채번
				// 단계에 따라서 달라져야 함. (함수로 뺌)

				if(menuLvl == '1'){

					var job_id  = maxChildNode.menuId.substring(0,2);

					var last_id = maxChildNode.menuId.substring(6,8);

					var num_id =  Number(maxChildNode.menuId.substring(2,6))+1;




					if(maxChildNode.menuId.charAt(2)=='0'){

						var menuId = job_id + '0' + num_id + last_id;

					}else{

						var menuId = job_id + num_id + last_id;
					}

				}else if(menuLvl=='2'){

					var job_id = maxChildNode.menuId.substring(0,2);

					// 0인 경우 처리

					var num_id = Number(maxChildNode.menuId.substring(2,8))+1;

					if(maxChildNode.menuId.charAt(2)=='0'){

						var menuId = job_id + '0' + num_id;

					}else{

						var menuId = job_id + num_id;
					}

				}

				parent.document.getElementById("max_menuId").value = menuId;

	}else{

		parent.document.getElementById("menuDefault1").disabled = "";

		trtButtonWithAdd.style.display = "none";
		trtButton.style.display = "block";
	}



}
/* ********************************************************
 * 추가 시 내역조회 함수
 ******************************************************** */
function choiceAddNodes() {

	parent.document.getElementById("add_upperMenuId").innerHTML = parent.document.getElementById("menuId_show").innerHTML;


}

/*
* 트리노드 액션(열기,닫기)
*/
function openCloseEx(node, bottom ) {
	
	var treeDiv = document.getElementById("div" + node);
	var treeJoin	= document.getElementById("join" + node);
	var treeIcon = document.getElementById("icon" + node);

	var childs = treeDiv.childNodes;

	if (childs.length != 0 ) {

		if (treeDiv.style.display == 'none') {

			// 열 때
			if (bottom==1) treeJoin.src = treeIcons[3].src;
			else treeJoin.src = treeIcons[2].src;
			treeIcon.src = treeIcons[5].src;
			treeDiv.style.display = '';


		} else {

			// 닫을 때
			if (bottom==1) treeJoin.src = treeIcons[1].src;
			else treeJoin.src = treeIcons[0].src;
			treeIcon.src = treeIcons[4].src;
			treeDiv.style.display = 'none';

		}

	} else {
		if (bottom==1) {
			treeJoin.src = treeIcons[3].src;
		} else {
			treeJoin.src = treeIcons[2].src;
		}
		treeIcon.src = treeIcons[5].src;
		
		var url = contextPath + "pt/menu/selectListSubMenu.do?upperMenuId=" + node;
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


function initOpenNodes(nodes) {

	for (var i = 0; i < nodes.length; i++) {

		if ( nodes[i] != null ) {
			var nodeValues = treeNodes[getTreeArrayId(nodes[i])].split("|");

			var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
			var hasChild = ( getNodeHasChild(nodeValues) == 1 ) ? true : false;

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
	
	util_showExecutionImageOnParent();
	
	for (var i = 0; i < treeNodes.length; i++) {

		var nodeValues = treeNodes[i].split("|");
		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChild = ( getNodeHasChild(nodeValues) == 1 ) ? true : false;

		var treeDiv = document.getElementById("div" + nodeValues[0]);

		if ( hasChild ) {
			if ( treeDiv.style.display == "none" ) {
				if ( lastSibling ) {
					openCloseEx(nodeValues[0], 1);
				} else {
					openCloseEx(nodeValues[0], 0);
				}
			}
		}
	}
	
	util_hideExecutionAll(parent.document);
}


/*
* 모든 트리 닫기
*/
function closeAll(node, bottom){
	
	util_showExecutionImageOnParent();

	for (var i = 0; i < treeNodes.length; i++) {

		var nodeValues = treeNodes[i].split("|");

		var treeDiv = document.getElementById("div" + nodeValues[0]);
		var treeJoin	= document.getElementById("join" + nodeValues[0]);
		var treeIcon = document.getElementById("icon" + nodeValues[0]);


		var lastSibling	= lastTreeSibling(nodeValues[0], nodeValues[1]);
		var hasChildNode	= hasChildTreeNode(nodeValues[0]);

		// 하위노드는 열수가 없으니 제외 + 비워있는 폴더도 제외
		var menuLvl = nodeValues[3];

		if(menuLvl != 3 && hasChildNode == true){

			if (treeDiv.style.display != 'none') {

				// 닫은 경우
				if (lastSibling) treeJoin.src = treeIcons[1].src;
				else treeJoin.src = treeIcons[0].src;
				treeIcon.src = treeIcons[4].src;
				treeDiv.style.display = 'none';

			}

		}
		
	}
		
	util_hideExecutionAll(parent.document);
}



function refresh(){

	var openArray = "";


	for (var i=0; i<treeNodes.length; i++){
		var nodeValues = treeNodes[i].split("|");

		var menuLvl = nodeValues[3];

		if(menuLvl == '1' || menuLvl == '2'){

				var treeDiv = document.getElementById("div" + nodeValues[0]);
				var hasChildNode = hasChildTreeNode(nodeValues[0]);

				// 하위 자식이 없는 폴더 제외
				if(hasChildNode == true){

						if(treeDiv.style.display == ''){

							if ( openArray != "" ) {
								openArray += ':';
							}
							openArray += nodeValues[0];
							//isFirstOne = false;

					}

				}

		}
	}

	document.frm_menu_list.isRequestFromMenuList.value = "Y";
	document.getElementsByName("PtMenuFrame")[0].src = contextPath + "pt/menu/selectListTotalMenu.do" + "?openNodes=" + openArray;

}


/*
* 자식 노드의 기본메뉴 체크가 된 것들이 있는지 확인
* 체크가 된 것이 있으면 : true
* 체크가 된 것이 없으면 : false
*/
function hasDefaultMenuOther(nodeNum){


	var return_val = new Object();

	return_val.hasChecked = false;
	return_val.checkedId = "";

	var cur_Node = PtMenuFrame.treeNodes[nodeNum].split("|");

	for (var i=0; i<PtMenuFrame.treeNodes.length; i++){
		var nodeValues = PtMenuFrame.treeNodes[i].split("|");

		if(i==nodeNum)
			continue;

		// 부모를 찾으면
		if(cur_Node[1]==nodeValues[0]){

				  for(var j=0; j <PtMenuFrame.treeNodes.length; j++){

					  if(j==i || j==nodeNum)
						  continue;

					  var nodeChildValues = PtMenuFrame.treeNodes[j].split("|");

					   // 자식을 찾으면
					   if(nodeChildValues[1]==nodeValues[0]){

							if(nodeChildValues[8] == 'Y'){

								return_val.hasChecked = true;
								return_val.checkedId = nodeChildValues[0];

								return return_val;
							}

					   }

				  }


		}
	}


	return return_val;


}

