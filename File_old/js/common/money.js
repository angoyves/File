
	/*
	 * 숫자를 돈으로 표시
	 */
	function util_showMoneyText(obj, textDivName, wrongFormatMessage, lang){

		// , 삭제 및 소수점 분리
		var totalMoney = obj.value.replaceAll(",", "");

		// 숫자 및 "."만 입력
		for(var i = 0 ; i < totalMoney.length; i++){

			if(totalMoney.charCodeAt(i) != 46 && (totalMoney.charCodeAt(i) < 48 || totalMoney.charCodeAt(i) > 59)){

				alert(wrongFormatMessage);
				obj.value = "";
				obj.focus();
				return;

			}

			if(totalMoney.charCodeAt(i) == 46){

				if(!isPointExist){
					isPointExist = true;
				}else{
					alert(wrongFormatMessage);
					obj.value = "";
					obj.focus();
					return;
				}

			}

		}

		// .는 1개만 가능
		var isPointExist = false;
		// , 삭제 및 소수점 분리
		var totalMoney = obj.value.replaceAll(",", "");
		var moneyInt = 0;
		var moneyPoint = 0;
		if(totalMoney.indexOf(".") > -1){
			moneyInt = totalMoney.substring(0, totalMoney.indexOf("."));
			moneyPoint = totalMoney.substring(totalMoney.indexOf(".") + 1);
		}else{
			moneyInt = totalMoney;
		}

		var moneyStr = "";
		var en4MoneyUnit = new Array("", "thousand", "million", "billion", "trillion", "quadrillion");
		var en1DigitUnit = new Array("", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine");
		var en10DigitUnit = new Array("ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen",
				                      "sixteen", "seventeen", "eighteen", "nineteen");
		var en2DigitUnit = new Array("", "", "twenty", "thirty", "fourty", "fifty", "sixty", "seventy", "eighty", "ninety");

		var ko5MoneyUnit = new Array("", "만", "억", "조", "경");
		var ko1DigitUnit = new Array("", "일", "이", "삼", "사", "오", "육", "칠", "팔", "구");

		var textDiv = document.getElementById(textDivName);
		textDiv.innerHTML = "";

		// 영어
		if(lang == 'en'){

			/*
			 * 달러 단위 시작
			 */
			var enMoneyUnitCount = 0;
			for(var i = moneyInt.length ; i >0 ; i-=3){

				moneyStr = "";

				var tempMoney = (moneyInt.substring(i-3, i));
				var unitMoney = Number(tempMoney);

				// 백단위 처리
				if(tempMoney.length == 3){

					var hundredInt = Number(tempMoney.substring(0, 1));
					moneyStr = moneyStr + en1DigitUnit[hundredInt];
					if(hundredInt != 0){
						moneyStr = moneyStr + "hundred";
					}
					tempMoney = tempMoney.substring(1, 3);

				}

				// 십단위 처리
				var isTenUnit = false;
				if(tempMoney.length == 2){

					var tenInt = Number(tempMoney.substring(0, 2));

					if(tenInt >= 10 && tenInt <= 19 ){

						moneyStr = moneyStr + en10DigitUnit[tenInt % 10];
						isTenUnit = true;

					}else{

						var tenInt = Number(tempMoney.substring(0, 1));
						moneyStr = moneyStr + en2DigitUnit[tenInt];
						tempMoney = tempMoney.substring(1, 2);

					}

				}

				if(!isTenUnit){
					moneyStr = moneyStr + en1DigitUnit[tempMoney];

				}

				//천단위
				if(i <= 3){
					textDiv.innerHTML = moneyStr + en4MoneyUnit[enMoneyUnitCount] + " " + textDiv.innerHTML;
				}else{

					if(unitMoney != 0){
						textDiv.innerHTML = moneyStr + en4MoneyUnit[enMoneyUnitCount] + " " + textDiv.innerHTML;
					}

				}
				enMoneyUnitCount++;
			}
			/*
			 * 달러 단위 끝
			 */

			/*
			 * 센트 단위 시작
			 */
			moneyStr = "";

			// 한단위만 입력되면 십단위로 처리
			// ex) .1 -> 10센트
			if(moneyPoint.length == 1){
				moneyPoint = moneyPoint + "0";
			}

			var moneyPointInt = Number(moneyPoint);

			if(moneyPointInt >= 20){

				moneyStr = moneyStr + en2DigitUnit[Math.floor(moneyPointInt / 10)] + en1DigitUnit[moneyPointInt % 10];

			}else if(moneyPointInt >= 10 && moneyPointInt <= 19 ){

				moneyStr = moneyStr + en10DigitUnit[moneyPointInt % 10];

			}else{

				moneyStr = moneyStr + en1DigitUnit[moneyPointInt];

			}

			// 끝에 "cent"를 붙인다
			if(moneyStr != ""){
				textDiv.innerHTML = textDiv.innerHTML + moneyStr + " cent";
			}


			/*
			 * 센트 단위 끝
			 */

		}
		// 한국어
		if(lang == 'ko'){

			/*
			 * 원단위 시작
			 */
			var koMoneyUnitCount = 0;
			for(var i = moneyInt.length ; i >0 ; i-=4){

				moneyStr = "";

				var tempMoney = moneyInt.substring(i-4, i);
				var unitMoney = Number(tempMoney);

				// 천단위 처리
				if(tempMoney.length == 4){

					var thousandInt = Number(tempMoney.substring(0, 1));
					moneyStr = moneyStr + ko1DigitUnit[thousandInt];
					if(thousandInt != 0){
						moneyStr = moneyStr + "천";
					}
					tempMoney = tempMoney.substring(1, 4);

				}

				// 백단위 처리
				if(tempMoney.length == 3){

					var hundredInt = Number(tempMoney.substring(0, 1));
					moneyStr = moneyStr + ko1DigitUnit[hundredInt % 10];
					if(hundredInt != 0){
						moneyStr = moneyStr + "백";
					}
					tempMoney = tempMoney.substring(1, 3);

				}

				// 십단위 처리
				if(tempMoney.length == 2){

					var tenInt = Number(tempMoney.substring(0, 1));
					moneyStr = moneyStr + ko1DigitUnit[tenInt % 10];
					if(tenInt != 0){
						moneyStr = moneyStr + "십";
					}
					tempMoney = tempMoney.substring(1, 2);

				}

				// 일단위 처리
				if(Number(tempMoney) != 0){
					moneyStr = moneyStr + ko1DigitUnit[Number(tempMoney)];
				}


				//만단위
				if(i <= 4){
					textDiv.innerHTML = moneyStr + ko5MoneyUnit[koMoneyUnitCount] + " " + textDiv.innerHTML;
				}else{
					if(unitMoney != 0){
						textDiv.innerHTML = moneyStr + ko5MoneyUnit[koMoneyUnitCount] + " " + textDiv.innerHTML;
					}
				}
				koMoneyUnitCount++;

			}
			/*
			 * 원단위 끝
			 */

		}

	}

	