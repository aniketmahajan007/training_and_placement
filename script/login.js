function getOption() { 
    selectElement = document.querySelector('#mem_type');
    var x =  selectElement.options[selectElement.selectedIndex].value
    if(x == 's_pccoe')
    {
        document.getElementById("s_scholar").disabled = false;
        document.getElementById("s_scholar").required = true;
        document.getElementById("s_scholar").value = "";
        document.getElementById("email_address").required = false;
        document.getElementById("email_address").disabled = true;
        document.getElementById("email_address").value = " ";

        
    }
    if(x == 's_other')
    {

        document.getElementById("s_scholar").disabled = true;
        document.getElementById("s_scholar").required = false;
        document.getElementById("s_scholar").value = " ";
        document.getElementById("email_address").required = true;
        document.getElementById("email_address").disabled = false;
        document.getElementById("email_address").value = "";
    }

} 

    var elements = document.cookie.split('login_cookies=');
    var cookie_token= elements[1];
    if(cookie_token === undefined || cookie_token === null || cookie_token.length<10){
    }
    else{
        window.location.href="profile.html";
    }
function validate(){
    var check = document.login.mem_type.value;
    if(check == "")
    {
        alert("Please Select Login Type");
        return false;
    }
    if($("#password").val()===""){
        alert("Please Fill all the fields");
        return false;
    }
    return true;
}
// Login Handling
$(document).ready(function(){
    $("#loading").hide();
    $("#l_submit").click(function(e){ e.preventDefault();
        if(validate()){
            var login_test=new FormData($('#login')[0]);
        $("#loading").show();
        $.ajax({
                 url: "http://pccoetnp.epizy.com/handler/user_handler/2",
                 headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
                  'Tnpbot' : 'null'},
                 data: new FormData($('#login')[0]),
                 crossDomain: true,
                 processData: false,
                 contentType: false,
                 timeout:30000,
                 type: "POST",
                 success: function(data)
                  {
                     $("#loading").hide();
                     //response handling for login
                     if(data.status==="fields"){
                        alert("Please fill all the fields in proper format.")
                    }else if(data.status==="error" ||data.status==="unsuccess" ) {
                         alert("An Unknown error occoured, please try again later.")
                     }else if(data.status==="passfail"){
                        alert("Email ID or Password Does not match.")
                    }else if(data.status==="notregister"){
                        alert("The Email ID or Scholar number is not registered yet.")
                    }else if(data.status==="success"){
                        document.cookie = 'login_cookies='+data.token;
                        document.getElementById("l_submit").disabled=true;
                         window.location.href = "profile.html";
                    }
                 }
         });
        }
     });
})
