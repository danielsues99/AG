
function GetCaptchaValue(){
    var c = document.getElementById("g-recaptcha-response");
    var m = document.getElementById("I_MAIL");

    if(c.value != null && m.value != ""){
        Recover();
    }else{
        alert("Rellene todos los campos!");
    }
}

function Recover(){
    var Id = document.getElementById("I_MAIL").value;

    let formData = new FormData();
        formData.append('Mail', Id);

    
    fetch("php/RecoveryKey.php?op=1",
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
                if(data.AR_Result.Result > 0){                    
                    alert("Clave actualizada correctamente.");
                    window.location.href = "Index.html";
                }else{
                    alert("No se actualizo la contraseña!");
                }
            }
        );
}