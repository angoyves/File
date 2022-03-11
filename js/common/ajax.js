var AutoComplete = {

        xmlHttp : null,

        /*
         * XMLHttp객체생성
         */
        getXMLHttpRequest: function() {

                //인터넷 익스플로러일 경우
                 if(window.ActiveXObject){

                          try{
                                   return new ActiveXObject("Msxml2.XMLHTTP");
                          }catch(e){

                                  try{
                                          return new ActiveXObject("Microsoft.XMLHTTP");
                                   }catch(e1){
                                           return null;
                                }

                        }

                }
                 //다른 브라우저일 경우
                else if(window.XMLHttpRequest){
                        return new XMLHttpRequest();
                 }
                //브라우저 식별 실패
                 else{
                         return null;
                }
        },

        /*
         * XMLHttp Request를 서버로
         */
        ContentLoader: function(url, execFunction) {

                 xmlHttp = this.getXMLHttpRequest();
                 xmlHttp.onreadystatechange = execFunction;
                 //xmlHttp.open("POST", url, true); // url의 주소를 GET방식으로 열 준비를 한다.
                 xmlHttp.open("POST", url, false); // url의 주소를 GET방식으로 열 준비를 한다. (동기)
                xmlHttp.send(); //서버에 전송한다.

        },

        /*
         * XMLHttp Response가 서버로 부터 온전한 상태로 왔는지 확인
         */
        getState: function() {

                if(xmlHttp.readyState == 4){ //데이터의 전부를 받은 상태

                        if(xmlHttp.status == 200){//요청 성공

                                   return true;

                          }else{

                                  return false;
                        }

                }

        }

}

