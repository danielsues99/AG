<?php 
   require_once("Connection.php");

   // Define operation
   switch($_GET["op"]){
       case 1: // C reate Product category
        CreateProductCategory();
        break;
       case 2: // R ead Product(s) category
        ReadLocation();
        break;
       case 3: // U pdate Product category
        UpdateProductCategory();
        break;
       case 4: // D elete Product category
        DeleteProductCategory();
        break;
       default:
        break;
   }

   // FUNCTIONS //
   function CreateProductCategory(){

      // Asignacion de Variables 
       $DESCRIPTION = "";

       // Verificacion que las variables vengan en el consumo del API
       if(isset($_POST["DESCRIPTION"])){
           $DESCRIPTION = $_POST["DESCRIPTION"];
           
            // Sentencia insert
            $sCmd = " INSERT INTO product_category (DESCRIPTION) VALUES('".$DESCRIPTION."') ";
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
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico la descripcion del producto', 'Result' => '0')));
       }
       
  }

  function ReadLocation(){

   // Asignacion de Variables 
    $ID = "";
    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
        $ID = $_POST["ID"];
        
        $sCmd = mysqli_query($enlace, "SELECT * FROM product_category WHERE ID = ". $ID ." ");
        if ($sCmd === FALSE){
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
        }
        else{
            $rows = array();
            while($r = mysqli_fetch_assoc($sCmd)) {
                $rows[] = $r;
            }
            print json_encode(array('ProductsCategory' => $rows));
        }
    }
    else
    {
      $sCmd = mysqli_query($enlace, "SELECT * FROM location ");
      if ($sCmd === FALSE){
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
      }else{
          $rows = array();
          while($r = mysqli_fetch_assoc($sCmd)) {
              $rows[] = $r;
          }
          print json_encode(array('Locations' => $rows));
      }
    }
    
  }

  function UpdateProductCategory(){

   // Asignacion de Variables 
    $ID = "";
    $DESCRIPTION = "";

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
      $ID = $_POST["ID"];
      if(isset($_POST["DESCRIPTION"])){
        $DESCRIPTION = $_POST["DESCRIPTION"];
        
         // Sentencia insert
         $sCmd = " UPDATE product_category SET DESCRIPTION = '".$DESCRIPTION."' WHERE ID = ".$ID;
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
         echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico la descripcion del producto', 'Result' => '0')));
      }
    }
    else
    {
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID de la categoria producto', 'Result' => '0')));
    }
    
  }

  function DeleteProductCategory(){

   // Asignacion de Variables 
    $ID = "";
    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"])){
        $ID = $_POST["ID"];
        
        $sCmd = mysqli_query($enlace, "DELETE FROM product_category WHERE ID = ". $ID ." ");
        if ($sCmd === FALSE){
            echo json_encode(array('AR_Result' => array('Response' => 'Error -> '. $enlace->error, 'Result' => '0')));
        }
        else{
         echo json_encode(array('AR_Result' => array('Response' => 'Categoria de producto eliminada', 'Result' => '1')));
         }
    }
    else
    {
      echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se especifico el ID de la categoria producto', 'Result' => '0')));
    }
    
  }      
   
?>