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
       default:
        break;
   }

   // FUNCTIONS //
   function CreateProduct(){

      // Asignacion de Variables 
       $DATETIME = "";
       $ID_TYPE = "";
       $ID_PRODUCT = "";
       $ID_USER = "";

       // Verificacion que las variables vengan en el consumo del API
       if(isset($_POST["DATETIME"]) && isset($_POST["ID_TYPE"]) && isset($_POST["ID_PRODUCT"]) && isset($_POST["ID_USER"])){
           $DATETIME = $_POST["DATETIME"];
           $ID_TYPE = $_POST["ID_TYPE"];
           $ID_PRODUCT = $_POST["ID_PRODUCT"];
           $ID_USER = $_POST["ID_USER"];
           
            // Sentencia insert
            $sCmd = " INSERT INTO event_log (DATETIME,ID_TYPE,ID_PRODUCT,ID_USER) VALUES('".$DATETIME."','".$ID_TYPE."','".$ID_PRODUCT."','".$ID_USER."') ";
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
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> No se ha especificado la informacion completa ([DATETIME],[ID_TYPE],[ID_PRODUCT],[ID_USER])', 'Result' => '0')));
       }
       
  }

  function ReadProduct(){

   // Asignacion de Variables 
    $ID = "";
    $DATETIME = "";
    $ID_TYPE = "";
    $ID_PRODUCT = "";
    $ID_USER = "";
    $START_DATE = "";
    $END_DATE = "";

    $enlace = conectar();

    // Verificacion que las variables vengan en el consumo del API
    if(isset($_POST["ID"]) || isset($_POST["DATETIME"]) || isset($_POST["ID_TYPE"]) 
    || isset($_POST["ID_PRODUCT"]) || isset($_POST["ID_USER"])
    || isset($_POST["START_DATE"]) || isset($_POST["END_DATE"])){
        
        $Query = " SELECT * FROM event_log WHERE ID != 0 ";
        if(isset($_POST["ID"])){
          $ID = $_POST["ID"];
          $Query .= " AND ID = ".$ID." ";
        }
        if(isset($_POST["DATETIME"])){
          $DATETIME = $_POST["DATETIME"];
          $Query .= " AND DATETIME = '".$DATETIME."' ";
        }
        if(isset($_POST["ID_TYPE"])){
          $ID_TYPE = $_POST["ID_TYPE"];
          $Query .= " AND ID_TYPE = ".$ID_TYPE." ";
        }
        if(isset($_POST["ID_PRODUCT"])){
          $ID_PRODUCT = $_POST["ID_PRODUCT"];
          $Query .= " AND ID_PRODUCT = ".$ID_PRODUCT." ";
        }
        if(isset($_POST["ID_USER"])){
          $ID_USER = $_POST["ID_USER"];
          $Query .= " AND ID_USER = ".$ID_USER." ";
        }
        if(isset($_POST["START_DATE"])){
          $START_DATE = $_POST["START_DATE"];
          $Query .= " AND DATETIME >= '".$START_DATE."' ";
        }
        if(isset($_POST["END_DATE"])){
          $END_DATE = $_POST["END_DATE"];
          $Query .= " AND DATETIME <= '".$END_DATE."' ";
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
            print json_encode(array('EventsLog' => $rows));
        }
    }
    else
    {
      $sCmd = mysqli_query($enlace, "SELECT * FROM event_log ");
      if ($sCmd === FALSE){
          echo json_encode(array('AR_Result' => array('Response' => 'Error -> ' . $enlace->error, 'Result' => '0')));
      }else{
          $rows = array();
          while($r = mysqli_fetch_assoc($sCmd)) {
              $rows[] = $r;
          }
          print json_encode(array('EventsLog' => $rows));
      }
    }
    
  }

   
?>