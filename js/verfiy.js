function check(){
    var password = document.getElementById('password');
    var confirm_password = document.getElementById('confirm_password');
    var error = document.getElementById('error');
        
    if(password.value!= confirm_password.value){
       confirm_password.style.borderBottomColor = "indianred";
       confirm_password.style.backgroundColor = "lightpink";
       confirm_password.setCustomValidity("**كلمة المرور غير متطابقة**");
       error.innerHTML ="**كلمة المرور غير متطابقة**";
       return false;
    }

    else if(password.value == confirm_password.value){
        confirm_password.setCustomValidity('');
    }

    else {
        return true;
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;


}





  
