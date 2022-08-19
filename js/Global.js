setTimeout( SetLabels, 100 );



function SetLabels(){

    var lblUser = document.getElementById("lbl_User");
    var lblUserType = document.getElementById("lbl_TypeUser");

    var x = sessionStorage.getItem("User_Logged");
    var y = sessionStorage.getItem("UserType_Logged");

    lblUser.innerText = x;
    lblUserType.innerText = y;
}

function IsLogged(){
    return sessionStorage.getItem("IsLogged");
}

function LogOut(){
    sessionStorage.setItem("IsLogged","0");
}

function ValidateSession(){
    if(IsLogged() == null || IsLogged() == "0"){
        window.location.href = "../Index.html";
    }
}

