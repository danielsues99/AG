<?php 
   require_once("Connection.php");

   // Define operation
   switch($_GET["op"]){
       case 1: // C reate Product Type
        CreateProductType();
        break;
       case 2: // R ead Product(s) Type
        ReadProductType();
        break;
       case 3: // U pdate Product Type
        UpdateProductType();
        break;
       case 4: // D elete Product Type
        DeleteProductType();
        break;
       default:
        break;
   }

   // FUNCTIONS //
   function CreateProductType(){

      // Asignacion de Variables 
       $DESCRIPTION = "";
       $PRICE = "";
       $ID_CATEGORY = "";

       // Verificacion que las variables vengan en el consumo del API
       if(isset($_POST["DESCRIPTION"]) && isset($_POST["PRICE"]) && isset($_POST["ID_CATEGORY"])){
           $DESCRIPTION = $_POST["DESCRIPTION"];
           $PRICE = $_POST["PRICE"];
           $ID_CATEGORY = $_POST["ID_CATEGORY"];    
           
            // Sentencia insert
            $sCmd = " INSERT INTO product_type (ID_CATEGORY,DESCRIPTION,PRICE) VALUES('".$ID_CATEGORY."','".$DESCRIPTION."','".$PRICE."') ";
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
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se ha especificado la informacion completa ([DESCRIPTION],[PRICE],[ID_CATEGORY])', 'Result' => '0')));
       }
       
  }

  function ReadProductType(){

   // Asignacion de Variables 
    $ID = "";
    $ID_CATEGORY = "";
    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"]) || isset($_POST["ID_CATEGORY"])){
        
        $Query = " SELECT * FROM product_type WHERE ID != 0 ";
        if(isset($_POST["ID"])){
          $ID = $_POST["ID"];
          $Query .= " AND ID = ".$ID." ";
        }
        if(isset($_POST["ID_CATEGORY"])){
          $ID_CATEGORY = $_POST["ID_CATEGORY"];
          $Query .= " AND ID_CATEGORY = ".$ID_CATEGORY." ";
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
            print json_encode(array('ProductsType' => $rows));
        }
    }
    else
    {
      $sCmd = mysqli_query($enlace, "SELECT * FROM product_type ");
      if ($sCmd === FALSE){
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
      }else{
          $rows = array();
          while($r = mysqli_fetch_assoc($sCmd)) {
              $rows[] = $r;
          }
          print json_encode(array('ProductsType' => $rows));
      }
    }
    
  }

  function UpdateProductType(){

   // Asignacion de Variables 
    $ID = "";
    $DESCRIPTION = "";
    $PRICE = "";
    $ID_CATEGORY = "";

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
      $ID = $_POST["ID"];

      if(isset($_POST["DESCRIPTION"])){
        $DESCRIPTION = $_POST["DESCRIPTION"];
      }
      if(isset($_POST["PRICE"])){
        $PRICE = $_POST["PRICE"];
      }
      if(isset($_POST["ID_CATEGORY"])){
        $ID_CATEGORY = $_POST["ID_CATEGORY"];
      }
        
         // Sentencia insert
         $sCmd = " UPDATE product_type SET ";

         if(isset($_POST["DESCRIPTION"])){
          $sCmd .= " DESCRIPTION = '".$DESCRIPTION."',";
        }
        if(isset($_POST["PRICE"])){
          $sCmd .= " PRICE = '".$PRICE."',";
        }
        if(isset($_POST["ID_CATEGORY"])){
          $sCmd .= " ID_CATEGORY = ".$ID_CATEGORY.",";
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
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID del tipo de producto', 'Result' => '0')));
    }
    
  }

  function DeleteProductType(){

   // Asignacion de Variables 
    $ID = "";
    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
        $ID = $_POST["ID"];
        
        $sCmd = mysqli_query($enlace, "DELETE FROM product_type WHERE ID = ". $ID ." ");
        if ($sCmd === FALSE){
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
        }
        else{
         echo json_encode(array('AR_Result' => array('Response' => 'Tipo de producto eliminado', 'Result' => '1')));
         }
    }
    else
    {
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID del tipo de producto', 'Result' => '0')));
    }
    
  }      
   
?>