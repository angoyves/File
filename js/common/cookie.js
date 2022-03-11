/**
 * 쿠키값을 가져온다.
 * 
 * @param 쿠키 키값
 * @return 쿠키 값
 */
function getCookie(Name) {
	  var search = Name + "=";
	  if (document.cookie.length > 0) { // 쿠키가 설정되어 있다면
	    offset = document.cookie.indexOf(search);
	    if (offset != -1) { // 쿠키가 존재하면
	      offset += search.length;
	      // set index of beginning of value
	      end = document.cookie.indexOf(";", offset);
	      // 쿠키 값의 마지막 위치 인덱스 번호 설정
	      if (end == -1)
	        end = document.cookie.length;
	      return unescape(document.cookie.substring(offset, end));
	    }
	  }
	  return "";

}