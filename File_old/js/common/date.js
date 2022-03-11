
function util_getMonthArray(m0, m1, m2, m3, m4, m5, m6, m7, m8, m9, m10, m11) {
	this[0] = m0;
	this[1] = m1;
	this[2] = m2;
	this[3] = m3;
	this[4] = m4;
	this[5] = m5;
	this[6] = m6;
	this[7] = m7;
	this[8] = m8;
	this[9] = m9;
	this[10] = m10;
	this[11] = m11;
}

function util_getCurrentTime(){

    var CurrentTime = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));;
    var Year    = CurrentTime.getYear();
    var Month   = CurrentTime.getMonth();
    var day     = CurrentTime.getDate();
    var Hour    = CurrentTime.getHours();
    var Minutes = CurrentTime.getMinutes();
    var Seconds = CurrentTime.getSeconds();

    var ctime    = String(Year)+ String(Month)+ String(day)+ String(Hour)+ String(Minutes) + String(Seconds);
	return ctime;
}

function util_getDate(value){
	var year  = value.substring(4,8);
	var month = value.substring(2,4);
	var day   = value.substring(0,2);
	return ( util_isValidYear(year) && util_isValidMonth(month) && util_isValidDay(year,month,day) );
}

function util_getDateFromCal(value){
	var year  = value.substring(0,4);
	var month = value.substring(5,7);
	var day   = value.substring(8,10);

	return year + month + day;
}



function util_getMonthInterval(time1,time2) {
	var date1 = toTimeObject(time1);
	var date2 = toTimeObject(time2);

	var years = date2.getFullYear() - date1.getFullYear();
	var months = date2.getMonth() - date1.getMonth();
	var days = date2.getDate() - date1.getDate();

	return (years * 12 + months + (days >= 0 ? 0 : -1) );
}

function util_getDayInterval(time1,time2) {
	var date1 = toTimeObject(time1);
	var date2 = toTimeObject(time2);
	var day = 1000 * 3600 * 24;

	return parseInt((date2 - date1) / day, 10);
}

function util_getHourInterval(time1,time2) {
	var date1 = toTimeObject(time1);
	var date2 = toTimeObject(time2);
	var hour = 1000 * 3600;

	return parseInt((date2 - date1) / hour, 10);
}

/**
 * 오늘 날짜를 포맷팅해서 가져온다.
 *
 */
function util_getTodayWithFormat(){

	var date = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));

	var today = dateFormat;
	today = today.replace("yyyy", systimeStr.substring(0,4));
	today = today.replace("MM", systimeStr.substring(4,6));
	today = today.replace("dd", systimeStr.substring(6,8));

	return today;

}

/**
 * 현재일에서 value일만큼 뒤의 날짜를 구해 리턴한다
 * @param value, 몇일뒤
 * @returns 'YYYY/MM/DD' 현재일에서 value일만큼 뒤의 날짜
 */
function util_addDate(value){

	var currentDate = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));
	var resultTimeMil = currentDate.getTime()+(Number(value)*24*3600*1000);
	var resultDate = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));
	resultDate.setTime(resultTimeMil);

	var year = String(resultDate.getFullYear());
	var month;
	var date;

	if(resultDate.getMonth()+1<10){
		month = '0'+String(resultDate.getMonth()+1);
	}
	else{
		month = String(resultDate.getMonth()+1);
	}	if(resultDate.getDate()<10){
		date = '0'+String(resultDate.getDate());
	}
	else{
		date = String(resultDate.getDate());
	}

	return dateFormat.replace("yyyy", year)  + dateSeparater +
	       dateFormat.replace("MM", month)  + dateSeparater +
	       dateFormat.replace("dd", date);

}

/**
 * 현재일에서 value일만큼 뒤의 날짜를 구해 리턴한다
 * @param value, 몇일뒤
 * @returns 'YYYY/MM/DD' 현재일에서 value일만큼 뒤의 날짜
 */
