/**
 * 파일 다운로드
 *
 */
function util_downloadFile(url, path, name, realName, bizPath){

	var url = url + "co/file/downloadFile.do?filePath=" + window.encodeURI(path);
	    url += "&fileName=" + name;
	    url += "&realFileName="+  window.encodeURI(realName);
	    url += "&attach_biz_path=" + bizPath;

	document.getElementsByName("attachFileFrame")[0].src = url;

}

/**
 * 파일 다운로드
 *
 */
function util_downloadFileByPath(url, path, realName, bizPath){

	var url = url + "co/file/downloadFile.do?filePath=" + window.encodeURI(path);
	    url += "&realFileName="+  window.encodeURI(realName);
	    url += "&attach_biz_path=" + bizPath;

	document.getElementsByName("attachFileFrame")[0].src = url;

}

/**
 * 파일 다운로드
 *
 */
function util_downloadFileByFullPath(url, fullFilePath, realName){

	var url = url + "co/file/downloadFile.do?fullFilePath=" + window.encodeURI(fullFilePath);
	    url += "&realFileName="+  window.encodeURI(realName);

	document.getElementsByName("attachFileFrame")[0].src = url;

}