<?php
 
 require_once("Connection.php");

 // Inicio de sesion -> 1
 if($_GET["op"] == 1){
    Recovery();
 }
 
 function Recovery() {
    $Mail = strtoupper($_POST['Mail']);
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $PWD = substr(str_shuffle($permitted_chars), 0, 10);
    $PWDE = hash('sha256', $PWD);
      
      $sCmd = "UPDATE user SET PASSWORD = '".$PWDE."' WHERE UPPER(MAIL) = '".$Mail."' ";
      
      $enlace = conectar();
      if ($enlace->query($sCmd) === TRUE) {
         if(mail($Mail,"Restauracion de contraseña - AR","Su nueva clave es: ".$PWD,"AGILITY REPORT")){
            echo json_encode(array('AR_Result' => array('Response' => $PWD, 'Result' => '1')));
         }else{            
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se pudo enviar correo en la funcion.', 'Result' => '0')));
         }

      } else {
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
      }
 }

?>