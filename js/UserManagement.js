GetUsersList();
function GetUsersList(){
    
    fetch("../php/UserAPI.php?op=2",
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
                var tableUsr = document.getElementById("TblUsers");
                data.Users.forEach(function(USR){
                    var content = document.createElement("tr");
                    var column01 = document.createElement("td");
                    var column02 = document.createElement("td");
                    var column1 = document.createElement("td");
                    var column2 = document.createElement("td");
                    var column3 = document.createElement("td");
                    var column4 = document.createElement("td");
                    var column5 = document.createElement("td");
                    var column6 = document.createElement("td");
                    var column7 = document.createElement("td");
                    var column8 = document.createElement("td");
                    var columnS01 = document.createElement("p");
                    var columnS02 = document.createElement("p");
                    var columnS1 = document.createElement("p");
                    var columnS2 = document.createElement("p");
                    var columnS3 = document.createElement("p");
                    var columnS4 = document.createElement("p");
                    var columnS5 = document.createElement("p");
                    var columnS6 = document.createElement("p");
                    var columnS7 = document.createElement("p");
                    var columnS8 = document.createElement("p");

                    var Img = document.createElement("img");
                    Img.src = "../resources/Pencil_White.png";
                    Img.classList.add("imgTable");
                    var ImgD = document.createElement("img");
                    ImgD.src = "../resources/Delete_White.png";
                    ImgD.classList.add("imgTable");

                    columnS1.innerHTML = USR.FIRSTNAME;
                    columnS2.innerHTML = USR.SECONDNAME;
                    columnS3.innerHTML = USR.MIDNAME;
                    columnS4.innerHTML = USR.LASTNAME;
                    columnS5.innerHTML = USR.NIT;
                    columnS6.innerHTML = USR.PHONE;
                    columnS7.innerHTML = USR.MAIL;
                    columnS8.innerHTML = USR.ID_TYPE;
                    
                    columnS01.addEventListener("click", (evt) => EditUser(USR.ID));
                    columnS01.append(Img);                    
                    columnS01.innerHTML += "Editar";
                    column01.append(columnS01);

                    columnS02.addEventListener("click", (evt) => DeleteUser(USR.ID));
                    columnS02.append(ImgD);
                    columnS02.innerHTML += "Eliminar";
                    column02.append(columnS02);

                    
                    column01.classList.add("Box_Type1");
                    column01.classList.add("bgBlue");

                      
                    column02.classList.add("Box_Type1");
                    column02.classList.add("bgRed");

                    column1.append(columnS1);
                    column2.append(columnS2);
                    column3.append(columnS3);
                    column4.append(columnS4);
                    column5.append(columnS5);
                    column6.append(columnS6);
                    column7.append(columnS7);
                    column8.append(columnS8);

                    content.append(column01);
                    content.append(column02);
                    content.append(column1);
                    content.append(column2);
                    content.append(column3);
                    content.append(column4);
                    content.append(column5);
                    content.append(column6);
                    content.append(column7);
                    content.append(column8);
                    tableUsr.append(content);
                    //console.log("USR: " + USR.FIRSTNAME);
                });
            }
        );
}

function EditUser(id){
    sessionStorage.setItem("IdUser", id);
    window.location.href = "UserForm.html";
}

function DeleteUser(id){
    let formData = new FormData();
        formData.append('ID', id);

    
    fetch("../php/UserAPI.php?op=4",
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
                    location.reload();
                }
                else{
                    alert("No se actualizo el usuario debido al siguiente error:\n " + data.AR_Result.Response);
                }
            }
        );
}