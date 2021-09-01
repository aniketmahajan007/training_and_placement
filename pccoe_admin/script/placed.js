function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}
var cookie_token= getCookie("login_cookies");
jQuery(document).ready(function($){
   $("#update_placed_status_update").click(function (){
       $("#loading").show();
       var this_form_has_login_device=new FormData($('#update_placed_form')[0]);
       $.ajax({
           url: "http://pccoetnp.epizy.com/handler/admin_handler/4",
           headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
               'Tnpbot' : cookie_token},
           data: this_form_has_login_device,
           crossDomain: true,
           processData: false,
           contentType: false,
           timeout:30000,
           type: "POST",
           success: function(data) {
               console.log(data);
               $("#loading").hide();
               if (isJson(data)) {
                   data = JSON.parse(data);
               }
               if (data.status === "db") {
                   alert("Unable to connect database");
                   window.location.href = "http://pccoetnp.epizy.com/";
                   return 0;
               }
               if (data.status === "tokenmiss") {
                   alert("Token Expire, please login again");
                   document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                   window.location.href = "http://pccoetnp.epizy.com/";
                   return 0;
               }
               if(data.status==="n_exist"){
                   alert("Admin, please enter valid UID");
                   return 0;
               }
               if (data.status === "error") {
                   alert("An unknown error offoured, please try again later.");
                   window.location.href = "http://pccoetnp.epizy.com/";
                   return 0;
               }
               if(data.status==="success"){
                   alert("Placed Status Successfully Updated.");
                   $('#update_placed_form').trigger("reset");
                   return 0;
               }
               if(data.status==="privileges"){
                   alert("You do not have privileges to access this content");
                   document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                   window.location.href="http://pccoetnp.epizy.com/pccoe_admin/";
                   return 0;
               }else if(data.status==="fields"){
                   alert("Please fill all the required details");
               }
           }
       });
   }) ;
});
