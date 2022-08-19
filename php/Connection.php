<?php
        function Conectar(){
            $Connection = new mysqli("localhost", "admin", "admin1234", "ar_schema", 3306);
            if($Connection->connect_errno){
                exit("Fallo en la conexión al servidor");
            }
            return $Connection;
        }
?>

