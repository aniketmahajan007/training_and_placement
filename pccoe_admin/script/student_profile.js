function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return decodeURIComponent(sParameterName[1]);
        }
    }
}
jQuery(document).ready(function($){
    var tempid=GetURLParameter('uid');
    if(tempid<1||tempid===null||tempid===undefined){
        alert("Admin, please enter valid UID");
        return 0;
    }
    $("#student_uid").val(tempid);
    var this_form_has_info=new FormData($('#student_info_form')[0]);
    $.ajax({
        url: "http://pccoetnp.epizy.com/handler/admin_handler/3",
        headers: { 'Authority': '$2y$08$gFWXSf4TLya4YH1co4M6.uQRT1JUeTLednPmIwwWeIRwrpKwP2K2m' ,
            'Tnpbot' : cookie_token},
        data: this_form_has_info,
        crossDomain: true,
        processData: false,
        contentType: false,
        timeout:30000,
        type: "POST",
        success: function(data) {
            $("#loading").hide();
            if (isJson(data)) {
                data = JSON.parse(data);
            }
            //response handling for update profile
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
            document.getElementById("d_schno").innerHTML = data.sch_no;
            document.getElementById("d_pnrno").innerHTML = data.pnr_no;
            document.getElementById("d_rollno").innerHTML = data.rollno;
            document.getElementById("d_coursename").innerHTML = data.coursename;
            document.getElementById("d_fullname").innerHTML = data.full_name;
            document.getElementById("d_gender").innerHTML = data.gender;
            document.getElementById("d_clgname").innerHTML = data.clgname;
            document.getElementById("d_yearofcomplete").innerHTML = data.yearofcomplete;
            document.getElementById("d_mobileno").innerHTML = data.mobilenumber;
            document.getElementById("d_email").innerHTML = data.email;
            document.getElementById("d_fatheremail").innerHTML = data.father_email;
            document.getElementById("d_fathernumber").innerHTML = data.father_number;
            document.getElementById("d_profession").innerHTML = data.profession;
            document.getElementById("d_dateofbirth").innerHTML = data.dateofbirth;
            document.getElementById("d_peraddress").innerHTML = data.peraddress;
            document.getElementById("d_localaddress").innerHTML = data.localaddress;
            document.getElementById("d_district").innerHTML = data.district;
            document.getElementById("d_homedistrict").innerHTML = data.hdistrict;
            document.getElementById("d_state").innerHTML = data.state;
            $("#full_name").val(data.full_name);
            $("#rollno").val(data.rollno);
            $("#coursename").val(data.coursename);
            $("#company_name").val(data.company_name);
            $("#sch_no").val(data.sch_no);
            $("#pnr_no").val(data.pnr_no);
            $("#gender").val(data.gender);
            $("#clgname").val(data.clgname);
            $("#yearofcomplete").val(data.yearofcomplete);
            $("#mobilenumber").val(data.mobilenumber);
            $("#email").val(data.email);
            $("#father_email").val(data.father_email);
            $("#father_number").val(data.father_number);
            $("#profession").val(data.profession);
            $("#dateofbirth").val(data.dateofbirth);
            $("#localaddress").val(data.localaddress);
            $("#peraddress").val(data.peraddress);
            $("#district").val(data.district);
            $("#hdistrict").val(data.hdistrict);
            $("#state").val(data.state);
            $("#state").val(data.state);
            if(data.ssc>0){
                document.getElementById("d_sscper").innerHTML = data.ssc;
                $("#ssc").val(data.ssc);
            }
            if(data.sscyear>0){
                document.getElementById("d_ssc").innerHTML = data.sscboard +'|'+ data.sscyear;
                $("#sscyear").val(data.sscyear);
                $("#sscboard").val(data.sscboard);
            }
            if(data.hsc>0){
                document.getElementById("d_hscper").innerHTML = data.hsc;
                $("#hsc").val(data.hsc);
            }
            if(data.hscyear>0){
                document.getElementById("d_hsc").innerHTML = data.hscboard +'|'+ data.hscyear;
                $("#hscboard").val(data.hscboard);
                $("#hscyear").val(data.hscyear);
            }
            if(data.graduation>0){
                document.getElementById("d_gradmarks").innerHTML = data.graduation;
                $("#graduation").val(data.graduation);
            }
            if(data.gradyear>0){
                document.getElementById("d_grad").innerHTML = data.gradclg +'|'+ data.gradyear;
                $("#gradyear").val(data.gradyear);
                $("#gradclg").val(data.gradclg);
            }
            if(data.fysem1sgpa>0){
                document.getElementById("d_fysem1sgpa").innerHTML = data.fysem1sgpa;
                $("#fysem1sgpa").val(data.fysem1sgpa);
            }
            if(data.fysem1per>0){
                document.getElementById("d_fysem1per").innerHTML = data.fysem1per;
                $("#fysem1per").val(data.fysem1per);
            }
            if(data.fysem2sgpa>0){
                document.getElementById("d_fysem2sgpa").innerHTML = data.fysem2sgpa;
                $("#fysem2sgpa").val(data.fysem2sgpa);
            }
            if(data.fysem2per>0){
                document.getElementById("d_fysem2per").innerHTML = data.fysem2per;
                $("#fysem2per").val(data.fysem2per);
            }
            if(data.sysem1sgpa>0){
                document.getElementById("d_sysem1sgpa").innerHTML = data.sysem1sgpa;
                $("#sysem1sgpa").val(data.sysem1sgpa);
            }
            if(data.sysem1per>0){
                document.getElementById("d_sysem1per").innerHTML = data.sysem1per;
                $("#sysem1per").val(data.sysem1per);
            }
            if(data.sysem2sgpa>0){
                document.getElementById("d_sysem2sgpa").innerHTML = data.sysem2sgpa;
                $("#sysem2sgpa").val(data.sysem2sgpa);
            }
            if(data.sysem2per>0){
                document.getElementById("d_sysem2per").innerHTML = data.sysem2per;
                $("#sysem2per").val(data.sysem2per);
            }
            if(data.tysem1sgpa>0){
                document.getElementById("d_tysem1sgpa").innerHTML = data.tysem1sgpa;
                $("#tysem1sgpa").val(data.tysem1sgpa);
            }
            if(data.tysem1per>0){
                document.getElementById("d_tysem1per").innerHTML = data.tysem1per;
                $("#tysem1per").val(data.tysem1per);
            }
            if(data.tysem2sgpa>0){
                document.getElementById("d_tysem2sgpa").innerHTML = data.tysem2sgpa;
                $("#tysem2sgpa").val(data.tysem2sgpa);
            }
            if(data.tysem2per>0){
                document.getElementById("d_tysem2per").innerHTML = data.tysem2per;
                $("#tysem2per").val(data.tysem2per);
            }
            if(data.aggcgpa>0){
                document.getElementById("d_aggcgpa").innerHTML = data.aggcgpa;
                $("#aggcgpa").val(data.aggcgpa);
            }
            if(data.aggper>0){
                document.getElementById("d_aggper").innerHTML = data.aggper;
                $("#aggper").val(data.aggper);
            }
            if(data.livebacklog>0){
                document.getElementById("d_livebacklog").innerHTML = data.livebacklog;
                $("#livebacklog").val(data.livebacklog);
            }
            if(data.deadbacklog>0){
                document.getElementById("d_deadbacklog").innerHTML = data.deadbacklog;
                $("#deadbacklog").val(data.deadbacklog);
            }
            if(data.noofyd>0){
                document.getElementById("d_noofyd").innerHTML = data.noofyd;
                $("#noofyd").val(data.noofyd);
            }
            if(data.profile_avatar!==""){
                $("#user_profile_picture").attr('src',data.profile_avatar);
            }
            if(data.user_resume!==""){
                $("#d_userresume").attr('href',data.user_resume).text(data.user_resume);
                $("#resume_url_outer").text("Your resume: ");
                $("#resume_url_inner").html('<a href="'+data.user_resume+'" target="_blank">'+data.user_resume+'</a>');
            }
            if(data.company_name!==""){
                $("#company_name").val(data.company_name);
            }
        }
    });
});