function util_addDateBySep(value, sep){

	var currentDate = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
			            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));

	var resultTimeMil = currentDate.getTime()+(Number(value)*24*3600*1000);
	var resultDate = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) - 1, Number(systimeStr.substring(6,8)),
            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));
	resultDate.setTime(resultTimeMil);

	var year = String(resultDate.getFullYear());
	var month;
	var date;

	if(resultDate.getMonth()+1<10){
		month = '0'+String(resultDate.getMonth()+1);
	}
	else{
		month = String(resultDate.getMonth()+1);
	}	if(resultDate.getDate()<10){
		date = '0'+String(resultDate.getDate());
	}
	else{
		date = String(resultDate.getDate());
	}

	var resultDateStr = year + sep + month + sep +date;


	return resultDateStr;
}

/**
 * 윤년확인 :: Check the Leap Year
 * @param year, 년도
 * @returns 윤년(2월>29일) : true , 평년(2월>28일) : false
 */
function util_ckLeapYear(year){

	return(((year % 4 === 0) && (year%100!==0)) || (year % 400 === 0));

}

/**
 * 월별날짜 :: Days each Month
 * @param year:년도, month: '해당 달 -1'
 * @returns 년도와 달에 따른 한달 일수
 */
function util_getDaysInMonth(year, month){


	return[31,
	       util_ckLeapYear(year)?29:28,
	       31,
	       30,
	       31,
	       30,
	       31,
	       31,
	       30,
	       31,
	       30,
	       31]
	[month];

}

/**
 * 달(month) 더하기 :: Add months
 * @author MinSung.park
 * @param year:년도, month: '해당 달 -1'
 * @returns 년도와 달에 따른 한달 일수
 */

function util_addMonths(value){

		// 현재날짜 date2
		var date2 = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) , Number(systimeStr.substring(6,8)),
	            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));

		// 현재 month + 구하고자 하는 달 (+- month) n=-1
		var n = Number(systimeStr.substring(4,6))  + Number(value);

		var aMonth = 0;

		// Add Month(s)
		if(value >= 0){

			/** Add Year(a), Add Month(b) */
			var a = Math.floor(n/12);
			var b = n%12; //단, b=0이면 무조건 12월달
			if( b == 0){a = a -1;}

		}

		// Minus Months(s) 현재날짜에서 이전날짜를 구하는 경우
		if(value < 0){
			/** a년 전,  */
			if (n > 0){
				var a = 0; //년도의 변화가 없을 경우
				var b = value; //b=-1

			}else if(n <= 0){
				var a = -1 -  Math.floor(Math.abs(n)/12);
				var b = 0 - Math.abs(n)%12;


			}

		} //년도의 변화가 있는 경우



		// 해당년도를 벗어나는 몇달 전의 날짜를 구한다. n=11, value=-1
		if(n <= 0 && value < 0){
			if(b == 0){aMonth = 12;}
			else {aMonth = 13 - Number(systimeStr.substring(4,6)) + b;}

		}else{

			// 몇달 후를 구하거나, or 해당년도를 벗어나지 않는 몇달 전의 날짜를 구한다.
			if(b == 0){
				aMonth = 12;
			}
			else if(value < 0){
				aMonth = Number(systimeStr.substring(4,6)) + b;

				if (aMonth == 0){aMonth = 12;}
			}else {
				aMonth = b ;
			}
		}
		var date = new Date(Number(systimeStr.substring(0,4))+a, aMonth , Number(systimeStr.substring(6,8)),
		         Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));
		var today = dateFormat;

		//Year
		today = today.replace("yyyy", Number(systimeStr.substring(0,4)) + a);

		//Month
			if(aMonth + 1 > 10){
				today = today.replace("MM", aMonth);
			}

			if(aMonth + 1 <= 10){
				today = today.replace("MM", '0' + aMonth);

			}
		//Date

			if((util_getDaysInMonth(Number(systimeStr.substring(0,4)),  Number(systimeStr.substring(4,6))-1	) == Number(systimeStr.substring(6,8)) && util_getDaysInMonth(Number(systimeStr.substring(0,4)),  Number(systimeStr.substring(4,6))-1	) >= util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1) )
					|| ( Number(systimeStr.substring(6,8)) >= util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1)) ){
				today = today.replace("dd",  util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1) );

			}else{
				today = today.replace("dd",  systimeStr.substring(6,8) );

			}


    return today;
}

