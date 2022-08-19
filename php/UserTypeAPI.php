<?php 
   require_once("Connection.php");

   // Define operation
   switch($_GET["op"]){
       case 1: // C reate user
        CreateUserType();
        break;
       case 2: // R ead user(s)
        ReadUserType();
        break;
       case 3: // U pdate user
        UpdateUserType();
        break;
       case 4: // D elete user
        DeleteUserType();
        break;
       default:
        break;
   }

   // FUNCTIONS //
   function CreateUserType(){

   }
   
   function ReadUserType(){      

        // Asignacion de Variables 
        $ID = ""; 
        $enlace = conectar();

        // Verificacion que las variables vengan en el consumo del API
        if(isset($_POST["ID"])){
            $ID = $_POST["ID"]; 
                    
            $sCmd = mysqli_query($enlace, "SELECT * FROM user_type WHERE ID = '". $ID ."' ");
            if ($sCmd === FALSE){
                echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
            }
            else{
                $rows = array();
                while($r = mysqli_fetch_assoc($sCmd)) {
                    $rows[] = $r;
                }
                print json_encode(array('UsersType' => $rows));
            }
        }
        else
        {
            $sCmd = mysqli_query($enlace, "SELECT * FROM user_type ");
            if ($sCmd === FALSE){
                echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
            }else{
                $rows = array();
                while($r = mysqli_fetch_assoc($sCmd)) {
                    $rows[] = $r;
                }
                print json_encode(array('UsersType' => $rows));
            }
        }
   }

   function UpdateUserType(){
       
   }

   function DeleteUserType(){

   }

?>