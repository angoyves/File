
	/**
	 * 공통코드 조회
	 *
	 * @param 코드명
	 * @param 코드
	 * @param 코드구분
	 * @param 화면이름
	 * @return void
	 */
	function util_searchCommonCd(cdNm, cd, cdCls, title){

		var retVal;

		var openParam = "dialogWidth:845px;dialogHeight:700px;scroll:yes;resizable:no;";
		var url = contextPath + "co/code/forwardCoCommonCodePopup.do?cdCls=" + window.encodeURI(cdCls) + "&cdNm=" + window.encodeURI(cdNm.value) + "&title=" + window.encodeURI(title);

		retVal = window.showModalDialog(url,'', openParam);

		if(retVal){

			cdNm.value = retVal.cdNm;
			cd.value  = retVal.cd;

		}

	}

	/**
	 * 우편번호 조회
	 *
	 * @param 우편번호
	 * @param 주소
	 * @return void
	 */
	function util_searchZip(zipCode, addr){

		var retVal;

		var addr1 = "";
		var addr2 = "";
		var addr3 = "";

		var openParam = "dialogWidth:845px;dialogHeight:550px;resizable:no;";
		var url = contextPath + "co/zip/forwardCoZipPopup.do?currentPageNo=1";

		var addrs = addr.value.split(",");

		if(addrs.length > 1){

			var j = 0;
			for(var i = addrs.length - 1; i >= 0; i--){
				url += "&addr" + (i + 1) + "=" + addrs[j++].trim();
			}

		}

		retVal = window.showModalDialog(url,'', openParam);

		if(retVal){

			zipCode.value = retVal.zipCode;
			addr.value  = retVal.addr;

		}

	}

	/**
	 * 업종조회 조회
	 *
	 * @param 업종코드
	 * @param 업종명
	 * @return void
	 */
	function util_searchLicense(licenseId, licenseNm){

		var retVal;

		var openParam = "dialogWidth:845px;dialogHeight:550px;resizable:no;";
		var url = contextPath + "co/license/moveLicensePopup.do?s_licenseId=" + licenseId.value;

		retVal = window.showModalDialog(url,'', openParam);

		if(retVal){

			licenseId.value  = retVal.licenseId;
			licenseNm.value  = retVal.licenseNm;

	    }

	}