function util_getDateFormat(dateValue){

	return dateFormat.replace("yyyy", dateValue.substring(0,4)).replace("MM", dateValue.substring(4,6)).replace("dd", dateValue.substring(6,8));

}

/**
 * 달(month) 더하기( 기호 제거 ) :: Add months
 * @author MinSung.park
 * @modyfy HyungJinLee
 * @param year:년도, month: '해당 달 -1'
 * @returns 년도와 달에 따른 한달 일수
 */

function util_addMonthsMark(value){

		// 현재날짜 date2
		var date2 = new Date(Number(systimeStr.substring(0,4)), Number(systimeStr.substring(4,6)) , Number(systimeStr.substring(6,8)),
	            Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));

		// 현재 month + 구하고자 하는 달 (+- month) n=-1
		var n = Number(systimeStr.substring(4,6))  + Number(value);

		var aMonth = 0;

		// Add Month(s)
		if(value >= 0){

			/** Add Year(a), Add Month(b) */
			var a = Math.floor(n/12);
			var b = n%12; //단, b=0이면 무조건 12월달
			if( b == 0){a = a -1;}

		}

		// Minus Months(s) 현재날짜에서 이전날짜를 구하는 경우
		if(value < 0){
			/** a년 전,  */
			if (n > 0){
				var a = 0; //년도의 변화가 없을 경우
				var b = value; //b=-1

			}else if(n <= 0){
				var a = -1 -  Math.floor(Math.abs(n)/12);
				var b = 0 - Math.abs(n)%12;


			}

		} //년도의 변화가 있는 경우



		// 해당년도를 벗어나는 몇달 전의 날짜를 구한다. n=11, value=-1
		if(n <= 0 && value < 0){
			if(b == 0){aMonth = 12;}
			else {aMonth = 13 - Number(systimeStr.substring(4,6)) + b;}

		}else{

			// 몇달 후를 구하거나, or 해당년도를 벗어나지 않는 몇달 전의 날짜를 구한다.
			if(b == 0){
				aMonth = 12;
			}
			else if(value < 0){
				aMonth = Number(systimeStr.substring(4,6)) + b;

				if (aMonth == 0){aMonth = 12;}
			}else {
				aMonth = b ;
			}
		}
		var date = new Date(Number(systimeStr.substring(0,4))+a, aMonth , Number(systimeStr.substring(6,8)),
		         Number(systimeStr.substring(8,10)), Number(systimeStr.substring(10,12)), Number(systimeStr.substring(12,14)), Number(systimeStr.substring(14,17)));
		var today = "yyyyMMdd";

		//Year
		today = today.replace("yyyy", Number(systimeStr.substring(0,4)) + a);

		//Month
			if(aMonth + 1 > 10){
				today = today.replace("MM", aMonth);
			}

			if(aMonth + 1 <= 10){
				today = today.replace("MM", '0' + aMonth);

			}
		//Date

			if((util_getDaysInMonth(Number(systimeStr.substring(0,4)),  Number(systimeStr.substring(4,6))-1	) == Number(systimeStr.substring(6,8)) && util_getDaysInMonth(Number(systimeStr.substring(0,4)),  Number(systimeStr.substring(4,6))-1	) >= util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1) )
					|| ( Number(systimeStr.substring(6,8)) >= util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1)) ){
				today = today.replace("dd",  util_getDaysInMonth(Number(systimeStr.substring(0,4))+a,  aMonth-1) );

			}else{
				today = today.replace("dd",  systimeStr.substring(6,8) );

			}


    return today;
}

function util_getReverseDateFormat(dateStr){
	
	var year = dateStr.substring(dateFormat.indexOf("yyyy"), dateFormat.indexOf("yyyy") + 4);
	var month = dateStr.substring(dateFormat.indexOf("MM"), dateFormat.indexOf("MM") + 2);
	var day = dateStr.substring(dateFormat.indexOf("dd"), dateFormat.indexOf("dd") + 2);
	
	return year + month + day;

}
