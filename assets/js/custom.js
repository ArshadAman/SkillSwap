// Auth page js
function showLogin(){
    document.getElementById("login-btn").classList.add("btn-primary");
    document.getElementById("register-btn").classList.remove("btn-primary");
    document.getElementById("login-form").style.display = "block";
    document.getElementById("register-form").style.display = "none";
}

function showRegister(){
    document.getElementById("register-btn").classList.add("btn-primary");
    document.getElementById("login-btn").classList.remove("btn-primary");
    document.getElementById("login-form").style.display = "none";
    document.getElementById("register-form").style.display = "block";
}


// End of Auth page js