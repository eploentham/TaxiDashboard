<?php

//defined("DB_HOST") ? null : define("DB_HOST", "localhost");
//defined("DB_USER") ? null : define("DB_USER", "thaihotels");
//defined("DB_PASSWORD") ? null : define("DB_PASSWORD", "Thahr30*");
//defined("DB_NAME") ? null : define("DB_NAME", "thaihotels");
defined("DB_HOST") ? null : define("DB_HOST", "taxidashboard.ccegjxy0bmku.ap-southeast-1.rds.amazonaws.com");
defined("DB_USER") ? null : define("DB_USER", "oriscom");
defined("DB_PASSWORD") ? null : define("DB_PASSWORD", "mocsiro1*");
defined("DB_NAME") ? null : define("DB_NAME", "daily_report");
defined("DB_PORT") ? null : define("DB_PORT", "3306");

$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME, DB_PORT);
mysqli_set_charset($conn, "UTF8");
//$sql="Select * From f_company_type Where active = '1' Order By comp_type_code";
//$result = mysqli_query($conn,"Select * From f_company_type Where active = '1' Order By comp_type_code");
//if ($result=mysqli_query($conn,$sql)){
//    $oComp = "<option value='0' selected='' disabled=''>ประเภทบริษัท</option>";
//    while($row = mysqli_fetch_array($result)){
//        $oComp .= '<option value='.$row["comp_type_code"].'>'.$row["comp_type_name_t"].'</option>';
//    }
//}
//function getCompany($comp){
//    $sql="Select * From f_company_type Where comp_type_id = '".$comp."' Order By comp_type_code";
//    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
//        while($row = mysqli_fetch_array($result)){
//            
//        }
//    }else{
//        return mysqli_error($conn);
//    }
//    
//}
//$sql="Select * From provinces Order By prov_code";
////$result = mysqli_query($conn,"Select * From f_company_type Where active = '1' Order By comp_type_code");
//if ($result=mysqli_query($conn,$sql)){
//    $oProv = "<option value='0' selected='' disabled=''>เลือกจังหวัด</option>";
//    while($row = mysqli_fetch_array($result)){
//        $oProv .= '<option value='.$row["prov_id"].'>'.$row["prov_name"].'</option>';
//    }
//}

?>