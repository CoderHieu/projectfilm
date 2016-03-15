function checkregister()
{
    if(document.getElementById("id_role").value=="")
    {
        document.getElementById("error_form").style.display = "block";
        document.getElementById("id_role").focus();
        return false;
    } 
    else if(document.getElementById("username").value=="")
    {
        document.getElementById("error_username").style.display = "block";
        document.getElementById("username").focus();
        return false;
    }
    else if(document.getElementById("password").value=="")
    {
        document.getElementById("error_pass").style.display = "block";
        document.getElementById("password").focus();
        return false;
    }
    else if(document.getElementById("repassword").value=="")
    {
        document.getElementById("error_repass").style.display = "block";
        document.getElementById("repassword").focus();
        return false;
    }
    else if(document.getElementById("password").value!=document.getElementById("repassword").value)
    {
        document.getElementById("error_chkpass").style.display = "block";
        document.getElementById("repassword").focus();
        return false;
    }
    else if(document.getElementById("email").value=='')
    {
        document.getElementById("error_email").style.display = "block";
        document.getElementById("email").focus();
        return false;
    }
    else{
        var str=document.getElementById("email").value;
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if(filter.test(str)){
            return true;
        }else{
            document.getElementById("error_chkemail").style.display = "block";
            document.getElementById("email").focus();
            return false;
        }
    }
}
