function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
//logout
var elements = document.cookie.split('login_cookies=');
var cookie_token= elements[1];
$(document).ready(function(){
    
              $("#logoutbutton").click(function(e){ e.preventDefault();
                $.ajax({
                         url: "http://pccoetnp.epizy.com/handler/sync_manager/1",
                   headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
                          'Tnpbot' : cookie_token},
                    type: "POST",
                    data:new FormData($('#logout')[0]),
                    crossDomain: true,
                    processData: false,
                    contentType: false,
                    timeout:30000,
                    success: function(data)
                     {
                        if(isJson(data)){
                            data=JSON.parse(data);
                        }
                        //response handling for logout
                        if(data.status==="db"){
                               alert("Unable to connect database")
                        }
                        else if(data.status==="tokenmiss"){
                               alert("Token Expire, please login again");
                               document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                               window.location.href = "http://pccoetnp.epizy.com/";
                        }
                        else if(data.status==="fields"){
                           alert("Logged in fields are invalid.")
                            }
                        else if(data.status==="error"||data.status==="unsuccess"){
                           alert("An unknown error occoured while processing your request, please try again.")
                            }
                        else if(data.status==="success"){
                        document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        window.location.href = "http://pccoetnp.epizy.com/";
                        }

                     }
                 });
             })
            })
