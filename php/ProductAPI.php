<?php 
   require_once("Connection.php");

   // Define operation
   switch($_GET["op"]){
       case 1: // C reate Product
        CreateProduct();
        break;
       case 2: // R ead Product(s)
        ReadProduct();
        break;
       case 3: // U pdate Product
        UpdateProduct();
        break;
       case 4: // D elete Product
        DeleteProduct();
        break;
       default:
        break;
   }

   // FUNCTIONS //
   function CreateProduct(){

      // Asignacion de Variables 
       $SERIAL = "";
       $ID_TYPE_STATUS = "";
       $ID_TYPE = "";
       $ID_LOCATION = "";

       // Verificacion que las variables vengan en el consumo del API
       if(isset($_POST["SERIAL"]) && isset($_POST["ID_TYPE_STATUS"]) && isset($_POST["ID_TYPE"]) && isset($_POST["ID_LOCATION"])){
           $SERIAL = $_POST["SERIAL"];
           $ID_TYPE_STATUS = $_POST["ID_TYPE_STATUS"];
           $ID_TYPE = $_POST["ID_TYPE"];    
           $ID_LOCATION = $_POST["ID_LOCATION"];    
           
            // Sentencia insert
            $sCmd = " INSERT INTO product (SERIAL,ID_TYPE_STATUS,ID_TYPE,ID_LOCATION) VALUES('".$SERIAL."','".$ID_TYPE_STATUS."','".$ID_TYPE."','".$ID_LOCATION."') ";
            //echo $sCmd;

            $enlace = conectar();
            if ($enlace->query($sCmd) === TRUE) 
            {
               echo json_encode(array('AR_Result' => array('Response' => 'Datos registrados', 'Result' => '1')));
            } 
            else 
            {
               echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
            }
       }
       else
       {
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se ha especificado la informacion completa ([SERIAL],[ID_TYPE_STATUS],[ID_TYPE],[ID_LOCATION])', 'Result' => '0')));
       }
       
  }

  function ReadProduct(){

   // Asignacion de Variables 
    $ID = "";
    $SERIAL = "";
    $ID_TYPE_STATUS = "";
    $ID_TYPE = "";
    $ID_LOCATION = "";

    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"]) || isset($_POST["SERIAL"]) || isset($_POST["ID_LOCATION"]) || isset($_POST["ID_TYPE"]) || isset($_POST["ID_TYPE_STATUS"])){
        
        $Query = " SELECT * FROM product WHERE ID != 0 ";
        if(isset($_POST["ID"])){
          $ID = $_POST["ID"];
          $Query .= " AND ID = ".$ID." ";
        }
        if(isset($_POST["SERIAL"])){
          $SERIAL = $_POST["SERIAL"];
          $Query .= " AND SERIAL = ".$SERIAL." ";
        }
        if(isset($_POST["ID_TYPE_STATUS"])){
          $ID_TYPE_STATUS = $_POST["ID_TYPE_STATUS"];
          $Query .= " AND ID_TYPE_STATUS = ".$ID_TYPE_STATUS." ";
        }
        if(isset($_POST["ID_TYPE"])){
          $ID_TYPE = $_POST["ID_TYPE"];
          $Query .= " AND ID_TYPE = ".$ID_TYPE." ";
        }
        if(isset($_POST["ID_LOCATION"])){
          $ID_LOCATION = $_POST["ID_LOCATION"];
          $Query .= " AND ID_LOCATION = ".$ID_LOCATION." ";
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
            print json_encode(array('Products' => $rows));
        }
    }
    else
    {
      $sCmd = mysqli_query($enlace, "SELECT * FROM product ");
      if ($sCmd === FALSE){
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
      }else{
          $rows = array();
          while($r = mysqli_fetch_assoc($sCmd)) {
              $rows[] = $r;
          }
          print json_encode(array('Products' => $rows));
      }
    }
    
  }

  function ReadProductInfo(){

    // Asignacion de Variables 
     $SERIAL = "";
 
     $enlace = conectar();
 
     // Verificacion que las variables vengan en el consumo del API
     if(isset($_POST["SERIAL"])){
         
         $Query = " SELECT p.SERIAL, pt.DESCRIPTION, pt.PRICE FROM product p INNER JOIN product_type pt ON pt.ID = p.ID_TYPE WHERE p.SERIAL = '".$SERIAL."' ";
 
         $sCmd = mysqli_query($enlace, $Query);
         if ($sCmd === FALSE){
             echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
         }
         else{
             $rows = array();
             while($r = mysqli_fetch_assoc($sCmd)) {
                 $rows[] = $r;
             }
             print json_encode(array('Products' => $rows));
         }
     }
     else
     {
       $sCmd = mysqli_query($enlace, "SELECT * FROM product ");
       if ($sCmd === FALSE){
           echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
       }else{
           $rows = array();
           while($r = mysqli_fetch_assoc($sCmd)) {
               $rows[] = $r;
           }
           print json_encode(array('Products' => $rows));
       }
     }
     
   }

  function UpdateProduct(){

   // Asignacion de Variables 
    $ID = "";
    $SERIAL = "";
    $ID_TYPE_STATUS = "";
    $ID_TYPE = "";
    $ID_LOCATION = "";

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
      $ID = $_POST["ID"];

      if(isset($_POST["SERIAL"])){
        $SERIAL = $_POST["SERIAL"];
      }
      if(isset($_POST["ID_TYPE_STATUS"])){
        $ID_TYPE_STATUS = $_POST["ID_TYPE_STATUS"];
      }
      if(isset($_POST["ID_TYPE"])){
        $ID_TYPE = $_POST["ID_TYPE"];
      }
      if(isset($_POST["ID_LOCATION"])){
        $ID_LOCATION = $_POST["ID_LOCATION"];
      }
        
         // Sentencia insert
         $sCmd = " UPDATE product SET ";

         if(isset($_POST["SERIAL"])){
          $sCmd .= " SERIAL = '".$SERIAL."',";
        }
        if(isset($_POST["ID_TYPE_STATUS"])){
          $sCmd .= " ID_TYPE_STATUS = '".$ID_TYPE_STATUS."',";
        }
        if(isset($_POST["ID_TYPE"])){
          $sCmd .= " ID_TYPE = ".$ID_TYPE.",";
        }
        if(isset($_POST["ID_LOCATION"])){
          $sCmd .= " ID_LOCATION = ".$ID_LOCATION.",";
        }
        if(substr($sCmd, -1) == ","){
            $sCmd = substr($sCmd, 0, -1);
        }

        $sCmd .= " WHERE ID = ".$ID;
        //echo $sCmd;

         $enlace = conectar();
         if ($enlace->query($sCmd) === TRUE) 
         {
            echo json_encode(array('AR_Result' => array('Response' => 'Datos actualizados', 'Result' => '1')));
         } 
         else 
         {
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
         }
    }
    else
    {
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID del producto', 'Result' => '0')));
    }
    
  }

  function DeleteProduct(){

   // Asignacion de Variables 
    $ID = "";
    $SERIAL = "";
    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    
    
    
    if(isset($_POST["ID"]) || isset($_POST["SERIAL"])){
      
      if(isset($_POST["ID"]))
      {
        $ID = $_POST["ID"];
        $sCmd = mysqli_query($enlace, "DELETE FROM product WHERE ID = ". $ID ." ");
      }
      
      if(isset($_POST["SERIAL"])){
        $SERIAL = $_POST["SERIAL"];
        $sCmd = mysqli_query($enlace, "DELETE FROM product WHERE SERIAL = '". $SERIAL ."' ");
      }        
       
        if ($sCmd === FALSE){
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
        }
        else{
         echo json_encode(array('AR_Result' => array('Response' => 'Producto eliminado', 'Result' => '1')));
         }
    }
    else
    {
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID o SERIAL de producto', 'Result' => '0')));
    }
    
  }      
   
?>