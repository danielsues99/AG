function LogIn(){
    var Id = document.getElementById("I_MAIL").value;
    var Pass = document.getElementById("I_PWD").value;

    console.log(Id);
    console.log(Pass);

    let formData = new FormData();
        formData.append('Mail', Id);
        formData.append('Password', Pass);

    
    fetch("php/LoginAPI.php?op=1",
        {
            body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){
                if(data.AR_Result.IdUser > 0){
                    console.log("Inicio de sesion correcto.");
                    sessionStorage.setItem("IdUser_Logged", data.AR_Result.IdUser);
                    sessionStorage.setItem("IsLogged", "1");
                    
                    console.log(sessionStorage.getItem("IdUser_Logged"));
                    console.log(sessionStorage.getItem("IsLogged"));
                    
                    SearchUser();
                }else{
                    alert("No se inicio la sesion porque los datos no se encuentran.");
                }
            }
        );
}

function SearchUser(){
    var ID = sessionStorage.getItem("IdUser_Logged");
    // alert(ID);
    let formData = new FormData();
        formData.append('ID', ID);

    
    fetch("php/UserAPI.php?op=2",
        {
            body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){
                data.Users.forEach(function(USR){
                    var Names_Logged = USR.FIRSTNAME + " " + USR.SECONDNAME;
                    sessionStorage.setItem("User_Logged", Names_Logged);
                    sessionStorage.setItem("IdUserType_Logged", USR.ID_TYPE);
                    console.log(sessionStorage.getItem("User_Logged"));
                    console.log(sessionStorage.getItem("IdUserType_Logged"));
                    SearchUserType();
                });
            }
        );
}

function SearchUserType(){
    var ID = sessionStorage.getItem("IdUserType_Logged");
    // alert(ID);
    let formData = new FormData();
        formData.append('ID', ID);

    
    fetch("php/UserTypeAPI.php?op=2",
        {
            body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){
                data.UsersType.forEach(function(USRTYP){
                    sessionStorage.setItem("UserType_Logged", USRTYP.DESCRIPTION);
                    console.log(sessionStorage.getItem("UserType_Logged"));
                    
                    window.location.href = "views/dashboard.html";
                });
            }
        );
}