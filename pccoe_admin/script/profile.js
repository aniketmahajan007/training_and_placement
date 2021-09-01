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
if(cookie_token === undefined || cookie_token === null || cookie_token.length<10){
    window.location.href="http://pccoetnp.epizy.com/pccoe_admin/";
}
console.log(cookie_token);
jQuery(document).ready(function($){
    var this_form_has_login_device=new FormData($('#admin_logout')[0]);
    $.ajax({
        url: "http://pccoetnp.epizy.com/handler/admin_handler/1",
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
            if(data.status!=="admin"){
                alert("You do not have privileges to access this content");
                document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                window.location.href="http://pccoetnp.epizy.com/pccoe_admin/";
                return 0;
            }
            $("#dashboard_h1").text("Welcome, Admin");
            $.ajax({
                url: "http://pccoetnp.epizy.com/handler/admin_handler/2",
                headers: {
                    'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m',
                    'Tnpbot': cookie_token
                },
                data: this_form_has_login_device,
                crossDomain: true,
                processData: false,
                contentType: false,
                timeout: 30000,
                type: "POST",
                success: function (data) {
                    $("#loading").hide();
                    if (isJson(data)) {
                        data = JSON.parse(data);
                    }
                    if (data.status === "privileges") {
                        alert("You do not have privileges to access this content");
                        document.cookie = 'login_cookies=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        window.location.href = "http://pccoetnp.epizy.com/pccoe_admin/";
                        return 0;
                    }
                    $("#dashboard_h1").text("Welcome, Admin");
                    data.forEach((value)=>{
                        if(value.u_name===""){
                            value.u_name='Not Added';
                        }
                        if(value.mob_number===""){
                            value.mob_number="Not Added";
                        }
                        if(value.p_status==0){
                            value.p_status="Not Placed";
                        }else{
                            value.p_status="Placed";
                        }
                        if(value.resume_url===""){
                            value.resume_url="Not Added";
                        }
                        $("#dash_student_info").append(`<tr>
    <td>${value.Uid}</td>
    <td>${value.u_name}</td>
    <td>${value.mob_number}</td>
    <td>${value.user_email}</td>
    <td>${value.p_status}</td>
    <td><a href="${value.resume_url}" target="_blank">${value.resume_url}</a></td>
    <td><a style="color:blue"  href="http://pccoetnp.epizy.com/pccoe_admin/student_profile.html?uid=${value.Uid}" target="_blank">Show All Data</a></td>
  </tr>`);
                    });
                }
            });
        }
    });
});
