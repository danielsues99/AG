GetProductTypeList();
function GetProductTypeList(){
    
    fetch("../php/ProductTypeAPI.php?op=2",
        {
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){
                var tableProductType = document.getElementById("TblProductsType");
                data.ProductsType.forEach(function(PRODTYPE){
                    var content = document.createElement("tr");
                    var column01 = document.createElement("td");
                    var column02 = document.createElement("td");
                    var column1 = document.createElement("td");
                    var column2 = document.createElement("td");
                    var column3 = document.createElement("td");
                    var columnS01 = document.createElement("p");
                    var columnS02 = document.createElement("p");
                    var columnS1 = document.createElement("p");
                    var columnS2 = document.createElement("p");
                    var columnS3 = document.createElement("p");

                    var Img = document.createElement("img");
                    Img.src = "../resources/Pencil_White.png";
                    Img.classList.add("imgTable");
                    var ImgD = document.createElement("img");
                    ImgD.src = "../resources/Delete_White.png";
                    ImgD.classList.add("imgTable");

                    columnS1.innerHTML = PRODTYPE.DESCRIPTION;
                    columnS2.innerHTML = PRODTYPE.PRICE;
                    columnS3.innerHTML = PRODTYPE.ID_CATEGORY;
                    
                    columnS01.addEventListener("click", (evt) => EditProductType(PRODTYPE.ID));
                    columnS01.append(Img);                    
                    columnS01.innerHTML += "Editar";
                    column01.append(columnS01);

                    columnS02.addEventListener("click", (evt) => DeleteProductType(PRODTYPE.ID));
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

                    content.append(column01);
                    content.append(column02);
                    content.append(column1);
                    content.append(column2);
                    content.append(column3);
                    tableProductType.append(content);
                });
            }
        );
}

function EditProductType(id){
    sessionStorage.setItem("idProductType", id);
    window.location.href = "ProductTypeForm.html";
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