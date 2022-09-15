GetProductsList();
function GetProductsList(){
    
    fetch("../php/ProductAPI.php?op=2",
        {
            //body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(datos){
                var tableProduct = document.getElementById("TblProductsC");
                datos.Products.forEach(function(PRODUCT){
                    var contenido = document.createElement("tr");
                    var columna01 = document.createElement("td");
                    var columna02 = document.createElement("td");
                    var columna1 = document.createElement("td");
                    var columna2 = document.createElement("td");
                    var columna3 = document.createElement("td");
                    var columna4 = document.createElement("td");
                    var columna5 = document.createElement("td");
                    var columnaS01 = document.createElement("p");
                    var columnaS02 = document.createElement("p");
                    var columnaS1 = document.createElement("p");
                    var columnaS2 = document.createElement("p");
                    var columnaS3 = document.createElement("p");
                    var columnaS4 = document.createElement("p");
                    var columnaS5 = document.createElement("p");

                    var Img = document.createElement("img");
                    Img.src = "../resources/Pencil_White.png";
                    Img.classList.add("imgTable");
                    var ImgD = document.createElement("img");
                    ImgD.src = "../resources/Delete_White.png";
                    ImgD.classList.add("imgTable");

                    columnaS1.innerHTML = PRODUCT.SERIAL;
                    columnaS2.innerHTML = PRODUCT.ID_TYPE_STATUS;
                    columnaS3.innerHTML = PRODUCT.ID_TYPE;
                    columnaS4.innerHTML = PRODUCT.ID_LOCATION;
                    columnaS5.innerHTML = PRODUCT.ID;
                    
                    columnaS01.addEventListener("click", (evt) => EditProduct(PRODUCT.ID));
                    columnaS01.append(Img);                    
                    columnaS01.innerHTML += "Editar";
                    columna01.append(columnaS01);

                    columnaS02.addEventListener("click", (evt) => DeleteProduct(PRODUCT.ID));
                    columnaS02.append(ImgD);
                    columnaS02.innerHTML += "Eliminar";
                    columna02.append(columnaS02);

                    
                    columna01.classList.add("Box_Type1");
                    columna01.classList.add("bgBlue");

                      
                    columna02.classList.add("Box_Type1");
                    columna02.classList.add("bgRed");

                    columna1.append(columnaS1);
                    columna2.append(columnaS2);
                    columna3.append(columnaS3);
                    columna4.append(columnaS4);
                    columna5.append(columnaS5);

                    contenido.append(columna01);
                    contenido.append(columna02);
                    contenido.append(columna1);
                    contenido.append(columna2);
                    contenido.append(columna3);
                    contenido.append(columna4);
                    contenido.append(columna5);
                    tableProduct.append(contenido);
                });
            }
        );
}

function EditProduct(id){
    sessionStorage.setItem("idProduct", id);
    window.location.href = "ProductForm.html";
    console.log("Hola", id);
}

function DeleteProduct(id){
    let formData = new FormData();
        formData.append('ID', id);

    
    fetch("../php/ProductAPI.php?op=4",
        {
            body: formData,
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(datos){
                if(datos.AR_Result.Result == "1"){
                    location.reload();
                }
                else{
                    alert("No se actualizo el producto debido al siguiente error:\n " + datos.AR_Result.Response);
                }
            }
        );
}