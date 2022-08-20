<?php
include('Config.php');
session_start();
$user = $_POST['MAIL'];
$pass = $_POST['PWD']; 

$username="root";  
$password="";  
$hostname = "localhost";  
//connection string with database  
$dbhandle = mysqli_connect($hostname, $username, $password)  
or die("Unable to connect to MySQL");  
echo "";  
// connect with database  
$selected = mysqli_select_db($dbhandle, "ar_schema")  
or die("Could not select examples");  
//query fire  
$result = mysqli_query($dbhandle,"select * from user;");  
$json_response = array();  
// fetch data in array format  
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {  
// Fetch data of Fname Column and store in array of row_array
$row_array['ID'] = $row['ID'];
$row_array['MAIL'] = $row['MAIL'];
$val = $row_array['MAIL'] = $row['MAIL'];
if($val == $user){
    $usuario = $val;
}
$row_array['ID_TYPE'] = $row['ID_TYPE'];

//push the values in the array  
array_push($json_response,$row_array);  
}

if ($usuario == $user){
    //echo 'Valido', $usuario, $user;
    header('Location: views/Dashboard.html');
    exit;
}
else{
    echo 'Invalido', $usuario, $user;
}
?>