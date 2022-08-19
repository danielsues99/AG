
GetUsersType();
setTimeout( LoadPage, 300 );

function GetUsersType(){
    //let formData = new FormData();
    //    formData.append('Mail', Id);
    //    formData.append('Password', Pass);

    
    fetch("../php/UserTypeAPI.php?op=2",
        {
            //body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){
                var Select = document.getElementById("SelectIdType");
                data.UsersType.forEach(function(TYP){
                    var content = document.createElement("option");
                    content.value = TYP.ID;
                    content.innerHTML = TYP.DESCRIPTION;

                    Select.append(content);
                    //console.log("USR: " + USR.FIRSTNAME);
                });
            }
        );
}

function LoadPage(){
    var id = sessionStorage.getItem("IdUser");
    if(id != "0"){
        SearchUser();
    }
}

function ModifyUser(){
    if(sessionStorage.getItem("IdUser")=="0"){
        AddUser();
    }else{
        UpdateUser();
    }
}

function ConfirmPass(){
    var FP = document.getElementById("8").value;
    var SP = document.getElementById("10").value;
    if(FP == SP){
        return true;
    }
    else{
        return false;
    }
}
function AddUser(){
    if(ConfirmPass() == true){
    var FIRSTNAME = document.getElementById("1").value;
    var SECONDNAME = document.getElementById("2").value;
    var MIDNAME = document.getElementById("3").value;
    var LASTNAME = document.getElementById("4").value;
    var NIT = document.getElementById("5").value;
    var PHONE = document.getElementById("6").value;
    var MAIL = document.getElementById("7").value;
    var PASSWORD = document.getElementById("8").value;
    var ID_TYPE = document.getElementById("SelectIdType").value;

    let formData = new FormData();
        formData.append('FIRSTNAME', FIRSTNAME);
        formData.append('SECONDNAME', SECONDNAME);
        if(MIDNAME != ""){
            formData.append('MIDNAME', MIDNAME);
        }
        formData.append('LASTNAME', LASTNAME);
        formData.append('NIT', NIT);
        formData.append('PHONE', PHONE);
        formData.append('MAIL', MAIL);
        formData.append('PASSWORD', PASSWORD);
        formData.append('ID_TYPE', ID_TYPE);

    
    fetch("../php/UserAPI.php?op=1",
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
                if(data.AR_Result.Result == "1"){
                    //alert(data.AR_Result.Response);
                    window.location.href = "UserManagement.html";
                }
                else{
                    alert("No se actualizo el usuario debido al siguiente error:\n " + data.AR_Result.Response);
                }
            }
        );
    }
    else{
        alert("Las contraseñas no coinciden");
    }
}
function SearchUser(){
    var ID = sessionStorage.getItem("IdUser");
    // alert(ID);
    let formData = new FormData();
        formData.append('ID', ID);

    
    fetch("../php/UserAPI.php?op=2",
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
                    //document.getElementById("0").value = USR.ID;
                    document.getElementById("1").value = USR.FIRSTNAME;
                    document.getElementById("2").value = USR.SECONDNAME;
                    document.getElementById("3").value = USR.MIDNAME;
                    document.getElementById("4").value = USR.LASTNAME;
                    document.getElementById("5").value = USR.NIT;
                    document.getElementById("6").value = USR.PHONE;
                    document.getElementById("7").value = USR.MAIL;
                    document.getElementById("SelectIdType").value = USR.ID_TYPE;
                });
            }
        );
}
function UpdateUser(){
    var ID = sessionStorage.getItem("IdUser");
    var FIRSTNAME = document.getElementById("1").value;
    var SECONDNAME = document.getElementById("2").value;
    var MIDNAME = document.getElementById("3").value;
    var LASTNAME = document.getElementById("4").value;
    var NIT = document.getElementById("5").value;
    var PHONE = document.getElementById("6").value;
    var MAIL = document.getElementById("7").value;
    var PASSWORD = document.getElementById("8").value;
    var ID_TYPE = document.getElementById("SelectIdType").value;

    if(PASSWORD != ""){
        if(ConfirmPass() == false){
            alert("Las contraseñas no coinciden");
            return;
        }
    }
   
    let formData = new FormData();
        if(FIRSTNAME != ""){
            formData.append('ID', ID);
        }
        if(FIRSTNAME != ""){
            formData.append('FIRSTNAME', FIRSTNAME);
        }
        if(SECONDNAME != ""){
            formData.append('SECONDNAME', SECONDNAME);
        }
        if(MIDNAME != ""){
            formData.append('MIDNAME', MIDNAME);
        }
        if(LASTNAME != ""){
            formData.append('LASTNAME', LASTNAME);
        }
        
        if(NIT != ""){
            formData.append('NIT', NIT);
        }
        
        if(PHONE != ""){
            formData.append('PHONE', PHONE);
        }
        
        if(MAIL != ""){
            formData.append('MAIL', MAIL);
        }
        
        if(PASSWORD != ""){
            formData.append('PASSWORD', PASSWORD);
        }
        
        if(ID_TYPE != ""){
            formData.append('ID_TYPE', ID_TYPE);
        }

    
    fetch("../php/UserAPI.php?op=3",
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
                if(data.AR_Result.Result == "1"){
                    //alert(data.AR_Result.Response);
                    window.location.href = "UserManagement.html";
                }
                else{
                    alert("No se actualizo el usuario debido al siguiente error:\n " + data.AR_Result.Response);
                }
            }
        );
}
