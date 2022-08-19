<?php 
   require_once("Connection.php");

   // Define operation
   switch($_GET["op"]){
       case 1: // C reate user
        CreateUser();
        break;
       case 2: // R ead user(s)
        ReadUser();
        break;
       case 3: // U pdate user
        UpdateUser();
        break;
       case 4: // D elete user
        DeleteUser();
        break;
       default:
        break;
   }

   // FUNCTIONS //
   function CreateUser(){

       // Asignacion de Variables 
        $FIRSTNAME = "";
        $SECONDNAME = "";
        $MIDNAME = "";
        $LASTNAME = ""; 
        $NIT = "";
        $PHONE = "";
        $MAIL = "";
        $PASSWORD = "";
        $ID_TYPE = "";

        // Verificacion que las variables vengan en el consumo del API
        if(isset($_POST["FIRSTNAME"])){
            $FIRSTNAME = $_POST["FIRSTNAME"];
        }
        if(isset($_POST["SECONDNAME"])){
            $SECONDNAME = $_POST["SECONDNAME"];
        }
        if(isset($_POST["MIDNAME"])){
            $MIDNAME = $_POST["MIDNAME"];
        }
        if(isset($_POST["LASTNAME"])){
            $LASTNAME = $_POST["LASTNAME"];
        }
        if(isset($_POST["NIT"])){
            $NIT = $_POST["NIT"];
        }
        if(isset($_POST["PHONE"])){
            $PHONE = $_POST["PHONE"];
        }
        if(isset($_POST["MAIL"])){
            $MAIL = $_POST["MAIL"];
        }
        if(isset($_POST["PASSWORD"])){
            $PASSWORD = hash('sha256', $_POST["PASSWORD"]);
        }
        if(isset($_POST["ID_TYPE"])){
            $ID_TYPE = $_POST["ID_TYPE"];
        }
        
        // Sentencia insert
        $sCmd = " INSERT INTO user ( ";
        
        if(isset($_POST["ID_TYPE"])){
            $sCmd .= "ID_TYPE,";
        }
        if(isset($_POST["FIRSTNAME"])){
            $sCmd .= "FIRSTNAME,";
        }
        if(isset($_POST["SECONDNAME"])){
            $sCmd .= "SECONDNAME,";
        }
        if(isset($_POST["MIDNAME"])){
            $sCmd .= "MIDNAME,";
        }
        if(isset($_POST["LASTNAME"])){
            $sCmd .= "LASTNAME,";
        }
        if(isset($_POST["NIT"])){
            $sCmd .= "NIT,";
        }
        if(isset($_POST["PHONE"])){
            $sCmd .= "PHONE,";
        }
        if(isset($_POST["MAIL"])){
            $sCmd .= "MAIL,";
        }
        if(isset($_POST["PASSWORD"])){
            $sCmd .= "PASSWORD,";
        }

        if(substr($sCmd, -1) == ","){
            $sCmd = substr($sCmd, 0, -1);
        }

        $sCmd .= " ) VALUES ( ";

        if(isset($_POST["ID_TYPE"])){
            $sCmd .= $ID_TYPE . ",";
        }
        if(isset($_POST["FIRSTNAME"])){
            $sCmd .= "'".$FIRSTNAME . "',";
        }
        if(isset($_POST["SECONDNAME"])){
            $sCmd .= "'".$SECONDNAME . "',";
        }
        if(isset($_POST["MIDNAME"])){
            $sCmd .= "'".$MIDNAME . "',";
        }
        if(isset($_POST["LASTNAME"])){
            $sCmd .= "'".$LASTNAME . "',";
        }
        if(isset($_POST["NIT"])){
            $sCmd .= "'".$NIT . "',";
        }
        if(isset($_POST["PHONE"])){
            $sCmd .= "'".$PHONE . "',";
        }
        if(isset($_POST["MAIL"])){
            $sCmd .= "'".$MAIL . "',";
        }
        if(isset($_POST["PASSWORD"])){
            $sCmd .= "'".$PASSWORD . "',";
        }

        if(substr($sCmd, -1) == ","){
            $sCmd = substr($sCmd, 0, -1);
        }
        $sCmd .= " )";
        //echo $sCmd;

        $enlace = conectar();
        if ($enlace->query($sCmd) === TRUE) {
            echo json_encode(array('AR_Result' => array('Response' => 'Datos registrados', 'Result' => '1')));
        } else {
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> '.$sCmd.' -> ' . $enlace->error, 'Result' => '0')));
        }
   }
   
   function ReadUser(){      

        // Asignacion de Variables 
        $NIT = ""; 
        $ID = ""; 
        $enlace = conectar();

        // Verificacion que las variables vengan en el consumo del API
        if(isset($_POST["NIT"]) || isset($_POST["ID"])){
            if(isset($_POST["NIT"])){
                $NIT = $_POST["NIT"]; 
            }
            if(isset($_POST["ID"])){
                $ID = $_POST["ID"]; 
            }
            
            $Query = "SELECT * FROM user WHERE ID != 0 ";
            
            if(isset($_POST["NIT"])){
                $Query .= " AND NIT = '". $NIT ."' ";
            }
            if(isset($_POST["ID"])){
                $Query .= " AND ID = '". $ID ."' ";
            }
            $sCmd = mysqli_query($enlace, $Query);
            if ($sCmd === FALSE){
                echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
            }
            else{
                $rows = array();
                while($r = mysqli_fetch_assoc($sCmd)) {
                    $rows[] = $r;
                }
                print json_encode(array('Users' => $rows));
            }
        }
        else
        {
            $sCmd = mysqli_query($enlace, "SELECT * FROM user ");
            if ($sCmd === FALSE){
                echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
            }else{
                $rows = array();
                while($r = mysqli_fetch_assoc($sCmd)) {
                    $rows[] = $r;
                }
                print json_encode(array('Users' => $rows));
            }
        }
   }

   function UpdateUser(){
        // Asignacion de Variables 
        $ID = "";
        $FIRSTNAME = "";
        $SECONDNAME = "";
        $MIDNAME = "";
        $LASTNAME = ""; 
        $NIT = "";
        $PHONE = "";
        $MAIL = "";
        $PASSWORD = "";
        $ID_TYPE = "";

        // Verificacion que las variables vengan en el consumo del API
        if(isset($_POST["ID"])){
            $ID = $_POST["ID"];
            
            if(isset($_POST["FIRSTNAME"])){
                $FIRSTNAME = $_POST["FIRSTNAME"];
            }
            if(isset($_POST["SECONDNAME"])){
                $SECONDNAME = $_POST["SECONDNAME"];
            }
            if(isset($_POST["MIDNAME"])){
                $MIDNAME = $_POST["MIDNAME"];
            }
            if(isset($_POST["LASTNAME"])){
                $LASTNAME = $_POST["LASTNAME"];
            }
            if(isset($_POST["NIT"])){
                $NIT = $_POST["NIT"];
            }
            if(isset($_POST["PHONE"])){
                $PHONE = $_POST["PHONE"];
            }
            if(isset($_POST["MAIL"])){
                $MAIL = $_POST["MAIL"];
            }
            if(isset($_POST["PASSWORD"])){
                $PASSWORD = hash('sha256', $_POST["PASSWORD"]);
            }
            if(isset($_POST["ID_TYPE"])){
                $ID_TYPE = $_POST["ID_TYPE"];
            }
            
            // Sentencia update
            $sCmd = " UPDATE user SET ";
            
            if(isset($_POST["ID_TYPE"])){
                $sCmd .= " ID_TYPE = " . $ID_TYPE . ",";
            }
            if(isset($_POST["FIRSTNAME"])){
                $sCmd .= " FIRSTNAME = '" . $FIRSTNAME . "',";
            }
            if(isset($_POST["SECONDNAME"])){
                $sCmd .= " SECONDNAME = '" . $SECONDNAME . "',";
            }
            if(isset($_POST["MIDNAME"])){
                $sCmd .= " MIDNAME = '" . $MIDNAME . "',";
            }
            if(isset($_POST["LASTNAME"])){
                $sCmd .= " LASTNAME = '" . $LASTNAME . "',";
            }
            if(isset($_POST["NIT"])){
                $sCmd .= " NIT = '" . $NIT . "',";
            }
            if(isset($_POST["PHONE"])){
                $sCmd .= " PHONE = '" . $PHONE . "',";
            }
            if(isset($_POST["MAIL"])){
                $sCmd .= " MAIL = '" . $MAIL . "',";
            }
            if(isset($_POST["PASSWORD"])){
                $sCmd .= " PASSWORD = '" . $PASSWORD . "',";
            }

            if(substr($sCmd, -1) == ","){
                $sCmd = substr($sCmd, 0, -1);
            }

            $sCmd .= " WHERE ID = '". $ID ."'; ";
            //echo $sCmd;

            $enlace = conectar();
            if ($enlace->query($sCmd) === TRUE) {
                echo json_encode(array('AR_Result' => array('Response' => 'Datos actualizados', 'Result' => '1')));
            } else {
                echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
            }
        }else{
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se ha especificado el ID del usuario', 'Result' => '0')));          
        }
   }

   function DeleteUser(){
         // Asignacion de Variables 
         $NIT = "";
         $ID = "";
 
         // Verificacion que las variables vengan en el consumo del API
         if(isset($_POST["NIT"]) || isset($_POST["ID"])){

            if(isset($_POST["NIT"])){
                $NIT = $_POST["NIT"];
            }
            if(isset($_POST["ID"])){
                $ID = $_POST["ID"];
            }
            
            $sCmd = " DELETE FROM user WHERE (1=0) ";

            if(isset($_POST["NIT"])){
                $sCmd .= " OR (NIT = '". $NIT ."')";
            }
            
            if(isset($_POST["ID"])){
                $sCmd .= " OR (ID = '". $ID ."')";
            }
         
             $enlace = conectar();
             if ($enlace->query($sCmd) === TRUE) {
                 echo json_encode(array('AR_Result' => array('Response' => 'Usuario eliminado', 'Result' => '1')));
             } else {
                 echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
             }
         }
         else
         {
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el NIT del usuario', 'Result' => '0')));
         }
   }

?>