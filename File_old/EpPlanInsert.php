<?php require_once('../Connections/MyFileConnect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_MyFileConnect, $MyFileConnect);
$query_rsRegion = "SELECT region_id, region_lib FROM regions WHERE display = '1' ORDER BY region_lib ASC";
$rsRegion = mysql_query($query_rsRegion, $MyFileConnect) or die(mysql_error());
$row_rsRegion = mysql_fetch_assoc($rsRegion);
$totalRows_rsRegion = mysql_num_rows($rsRegion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
<!--<c:out value="${commonScript}" escapeXml="false"/>-->
<script type="text/javascript" src="js/common/ajax.js"></script>
<script type="text/javascript" src="js/common/string.js"></script>
<script type="text/javascript" src="<c:url value='/js/common/json2.js' />"></script>
<script type="text/javascript" src="js/common/prototype.js"></script>
<script type="text/javascript" src="js/common/event.js"></script>
<script type="text/javascript" src="js/common/date.js"></script>
<script type="text/javascript" src="js/common/calendar.js"></script>
<script type="text/javascript" src="js/common/format.js"></script>
<script type="text/javascript" src="js/common/pagination.js"></script>
<script type="text/javascript" src="js/common/money.js"></script>
<script type="text/javascript" src="js/common/validation.js"></script>
<link rel="stylesheet" href="css/common.css" media="all">
<!--<validator:javascript formName="frmPlanInsert" staticJavascript="false" xhtml="true" cdata="false"/>
--><script type="text/javascript">
//26112015 TABLEAU D'OBJET JSON 

function fn_onLoad(){	
	//-- remove "href" of anchor tag 
	
	fn_onChangeRegion(document.getElementById("selRegion1"));
	fn_onChangeRegion(document.getElementById("selRegion2")); 
	
	var region3 = document.getElementById("selRegion3");
	document.getElementById('region3').value = region3.options[region3.selectedIndex].value;
}
function fn_onChangeRegion1{
	
	//var region1 = document.getElementById("selRegion3");
	//document.getElementById('region1').value = region1.options[region1.selectedIndex].value;
	document.getElementById(document.getElementById("selRegion1").id.toLowerCase().substring(3,10)).value = obj.options[obj.selectedIndex].value;
	
	}
function fn_onChangeRegion(obj){
	
	document.getElementById(obj.id.toLowerCase().substring(3,10)).value = obj.options[obj.selectedIndex].value;
	
	if( obj.id.toLowerCase().substring(3,10)!="region3" ){
	
		var request = AutoComplete.getXMLHttpRequest();

		var params = ("cd="+obj.options[obj.selectedIndex].value+"&type="+( obj.id.toLowerCase().substring(3,10)=="region1"?"region2":"region3" ));
		
		request.open("POST", "<c:url value='/ep/plan/getCommonRegion.do'/>", false);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
		request.setRequestHeader("Cache-Control","no-cache, must-revalidate");
		request.setRequestHeader("Pragma","no-cache");
		
		request.onreadystatechange = function(){
			
			if( request.readyState==4 ){
				
				if( request.status==200 ){
					
					 var selRegion = document.getElementById(( obj.id.toLowerCase().substring(3,10)=="region1"?"selRegion2":"selRegion3" ));
					 for(var index=0;index<selRegion.length;index++){
						 
						 selRegion.remove(index);
					 }	
					 
					 var result = request.responseText;
					 
					 var regionList = JSON.parse(result);
					 
					 // remove before child option
					 var selectObj = document.getElementById(( obj.id.toLowerCase().substring(3,10)=="region1"?"selRegion2":"selRegion3" ));
					 for(var bIndex=selectObj.options.length-1;bIndex>=0;bIndex--){
						 
						 selectObj.remove(bIndex);
					 }
					 // create ::: select option
					 var defaultOption = document.createElement("option");
					 defaultOption.value = null;
					 defaultOption.selected = "selected";
					 defaultOption.innerHTML = "Selectionne[]";
					 
					 // set init hidden value is null
					 document.getElementById(( obj.id.toLowerCase().substring(3,10)=="region1"?"region2":"region3" )).value = null;
					 
					 selectObj.appendChild(defaultOption);
					 
					 for(var index=0;index<regionList.length;index++){
						 
						 var option = document.createElement("option");
						 option.value = regionList[index].cd;
						 option.innerHTML = regionList[index].cdNm;
						 selectObj.appendChild(option);
					 }
				}
			}
		};
		
		request.send(params);
	}
}



function fn_isPrivateContOnChange(obj){
	
	var reason = document.getElementById("dirContrReqReason");
 	if( obj.options[obj.selectedIndex].value=="Y" ){
 		
 		reason.removeAttribute("readonly");
 		reason.removeAttribute("style");
 	}else if( obj.options[obj.selectedIndex].value=="N" ){
 		reason.value = "";
 		reason.setAttribute("readonly", "readonly");
 		reason.setAttribute("style", "background-color: #E2E2E2;");
 	}
}

</script>
</head>
<body onload="fn_onLoad();">
	<div id="main">
		<div id="sitewrap">
			<div id="wrap">
				<div id="header">
					${topMenuStr}
				</div>
	    		<div id="con_wrap">
	    			<div class="left_w">
	    				${leftMenuStr}
	        		</div> 
	        		
	        		<div class="content" id="contents">
						<h3><span class="bold"><l:mapping programId="EpPlanInsert" objId="title_reg_plan" /></span></h3>				<!-- 조달계획 등록 -->
						${naviStr}						
						<div class="con">   
							<form id="frmPlanSearchCondition" name = "frmPlanSearchCondition" modelAttribute="EpPlanSVO"  method="POST">
								<input type="hidden" id="isBack"             name="isBack"             value="N">
								<input type="hidden" id="currentPageNo"      name="currentPageNo"      value="<c:out value='${epPlanSVO.currentPageNo }'/>">
					           	<input type="hidden" id="recordCountPerPage" name="recordCountPerPage" value="<c:out value='${epPlanSVO.recordCountPerPage }'/>">
								<input type="hidden" id="searchConditions"   name="searchConditions"   value="<c:out value='${epPlanSVO.searchConditions }'/>">
							</form>
						
							<form id="frmPlanInsert" modelAttribute="EpPlanSVO"  method="POST" enctype="multipart/form-data">
								<!--<p class="bullet4_k"><l:mapping programId="EpPlanInsert" objId="general_info" /></p>	<!-- 일반정보 -->
								<!--<p class="fR mt10"><em class="pointTxt2 vNum" title="필수항목">*</em> <l:mapping programId="EpPlanInsert" objId="msg_field_required" /></p>-->		<!-- 표시된 항목은 필수입력사항입니다. -->
								<div class="tableTy1">
					                <div class="dataArea">
					                	<input type="hidden" name="planState" value="<c:out value='${planState }' />">
					                	<input type="hidden" name="rcvId" value="<c:out value='${rcvId }' />">
					                	<input type="hidden" name="regId" value="<c:out value='${regId }' />">
					                	<table class="data">
					                        <caption>검색</caption>
					                        <colgroup>
					                            <col style="width:30%">
					                            <col style="width:25%">
				 	                            <col style="width:20%">
					                            <col style="width:25%">
					                        </colgroup>
					                        <tbody>
					                            
<tr>
					                            	<th scope="row" class="tL"><label for="region1"><em class="pointTxt2" title="필수항목">*</em>Region</label></th>		<!-- 지역(도) -->
					                            	<td>
					                            		<input type="text" class="text" value="" id="region1" name="region1">
					                            		<select onchange="fn_onChangeRegion1();" id="selRegion1" name="selRegion1" style="width: 98%;">
					                            		  <option value="value">label</option>
					                            		  <?php
do {  
?>
					                            		  <option value="<?php echo $row_rsRegion['region_id']?>"><?php echo $row_rsRegion['region_lib']?></option>
					                            		  <?php
} while ($row_rsRegion = mysql_fetch_assoc($rsRegion));
  $rows = mysql_num_rows($rsRegion);
  if($rows > 0) {
      mysql_data_seek($rsRegion, 0);
	  $row_rsRegion = mysql_fetch_assoc($rsRegion);
  }
?>
                                                      </select>
					                            	</td>
					                            	<th scope="row" class="tL"><label for="region2"><em class="pointTxt2" title="">*</em>Departement</label></th>		<!-- 지역(시) -->
					                            	<td>
					                            		<input type="text" class="text" value="" id="region2" name="region2">
					                            		<select id="selRegion2" name="selRegion2" onchange="fn_onChangeRegion(this);" style="width: 98%;">	
					                            			<option disabled="disabled"></option>
					                            		</select>
					                            	</td>
					                            </tr>

					                            <tr>
					                            	<th scope="row" class="tL"><label for="region3">Arrondissement</label></th>		<!-- 지역(구) -->
					                            	<td>
					                            		<input type="text" class="text" value="" id="region3" name="region3">
					                            		<select id="selRegion3" name="selRegion3" onchange="javascipt:document.getElementById('region3').value = this.options[this.selectedIndex].value;" style="width: 98%;"> 
					                            			<option disabled="disabled">
					                            		</select>
					                            	</td>
					                            	<th scope="row" class="tL"><label for="region4"><l:mapping programId="EpPlanInsert" objId="region4" /></label></th>		<!-- 지역(군) -->
					                            	<td><input type="text" class="text" value="" id="region4" style="width:95%" name="region4" onkeyup="javascript:util_checkMaxLength(this, 200);"></td>
					                            </tr>
					                            				            
				                		  </tbody>
				                	  </table>
				                  </div>
				              </div>
				            </form>
						</div><!-- end of con -->
						
						<div class="fR mt15 mb20">
				        	<p class="btnAreaTxtL">
				        		<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="EpPlanInsert" objId="save" />" onclick="javascript:fn_save();"></span>		<!-- 저장 -->
					         	<span class="btnTy21"><input type="button" class="btn" value="<l:mapping programId="EpPlanInsert" objId="previous" />" onclick="javascript:fn_moveToPrePage();"></span>		<!-- 이전 -->
				        	</p>
				        </div>
					</div><!-- end of content -->
	        	</div>
	        	${footer}
	        </div>
	    </div>
	</div> 
	
	<iframe name="ResultFrame" height="0" width="0" frameborder="0"></iframe>
</body>
</html>
<?php
mysql_free_result($rsRegion);
?>
