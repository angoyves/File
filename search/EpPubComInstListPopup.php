<?php require('../includes/db.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'EpPubComInstListPopup', $ObjId = 'Title'); ?></title>
<link rel="stylesheet" href="../css/common.css" media="all">
<c:out value="${commonScript}" escapeXml="false"/>
<script type="text/javascript" src="../js/common/event.js"></script>
<script type="text/javascript" src="../js/common/string.js"></script>
<script type="text/javaScript" language="javascript">

/* ********************************************************
 * 화면 onLoad
 ******************************************************** */
function fn_onLoad(){
	fn_selectListPageBidInst();

}

/* ********************************************************
 * 조회 처리 함수
 ******************************************************** */
function fn_selectListPageBidInst(){

	var form = document.frm_pub_bidInst;
	
	form.currentPageNo.value = 1;
	
	form.action = "EpPubComInstListFramePopup.php"; // pointe vers la page detail
	form.target = "EpPubBidInstListFramePopup"; // pointe vers le frame
	form.submit();
	
	//Form = frm_pub_bidInst
	//Frame = EpPubBidInstListFramePopup
	

}

</script>
</head>
<body onLoad="fn_onLoad();">
<div id="popup_main">
	<div id="popWrap">
	    <!-- Layout : header Area -->
	    <div id="pop_header" class="popHeader">
	        <h1 class="title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'EpPubComInstListPopup', $ObjId = 'Title'); ?></h1><!-- 공고기관 조회 -->
	        <button class="Close" title="Button" onClick="window.close();">Fermer</button>
	    </div>
	    <!-- // Layout : header Area -->
	
	    <!-- Layout : container Area -->
	    <div id="popup_contents" class="popContainer"> 
	    	<form  name="frm_pub_bidInst" method="post">
				<input type="hidden" id="searchConditions" name="searchConditions" value="${epPubSVO.searchConditions}">
				<input type="hidden" id="currentPageNo" name="currentPageNo" value="${epPubSVO.currentPageNo}">
	        <!-- 입력폼 // -->
	       <div class="tableTy2">
		       <div class="dataArea">
		            <span class="rtl"></span><span class="rtr"></span><span class="rbl"></span><span class="rbr"></span> <!-- 라운드 디자인을 위함. -->
		            <table class="data">
	                    <colgroup>
	                        <col style="width:18%">
	                        <col style="width:*">
	                    </colgroup>
	                    <tbody>
	                    	<tr>
	                        	<th scope="row"><span class="title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'EpPubComInstListPopup', $ObjId = 'pub_inst_cd'); ?></span></th><!-- 공고기관코드 -->
	                            <td>
	                            	<input type="text" class="text" id="instCd" name="instCd" style="width:15%" maxlength="10"
                           				onblur="javascript:util_checkValidation(this, '^[0-9]*$', 10);">
                   				</td>
	                        </tr>
	                        <tr>                                                                          
	                            <th scope="row"><span class="title"><?php echo MyDB::getInstance()->GetMenuByObjId($ProgramID = 'EpPubComInstListPopup', $ObjId = 'pub_inst_nm'); ?></span></th><!-- 공고기관명 -->
	                            <td><input type="text" class="text" id="instNm" name="instNm" style="width:60%" maxlength="200"
                             			onblur="javascript:util_checkValidation(this, '^[^<>]*$', 200);">
	                            </td>
	                        </tr>
	                        
	                    </tbody>
					</table>
		        </div>
	        </div>
	        <!-- //입력폼 끝 -->
			
			<!-- 검색버튼 영역 시작 -->
			<div class="fR mt15 mb20">
				<label class="blind" for="more">Label ici</label>
				<span class="btnTy3">
					<input class="btn" type="button" onClick="fn_selectListPageBidInst()"
                     		value="Rechercher">
				</span>
			</div>
            </form>
            <iframe name="EpPubBidInstListFramePopup" id="EpPubBidInstListFramePopup" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
            <span class="btnTy21"><input type="button" class="btn" value="Ajouter une structure" onClick="javascript:fn_insertPubPayment();"></span>
	    </div>
	    <!-- // Layout : container Area -->
	    <!-- Layout : Button Area -->
	    <div class="popFooter"><span class="btnTy4"><button class="btn" onClick="window.close();" title="Fermer le fenetre">Fermer</button></span><!-- Close -->
	    <!-- // Layout : Button Area -->
	</div>
</div>				
</body>
</html>