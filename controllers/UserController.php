<?php

require '../config/MsSqlConnection.php';
$db = new MsSQLConnection();
$con -> $db->OpenConnection();

// Inicio de sesion -> 1
if($_GET["op"] == 1){
    Login();
 }
 
 function Login() {
      $Mail = strtoupper($_POST['Mail']);
      $PWD = hash('sha256', $_POST['Password']);
      
      $query = $con->prepare("SELECT ID AS CUENTA FROM user WHERE UPPER(MAIL) = :email AND PASSWORD = :pass ");
      $query->execute(['email'=>$Mail,'pass'=>$PWD]);
      //$result = $query->fetch(PDO::FETCH_ASSOC);
      $result = $query->fetchColumn();

      //echo $consulta;
      //$stmt = $enlace->prepare($consulta);
      //$stmt->bind_param("ss", $Mail, $PWD);
      //$stmt->execute();
      
      //$stmt->bind_result($CUENTA);
      //$stmt->fetch();
      //$stmt->close();
    
      if($result==0){
          echo json_encode(array('AR_Result' => array('Response' => 'Usuario no registrado', 'IdUser' => '0')));
       }else{          
          echo json_encode(array('AR_Result' => array('Response' => 'Inicio de sesion exitoso', 'IdUser' => $CUENTA)));
       }
 }

?>