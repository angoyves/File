
/**
	 * share tweeter
	 *
	 * @param title
	 * @param url
	 * @return void
	 */
	function util_shareTwitter(title, url, paramStr) {

    	var offsetObj = util_getContentsOffSet(document);

		var left = offsetObj.centerWidth - 310;
		var top = offsetObj.centerHeight - 200;

		var href = "http://twitter.com/share?text=" + encodeURIComponent(util_decodeQuot(title)) + "&title=" + encodeURIComponent(util_decodeQuot(title)) + "&url=" + "http://" + url + paramStr  + "&isBack=N";

	    var sharePopup = window.open(href, 'twitter', 'width=450px,height=350px,left='+left+'px, top='+top+'px, scrollbars=0');
	    if(sharePopup) { sharePopup.focus(); }

	}

	/**
	 * share facebook
	 *
	 * @param title
	 * @param summary
	 * @param url
	 * @return void
	 */
    function util_shareFacebook(title, summary, url, paramStr) {

		var offsetObj = util_getContentsOffSet(document);
		var href = "http://www.facebook.com/sharer.php?s=100&p[url]=" + "http://" + url + paramStr + "&isBack=N" +
		               "&p[title]=" + encodeURIComponent(util_decodeQuot(title));

		if(summary.length > 20){
			href += "&p[summary]=" + encodeURIComponent(util_decodeQuot(summary).substring(0, 20) + "..");
		}else{
			href += "&p[summary]=" + encodeURIComponent(util_decodeQuot(summary));
		}

		var left = offsetObj.centerWidth - 310;
		var top = offsetObj.centerHeight - 200;

		var sharePopup = window.open(href, "", "left=" + left + "px, top=" + top + "px, width=660px, height=350px,scrollbars=0");
		if(sharePopup) { sharePopup.focus(); }

	}