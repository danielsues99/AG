lsProducts = [];

function AddProduct(){
    var Category = document.getElementById("1");
    var Type = document.getElementById("2");
    var Location = document.getElementById("3");
    var Serial = document.getElementById("4");

    if(Type.value == "0" || Location.value == "0" || Serial.value.trim() == ""){
        alert("Por favor rellene todos los campos necesarios (*).");
    }else{
        var itemProduct = [Serial.value,1,Type.value,Location.value];
        lsProducts.push(itemProduct);
        console.log(lsProducts);
        AddItemToTable(Category.options[Category.selectedIndex].innerText, Type.options[Type.selectedIndex].innerText, Location.options[Location.selectedIndex].innerText, Serial.value);
        Serial.value = "";
        Serial.innerHTML = "";

    }

}

function AddItemToTable(_Category,_Type,_Location,_Serial){
    console.log("ADD: "+_Category+ "*" +_Type+ "*" +_Location+ "*" +_Serial+ "*" );


    var tableUsr = document.getElementById("TblProducts");
                    var content = document.createElement("tr");
                    var column2 = document.createElement("td");
                    var column3 = document.createElement("td");
                    var column4 = document.createElement("td");
                    var column5 = document.createElement("td");

                    var column02 = document.createElement("p");
                    var column03 = document.createElement("p");
                    var column04 = document.createElement("p");
                    var column05 = document.createElement("p");

                    var ImgD = document.createElement("img");
                    ImgD.src = "../resources/Delete_White.png";
                    ImgD.classList.add("imgTable");

                    column02.innerHTML = _Category;
                    column03.innerHTML = _Type;
                    column04.innerHTML = _Location;
                    column05.innerHTML = _Serial;

                    column2.append(column02);
                    column3.append(column03);
                    column4.append(column04);
                    column5.append(column05);
                    content.append(column2);
                    content.append(column3);
                    content.append(column4);
                    content.append(column5);
                    tableUsr.append(content);
}

function FinishBuy(){
    if(lsProducts.length > 0){
        lsProducts.forEach(function(Element){            
            console.log("SERIAL:" + Element[0]+ "º TIPO:" + Element[2]);

            let formData = new FormData();
            formData.append('SERIAL', Element[0]);
            formData.append('ID_TYPE_STATUS', 1);
            formData.append('ID_TYPE', Element[2]);
            formData.append('ID_LOCATION', Element[3]);

            fetch("../php/ProductAPI.php?op=1",
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
                        console.log("Registro exitoso.");   
                    }
                    else{
                        console.log("Registro fallido!");        
                        alert("No fue posible registrar la categoria debido al siguiente error:\n " + data.AR_Result.Response);
                    }
                }
            );
        });
        alert("Venta registrada con exito.");
                          
        location.reload();
    }
}

function AddProductCategory(){
    var CategoryName = document.getElementById("C1").value;

    if(CategoryName.trim() != "" ){
        let formData = new FormData();
        formData.append('DESCRIPTION', CategoryName);

        fetch("../php/ProductCategoryAPI.php?op=1",
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
                    fillCategory();
                    ViewCloseCategoryForm();
                    
                    // Rellenar cbox nuevamente
                }
                else{
                    alert("No fue posible registrar la categoria debido al siguiente error:\n " + data.AR_Result.Response);
                }
            }
        );
    }else{
        alert("Por favor rellene todos los campos necesarios (*).");
    }

}

function fillCategory(){
    var x = document.getElementById("1");
    x.length = 0;
    x.innerHTML = "";
    fetch("../php/ProductCategoryAPI.php?op=2",
        {
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){                
                data.ProductsCategory.forEach(function(PROD){
                    x.add(new Option(PROD.DESCRIPTION,PROD.ID));
                });
                fillType();
            }
        );
}



function ViewAddCategoryForm(){
    var x = document.getElementById("CategoryForm");
    x.style.visibility = "visible";
}

function ViewCloseCategoryForm(){
    var x = document.getElementById("CategoryForm");
    x.style.visibility = "hidden";
}







// PRODUCT TYPE


function AddProductType(){
    var CategoryType = document.getElementById("C2").value;
    var TypePrice = document.getElementById("C3").value;
    var IDC = document.getElementById("1").value;

    if(CategoryType.trim() != "" ){
        let formData = new FormData();
        formData.append('DESCRIPTION', CategoryType);
        formData.append('PRICE', TypePrice);
        formData.append('ID_CATEGORY', IDC);

        fetch("../php/ProductTypeAPI.php?op=1",
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
                    fillType();
                    ViewCloseTypeForm();
                    
                    // Rellenar cbox nuevamente
                }
                else{
                    alert("No fue posible registrar el tipo debido al siguiente error:\n " + data.AR_Result.Response);
                }
            }
        );
    }else{
        alert("Por favor rellene todos los campos necesarios (*).");
    }

}

function fillType(){
    var x = document.getElementById("2");
    var IDC = document.getElementById("1").value;

    let formData = new FormData();
    formData.append('ID_CATEGORY', IDC);



    x.length = 0;
    x.innerHTML = "";
    fetch("../php/ProductTypeAPI.php?op=2",
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
                data.ProductsType.forEach(function(PROD){
                    x.add(new Option(PROD.DESCRIPTION,PROD.ID));
                });
            }
        );
}


function ViewAddTypeForm(){
    var x = document.getElementById("TypeForm");
    x.style.visibility = "visible";
}

function ViewCloseTypeForm(){
    var x = document.getElementById("TypeForm");
    x.style.visibility = "hidden";
}


// location

function fillLocation(){
    var x = document.getElementById("3");
    x.length = 0;
    x.innerHTML = "";
    fetch("../php/LocationAPI.php?op=2",
        {
            method: "post"
        })
        .then(function (result) {
            if (result.ok) {
                return result.json();
            }
        }).then(
            function(data){                
                data.Locations.forEach(function(PROD){
                    x.add(new Option(PROD.DESCRIPTION,PROD.ID));
                });
            }
        );
}