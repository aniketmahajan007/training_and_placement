var elements = document.cookie.split('login_cookies=');
var cookie_token= elements[1];
if(cookie_token === undefined || cookie_token === null || cookie_token.length<10){
}
else{
    window.location.href="http://pccoetnp.epizy.com/pccoe_admin/dashboard.html";
}

jQuery(document).ready(function($){
    $("#loading").hide();
    $("#admin_login_button").click(function (e){
        e.preventDefault();
        if($("#admin_login_email").val().length<6 || $("#admin_login_pass").val().length<5){
            alert("Please Enter Valid e-mail address and password");
            return 0;
        }
        $("#loading").show();
        $.ajax({
            url: "http://pccoetnp.epizy.com/handler/user_handler/3",
            headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
                'Tnpbot' : 'null'},
            data: new FormData($('#admin_login_form')[0]),
            crossDomain: true,
            processData: false,
            contentType: false,
            timeout:30000,
            type: "POST",
            success: function(data)
            {
                console.log(data);
                $("#loading").hide();
                //response handling for login
                if(data.status==="fields"){
                    alert("Please fill all the fields in proper format.")
                }
                if(data.status==="error" ||data.status==="unsuccess" ){
                    alert("An Unknown error occoured, please try again later.")
                }
                if(data.status==="passfail" || data.status==="email"){
                    alert("Email ID or Password Does not match.")
                }
                if(data.status==="success"){
                    document.cookie = 'login_cookies='+data.token;
                    document.getElementById("admin_login_button").disabled=true;
                    window.location.href = "http://pccoetnp.epizy.com/pccoe_admin/dashboard.html";
                }
            }
        });
    });
});
