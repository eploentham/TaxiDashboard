<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$conn = mysqli_connect($hostDB,$userDB,$passDB,$databaseName);
mysqli_set_charset($conn, "UTF8");
$sql="Select * From car_daily Where dai = '".$_GET['prov_id']."'  Order By amphur_code";


mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($resultArray);
?>