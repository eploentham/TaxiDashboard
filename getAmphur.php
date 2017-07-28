<?php
require_once("inc/init.php");
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$objConnect = mysql_connect("http://tossakan.com",'tossakan_payroll','payroll');
//$databaseName="at_healthcare";
//$userDB="root";
//$passDB="";
//$hostDB="localhost";
$conn = mysqli_connect($hostDB,$userDB,$passDB,$databaseName);
mysqli_set_charset($conn, "UTF8");

$resultArray = array();
if($_GET['flagPage']=="amphur"){
    $sql="Select * From amphures Where prov_id = '".$_GET['prov_id']."'  Order By amphur_code";
    if ($result=mysqli_query($conn,$sql)){
        $ok="";
        $err="";
        if(!$result){
            $ok="0";
            $err= mysql_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){        
                $tmp["amphur_id"] = $row["amphur_id"];
                $tmp["amphur_name"] = $row["amphur_name"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }
}else if($_GET['flagPage']=="district"){
    $sql="Select d.*, z.zipcode From districts d Left Join zipcodes z On d.district_code = z.district_code Where d.amphur_id = '".$_GET['amphur_id']."' Order By d.district_code";
    if ($result=mysqli_query($conn,$sql)){
        $ok="";
        $err="";
        if(!$result){
            $ok="0";
            $err= mysqli_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){        
                $tmp["district_id"] = $row["district_id"];
                $tmp["district_name"] = $row["district_name"];
                $tmp["zipcode"] = $row["zipcode"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }
}else if($_GET['flagPage']=="zipcode"){
    $sql="Select z.zipcode From zipcodes z Left Join districts d On z.district_code = d.district_code Where district_id = '".$_GET['district_id']."' ";
    if ($result=mysqli_query($conn,$sql)){
        $ok="";
        $err="";
        if(!$result){
            $ok="0";
            $err= mysqli_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){
                $tmp["zipcode"] = $row["zipcode"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }
}else if($_GET['flagPage']=="goSearch"){
    $sql="Select go.goods_name, go.goods_id, go.price, go.cost, IFNULL(go.holes,'') as holes, ifnull(go.side,'') as side, ifnull(go.dia_meter,'') as dia_meter, ifnull(go.length,'') as length, go.unit_id, go.goods_type_id, got.goods_type_name "
        ."From b_goods go Left Join b_goods_type got on go.goods_type_id = got.goods_type_id "
        ."Where goods_code = '".$_GET['goods_code']."' ";
    if ($result=mysqli_query($conn,$sql)){
        if(!$result){
            $ok="0";
            $err= mysqli_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){
                $tmp["goods_name"] = $row["goods_name"];
                $tmp["goods_id"] = $row["goods_id"];
                $tmp["price"] = $row["price"];
                $tmp["cost"] = $row["cost"];
                $tmp["goods_type_name"] = $row["goods_type_name"];
                $tmp["holes"] = $row["holes"];
                $tmp["side"] = $row["side"];
                $tmp["dia_meter"] = $row["dia_meter"];
                $tmp["length"] = $row["length"];
                $tmp["unit_id"] = $row["unit_id"];
                $tmp["goods_type_id"] = $row["goods_type_id"];
                if($row["goods_type_id"]="05233f7d-225b-11e7-b800-1c1b0d8ca1a0"){
                    $tmp["goods_name1"] = $row["goods_name"]." Holes [".$row["holes"]."], Side [".$row["side"]."]";
                }else{
                    $tmp["goods_name1"] = $row["goods_name"]." Dia meter ".$row["dia_meter"]."], Length [".$row["length"]."]";
                }
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }
}else if($_GET['flagPage']=="login"){
    //$sql="Select * From b_staff Where staff_username = '".$_GET['user_name']."' and active = '1' and staff_password = '".$_GET['password']."' ";
    $sql="Select * From b_staff  ";
    //$result = mysqli_query($con, $SQL)or die(mysqli_error($connection));
    //$result = mysqli_query($con,$Query) or die(mysqli_error());  
    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
        if(!$result){
            $ok="0";
            $err= mysqli_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            $tmp["success"] = $ok;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            $tmp["success"] = $ok;
            $num_rows = mysqli_num_rows($result);
            $tmp["rows"] = $num_rows;
            //$tmp["database"] = $databaseName;
            //$tmp["host"] = $hostDB;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){
                $tmp["staff_name_t"] = $row["staff_name_t"];
                $tmp["staff_lastname_t"] = $row["staff_lastname_t"];
                $_SESSION['orc_user_staff_name'] = $tmp["staff_name_t"].".".$tmp["staff_lastname_t"];
                //$_SESSION['at_user'] = "";
                //$tmp["price"] = $row["price"];
                //$tmp["unit_id"] = $row["unit_id"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }else{
        //echo($query.' '.mysqli_error()
    }
}else if($_GET['flagPage']=="drawSearch"){
    $draDate1=substr($_GET["draw_date1"],strlen($_GET["draw_date1"])-4)."-".substr($_GET["draw_date1"],3,2)."-".substr($_GET["draw_date1"],0,2);
    $draDate2=substr($_GET["draw_date2"],strlen($_GET["draw_date2"])-4)."-".substr($_GET["draw_date2"],3,2)."-".substr($_GET["draw_date2"],0,2);
    $sql="Select draw_id,draw_doc, ifnull(description,'-') as description From t_goods_draw Where draw_date >= '".$draDate1."' and draw_date <= '".$draDate2."'  Order By draw_doc";
    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
        $ok="";
        $err="";
        if(!$result){
            $ok="0";
            $err= mysql_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            //$tmp["sql"] = $sql;
            //array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){   
                $tmp["draw_id"] = $row["draw_id"];
                $tmp["draw_doc"] = $row["draw_doc"];
                $tmp["description"] = $row["description"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }else{
        
    }
}else if($_GET['flagPage']=="gen_rec"){
    $sql = "Select count(1) as cnt From t_goods_rec ";
    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
        $ok="";
        $err="";
        if(!$result){
            $ok="0";
            $err= mysql_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            array_push($resultArray,$tmp);
        }else{
            $year = date("Y");
            $year = substr($year, 2);
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            $cnt="";
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){
                if(is_null($row["cnt"])){
                    $cnt = "0";
                }else{
                    $cnt = $row["cnt"];
                }
                $cnt = intval($cnt)+1;
                $cnt = "00000".$cnt;
            }
            $doc = "RE".$year. substr($cnt, strlen($cnt)-5);
            $tmp["doc"] = $doc;
            array_push($resultArray,$tmp);
        }
        $result->free();
    }
}else if($_GET['flagPage']=="rpt_daily_rec_detail"){
    $recDate1=substr($_GET["rec_date1"],strlen($_GET["rec_date1"])-4)."-".substr($_GET["rec_date1"],3,2)."-".substr($_GET["rec_date1"],0,2);
    $recDate2=substr($_GET["rec_date2"],strlen($_GET["rec_date2"])-4)."-".substr($_GET["rec_date2"],3,2)."-".substr($_GET["rec_date2"],0,2);
    $sql="Select rec.rec_doc, go.goods_code, go.goods_name, recd.qty, un.unit_name,rec.rec_date "
        ."From t_goods_rec_detail recd "
        ."Left Join t_goods_rec rec On recd.rec_id = rec.rec_id "
        ."Left Join b_goods go On recd.goods_id = go.goods_id "
        ."Left Join b_unit un On recd.unit_id = un.unit_id "
        ."Where rec.rec_date >= '".$recDate1."' and rec.rec_date <= '".$recDate2."' and rec.active='1' ";
    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
        while($row = mysqli_fetch_array($result)){
            $tmp = array();
            $tmp["rec_doc"] = $row["rec_doc"];
            $tmp["goods_code"] = $row["goods_code"];
            $tmp["goods_name"] = $row["goods_name"];
            $tmp["qty"] = $row["qty"];
            $tmp["unit_name"] = $row["unit_name"];
            $tmp["rec_date"] = $row["rec_date"];
            array_push($resultArray,$tmp);
        }
        $result->free();
    }else{
        
    }
}else if($_GET['flagPage']=="checkUser"){
    $sql="Select * From b_staff Where staff_username = '".$_GET['staff_username']."'";
    
    if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
        if(!$result){
            $ok="0";
            $err= mysqli_error();
            $tmp = array();
            $tmp["error"] = $err;
            $tmp["sql"] = $sql;
            $tmp["success"] = $ok;
            $tmp["rows"] = "0";
            array_push($resultArray,$tmp);
        }else{
            $ok="1";
            $tmp = array();
            $tmp["sql"] = $sql;
            $tmp["success"] = $ok;
            $num_rows = mysqli_num_rows($result);
            $tmp["rows"] = $num_rows;
            //$tmp["database"] = $databaseName;
            //$tmp["host"] = $hostDB;
            array_push($resultArray,$tmp);
            while($row = mysqli_fetch_array($result)){
                $tmp["staff_name_t"] = $row["staff_name_t"];
                $tmp["staff_lastname_t"] = $row["staff_lastname_t"];
                $_SESSION['orc_user_staff_name'] = $tmp["staff_name_t"]."".$tmp["staff_lastname_t"];
                //$_SESSION['at_user'] = "";
                //$tmp["price"] = $row["price"];
                //$tmp["unit_id"] = $row["unit_id"];
                array_push($resultArray,$tmp);
            }
        }
        $result->free();
    }else{
        //echo($query.' '.mysqli_error()
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($resultArray);
?>