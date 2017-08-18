<?php
require_once("inc/init.php"); 
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
mysqli_set_charset($conn, "UTF8");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_GET["daily_date"])){
    $dailyDate = $_GET["daily_date"];
}
$tr="";
$row1=0;
$sql="SELECT daily_date, car_id, imei, distance FROM car_daily "
    ."Where daily_date = '".$dailyDate."' and income >0 "
    ."Order By car_id ;";
if ($result=mysqli_query($conn,$sql) or die(mysqli_error($conn))){
    while($row = mysqli_fetch_array($result)){
        $row1++;
        $imei=$row["imei"];
        
        $carId=$row["car_id"];
        $dist=$row["distance"];
        $tr.='<tr><td>'.$row1.'</td><td>'.$carId.'</td><td>'.$dist.'</td></tr>';
    }
}else{
    echo mysqli_error($conn);
}
?>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-sm-12">
            <div class="col-sm-12 well">
                <table>
                    <caption></caption>
                    <thead>
                        <tr>
                        <th>ลำดับ</th>
                        <th>ทะเบียนรถ</th>
                        <th>ระยะทางทั้งหมด</th>
                        <th>income</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php echo $tr;?>
                    </tbody>
                    
                </table>
                
            </div>
        </article>
    </div>
</section>
