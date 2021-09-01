
function getOption() { 
    selectElement = document.querySelector('#mem_type');
    var x =  selectElement.options[selectElement.selectedIndex].value
    if(x == 's_pccoe')
    {
        document.getElementById("s_scholar").disabled = false;
        document.getElementById("s_scholar").required = true;
    }
    if(x == 's_other')
    {

        document.getElementById("s_scholar").disabled = true;
        document.getElementById("s_scholar").required = false;
        document.getElementById("s_scholar").value = "";
    }

} 

    var elements = document.cookie.split('login_cookies=');
    var cookie_token= elements[1];
    if(cookie_token === undefined || cookie_token === null || cookie_token.length<10){
    }
    else{
        window.location.href="profile.html";
    }
//Validation function for register

function Validation(){
    var mail = document.register.reg_email.value;
    var pass = document.register.reg_pass.value;
    var cpass = document.register.reg_cpass.value;
    var mobile = document.register.mobilenumber.value;
    var gend = document.register.gender.value;
    var check = document.register.mem_type.value;
    var atposition=mail.indexOf("@");  
    var dotposition=mail.lastIndexOf(".");  
    var mid = false;
    var pas = false;
    var cpas = false;
    var mob = false;
    var gen = false;
    var chec = false;
    //Account Type Validation
    if(check == "")
    {
        chec = false;
        document.getElementById("er6").style.display="block";
    }
    else{
        document.getElementById("er6").style.display = "none";
        chec = true;
        
    }
    //gender required field validation
    
    if (gend == "")
    {   
        gen = false;
        document.getElementById("er5").style.display = "block";
    }
    else{
        document.getElementById("er5").style.display = "none";
        gen = true;
    }
    
    //Phone no. validation
    if(mobile.length != 10)
    {
        document.getElementById("er4").style.display = "block";
        mob = false;
    }
    else
    {
        document.getElementById("er4").style.display = "none";
        mob = true;
    }
    //Email Validation
    if (atposition<1 || dotposition<atposition+2 || dotposition+2>=mail.length){  
      document.getElementById("er1").style.display = "block";
      mid = false;
      }
      else
      {
        document.getElementById("er1").style.display = "none";
        mid = true;
      }
    //confirm password validation
      if(cpass != pass){
        document.getElementById("er3").style.display = "block";
        cpas = false;
      }
      else
      {
         document.getElementById("er3").style.display = "none";
         cpas = true;
      }
    //password validation
        var minMaxLength = /^[\s\S]{8,32}$/,
            upper = /[A-Z]/,
            lower = /[a-z]/,
            number = /[0-9]/,
            special = /[ !"#$%&'()*+,\-./:;<=>?@[\\\]^_`{|}~]/;
    
        if (minMaxLength.test(pass) &&
            upper.test(pass) &&
            lower.test(pass) &&
            number.test(pass) &&
            special.test(pass)
        ) {
            document.getElementById("er2").style.display = "none";
            pas = true;
        }
        else
        {
            document.getElementById("er2").style.display = "block";
            pas = false;
        }
        if (mob == true && cpas == true && pas == true && mid == true && gen == true && chec == true){
            $valid = true;
            return true;
        }
        else
        {
            return false;
        }
    }
//register Handling
    $(document).ready(function(){
        $("#loading").hide();
        $("#r_submit").click(function(e){ e.preventDefault();
            if(Validation()===true){
             var reg_test=new FormData($('#register')[0]);
            $("#loading").show();
            $.ajax({
                     url: "http://pccoetnp.epizy.com/handler/user_handler/1",
                     headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
                      'Tnpbot' : 'null'},
                     data: new FormData($('#register')[0]),
                     crossDomain: true,
                     processData: false,
                     contentType: false,
                     timeout:30000,
                     type: "POST",
                     success: function(data)
                      {
                        $("#loading").hide();
                         // do something with response
                        if(data.status==="error"||data.status==="unsuccess"){
                               alert("Unknown error occur while processing request please try again.")
                           }
                        if(data.status==="d_o_b"){
                            alert("Date of birth is invalid.")
                        }   
                         if(data.status==="verification"){
                               alert("This email is already registered, please check your email for verification link.")
                           }
                        if(data.status==="pass1"){
                               alert("Password should be between 8 to 20 chars in length and should contain at least one number and one special character.")
                           }
                        if(data.status==="pass2"){
                               alert("Confirm Password does not match with password.")
                           }
                        if(data.status==="register"){
                               alert("This email ID or Scholar number is already registered, redirecting to login page")
                                window.location.href = "index.html";
                           }
                        if(data.status==="success"){
                               alert("Registration successful, a verification link will be send via email.")
                               document.getElementById("r_submit").disabled=true;
                           }
                        if(data.status==="db"){
                               alert("	Unable to connect database")
                           }
                        if(data.status==="tokenmiss"){
                               alert("	Token Expire, please login again ( Redirect to login page )")
                               window.location.href = "index.html";
                           }
                        if(data.status==="fields"){
                               alert("Please fill all the fields in proper format.")
                           }
                        
                     }
             });}
         })
        })
        password.onblur = function() {
            document.getElementById("er7").style.display="none";
        }
          password.onfocus = function() {
            document.getElementById("er7").style.display="block";
          }